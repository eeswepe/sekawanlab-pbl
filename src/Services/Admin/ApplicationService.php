<?php

namespace App\Services\Admin;

use App\Models\JoinApplicationModel;
use App\Models\PersonilModel;
use App\Models\PersonilInvitationModel;
use App\Services\Shared\FileUploadService;
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
    private $invitationModel;
    private $fileService;
    
    public function __construct()
    {
        $this->applicationModel = new JoinApplicationModel();
        $this->personilModel = new PersonilModel();
        $this->invitationModel = new PersonilInvitationModel();
        $this->fileService = new FileUploadService();
    }
    
    /**
     * Get applications with filters and pagination
     */
    public function getApplicationsWithFilters(array $filters, int $page = 1, int $limit = 10): array
    {
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
     * Get application by ID
     */
    public function getApplicationById(int $id): ?array
    {
        return $this->applicationModel->getApplicationById($id);
    }
    
    /**
     * Update application status
     */
    public function updateStatus(int $id, string $status, PDO $db): array
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
            return $this->handleAcceptedApplication($application, $db);
        }
        
        return ['message' => 'Status berhasil diupdate'];
    }
    
    /**
     * Handle accepted application (create personil and invitation)
     */
    private function handleAcceptedApplication(array $application, PDO $db): array
    {
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
            'user_id' => null,
            'nama_lengkap' => $application['nama_lengkap'],
            'role' => 'talent',
            'spesialisasi' => null,
            'email' => $application['email'],
            'phone' => $application['phone'],
            'location' => null,
            'tanggal_bergabung' => date('Y-m-d'),
            'bio' => $application['alasan_bergabung'],
            'skillks' => json_encode([]),
            'foto_url' => null
        ];
        
        $personilId = $this->personilModel->createPersonil($personilData);
        
        if (!$personilId) {
            throw new \Exception('Gagal membuat personil');
        }
        
        // Create invitation
        $secretKey = $this->invitationModel->createInvitation($personilId, $application['id']);
        
        if (!$secretKey) {
            throw new \Exception('Gagal membuat invitation');
        }
        
        return [
            'message' => 'Status berhasil diupdate dan personil telah dibuat',
            'secret_key' => $secretKey,
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
}
