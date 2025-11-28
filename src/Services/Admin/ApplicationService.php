<?php

namespace App\Services\Admin;

use App\Models\JoinApplicationModel;
use App\Models\PersonilModel;
use App\Services\Shared\FileUploadService;
use App\Services\External\AssessorService;
use PDO;

/**
 * ApplicationService
 * 
 * Service untuk admin application management
 */
class ApplicationService
{
    private $applicationModel;
    private $personilModel;
    private $fileService;
    private $assessorService;
    
    public function __construct()
    {
        $this->applicationModel = new JoinApplicationModel();
        $this->personilModel = new PersonilModel();
        $this->fileService = new FileUploadService();
        $this->assessorService = new AssessorService();
    }
    
    /**
     * Get applications with filters and pagination
     * 
     * @param array $rawFilters Raw filters dari $_GET
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getApplicationsWithFilters(array $rawFilters, int $page = 1, int $limit = 10): array
    {
        // Normalize filters - Service menangani logika filtering
        $filters = $this->normalizeFilters($rawFilters);
        
        $offset = ($page - 1) * $limit;
        
        $applications = $this->applicationModel->getApplicationsForAdmin($filters, $limit, $offset);
        $totalApplications = $this->applicationModel->countApplicationsForAdmin($filters);
        $totalPages = ceil($totalApplications / $limit);
        $stats = $this->applicationModel->getApplicationStats();
        
        return [
            'applications' => $applications,
            'totalApplications' => $totalApplications,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'offset' => $offset,
            'stats' => $stats
        ];
    }
    
    /**
     * Normalize and sanitize filters
     * 
     * @param array $rawFilters
     * @return array
     */
    private function normalizeFilters(array $rawFilters): array
    {
        $filters = [];
        
        if (!empty($rawFilters['search'])) {
            $filters['search'] = trim($rawFilters['search']);
        }
        
        if (!empty($rawFilters['status']) && $rawFilters['status'] !== 'all') {
            $filters['status'] = $rawFilters['status'];
        }
        
        if (!empty($rawFilters['prodi']) && $rawFilters['prodi'] !== 'all') {
            $filters['prodi'] = $rawFilters['prodi'];
        }
        
        return $filters;
    }
    
    /**
     * Get application by ID
     */
    public function getApplicationById(int $id): ?array
    {
        return $this->applicationModel->getApplicationById($id);
    }
    
    /**
     * Update application status
     */
    public function updateStatus(int $id, string $status): array
    {
        // Validate
        if (trim($status) === '') {
            throw new \Exception('Status harus diisi');
        }
        
        $application = $this->applicationModel->getApplicationById($id);
        if (!$application) {
            throw new \Exception('Application tidak ditemukan');
        }
        
        // Update status
        if (!$this->applicationModel->updateApplicationStatus($id, $status)) {
            throw new \Exception('Gagal mengupdate status');
        }
        
        // Handle accepted status
        if ($status === 'accepted') {
            return $this->handleAcceptedApplication($application);
        }
        
        return ['message' => 'Status berhasil diupdate'];
    }
    
    /**
     * Handle accepted application (create personil and invitation)
     */
    private function handleAcceptedApplication(array $application): array
    {
        $db = \App\Database::getConnection();
        
        // Check if personil exists
        $stmt = $db->prepare("SELECT id FROM personil WHERE email = :email");
        $stmt->bindParam(':email', $application['email']);
        $stmt->execute();
        $existingPersonil = $stmt->fetch();
        
        if ($existingPersonil) {
            return ['message' => 'Status berhasil diupdate (Personil sudah ada sebelumnya)'];
        }
        
        // Create personil
        $personilData = [
            'nama_lengkap' => $application['nama_lengkap'],
            'nim_nip' => $application['nim'], // Field 'nim' di join_application
            'password' => null, // Will be set later via external program
            'role' => 'talent',
            'spesialisasi' => null,
            'email' => $application['email'],
            'phone' => $application['phone'],
            'location' => null,
            'tanggal_bergabung' => date('Y-m-d'),
            'bio' => '',
            'skills' => json_encode([]),
            'foto_url' => null
        ];
        
        $personilId = $this->personilModel->createPersonil($personilData);
        
        if (!$personilId) {
            throw new \Exception('Gagal membuat personil');
        }
        
        return [
            'message' => 'Status berhasil diupdate dan personil telah dibuat',
            'personil_id' => $personilId
        ];
    }
    
    /**
     * Update admin notes
     */
    public function updateNotes(int $id, string $notes): bool
    {
        $application = $this->applicationModel->getApplicationById($id);
        if (!$application) {
            throw new \Exception('Application tidak ditemukan');
        }
        
        if (!$this->applicationModel->updateAdminNotes($id, $notes)) {
            throw new \Exception('Gagal menyimpan catatan');
        }
        
        return true;
    }
    
    /**
     * Delete application
     */
    public function deleteApplication(int $id): bool
    {
        $application = $this->applicationModel->getApplicationById($id);
        if (!$application) {
            throw new \Exception('Application tidak ditemukan');
        }
        
        // Delete CV file
        if (!empty($application['cv_file_path'])) {
            $this->fileService->deleteFile($application['cv_file_path']);
        }
        
        return $this->applicationModel->deleteApplication($id);
    }

    /**
     * Generate or fetch assessment summary
     * Returns associative array with 'summary' (array) and 'source' (string: 'cached'|'generated')
     */
    public function generateOrGetSummary(int $id, ?string $githubUrl, ?string $cvPath): array
    {
        $application = $this->applicationModel->getApplicationById($id);
        if (!$application) {
            throw new \Exception('Application tidak ditemukan');
        }

        // If summary already exists, return it
        if (!empty($application['assessor_summary'])) {
            $decoded = json_decode($application['assessor_summary'], true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return [
                    'summary' => $decoded,
                    'source' => 'cached'
                ];
            }
        }

        // Validate inputs for generation
        $username = $this->extractGithubUsername($githubUrl ?? '');
        if ($username === '') {
            throw new \Exception('Github username/url tidak valid atau kosong');
        }
        if (empty($cvPath)) {
            throw new \Exception('CV path tidak tersedia');
        }
        // Ensure leading slash for server path concat
        if ($cvPath[0] !== '/') {
            $cvPath = '/' . $cvPath;
        }

        // Call external service
        $raw = (string) $this->assessorService->analyzeApplication($username, $cvPath);
        $summary = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Gagal mendekode hasil assessor: ' . json_last_error_msg());
        }

        // Persist summary JSON
        $this->applicationModel->update($id, [
            'assessor_summary' => json_encode($summary, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        ]);

        return [
            'summary' => $summary,
            'source' => 'generated'
        ];
    }

    private function extractGithubUsername(string $input): string
    {
        $input = trim($input);
        if ($input === '') return '';
        // If it's a full URL, parse path
        if (stripos($input, 'http://') === 0 || stripos($input, 'https://') === 0) {
            $parts = parse_url($input);
            $path = $parts['path'] ?? '';
            $segs = array_values(array_filter(explode('/', $path)));
            return $segs[0] ?? '';
        }
        // Otherwise assume it's a username
        // Strip leading @ if present
        if ($input[0] === '@') $input = substr($input, 1);
        // Basic whitelist: alnum and hyphen
        return preg_replace('/[^A-Za-z0-9-]/', '', $input) ?? '';
    }
}
