<?php

namespace App\Services\Admin;

use App\Models\PersonilModel;
use App\Helpers\SessionHelper;
use App\Models\ProjectModel;
use App\Services\Shared\FileUploadService;
use PDO;

/**
 * PersonilService
 * 
 * Service untuk admin personil management
 */
class PersonilService
{
    private $personilModel;
    private $projectModel;
    private $fileService;
    
    public function __construct()
    {
        $this->personilModel = new PersonilModel();
        $this->projectModel = new ProjectModel();
        $this->fileService = new FileUploadService();
    }
    
    /**
     * Get personils with filters and pagination
     * 
     * @param array $rawFilters Raw filters dari $_GET
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getPersonilsWithFilters(array $rawFilters, int $page = 1, int $limit = 10): array
    {
        // Normalize filters - Service menangani logika filtering
        $filters = $this->normalizeFilters($rawFilters);
        
        $offset = ($page - 1) * $limit;
        
        $personils = $this->personilModel->getPersonilsForAdmin($filters, $limit, $offset);
        $totalPersonils = $this->personilModel->countPersonilsForAdmin($filters);
        $totalPages = ceil($totalPersonils / $limit);
        
        return [
            'personils' => $personils,
            'totalPersonils' => $totalPersonils,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'offset' => $offset,
            'stats' => [
                'totalAll' => $this->personilModel->countByRole(),
                'totalDosen' => $this->personilModel->countByRole('dosen'),
                'totalTalent' => $this->personilModel->countByRole('talent')
            ]
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
        
        if (!empty($rawFilters['role']) && $rawFilters['role'] !== 'all') {
            $filters['role'] = $rawFilters['role'];
        }
        
        return $filters;
    }
    
    /**
     * Get personil by ID
     */
    public function getPersonilById(int $id): ?array
    {
        return $this->personilModel->getPersonilById($id);
    }
    
    /**
     * Get personil for edit (with projects)
     */
    public function getPersonilForEdit(int $id): ?array
    {
        $personil = $this->personilModel->getPersonilById($id);
        
        if (!$personil) {
            return null;
        }
        
        // Get projects
        $personil['projects'] = $this->projectModel->getProjectsByPersonilId($id);
        
        return $personil;
    }
    
    /**
     * Create new personil
     */
    public function createPersonil(array $data, array $files): int
    {
        // Validate
        if (empty($data['nama_lengkap']) || empty($data['nim_nip']) || empty($data['email']) || empty($data['phone']) || empty($data['role'])) {
            throw new \Exception('Field wajib tidak boleh kosong');
        }
        
        $db = \App\Database::getConnection();
        $db->beginTransaction();
        
        try {
            // Handle photo upload
            $fotoUrl = null;
            if (!empty($files['photo']) && $files['photo']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = $this->fileService->uploadImage($files['photo'], 'img/foto-profil', 'profile_');
                
                if (!$uploadResult['success']) {
                    throw new \Exception($uploadResult['message']);
                }
                
                $fotoUrl = $uploadResult['path'];
            }
            
            // Parse skills
            $skills = [];
            if (!empty($data['skills'])) {
                $skills = json_decode($data['skills'], true) ?? [];
            }
            
            // Create personil with password set to NULL initially
            // Password will be set through external program
            $personilData = [
                'nama_lengkap' => $data['nama_lengkap'],
                'nim_nip' => $data['nim_nip'],
                'password' => null, // Will be set by external program
                'role' => $data['role'],
                'spesialisasi' => $data['spesialisasi'] ?? null,
                'email' => $data['email'],
                'phone' => $data['phone'],
                'location' => $data['location'] ?? null,
                'tanggal_bergabung' => $data['tanggal_bergabung'] ?? date('Y-m-d'),
                'bio' => $data['bio'] ?? null,
                'skills' => json_encode($skills),
                'foto_url' => $fotoUrl
            ];
            
            $personilId = $this->personilModel->createPersonil($personilData);
            
            if (!$personilId) {
                throw new \Exception('Gagal membuat personil');
            }
            
            // Create projects
            if (!empty($data['projects'])) {
                $this->createProjects($personilId, json_decode($data['projects'], true));
            }
            
            $db->commit();
            return $personilId;
            
        } catch (\Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }
    
    /**
     * Update personil
     */
    public function updatePersonil(int $id, array $data, array $files = []): bool
    {
        // Check if exists
        $personil = $this->personilModel->getPersonilById($id);
        if (!$personil) {
            throw new \Exception('Personil tidak ditemukan');
        }
        
        // Handle skills parsing if it's JSON string
        $skills = $data['skills'] ?? [];
        if (is_string($skills)) {
            $skills = json_decode($skills, true) ?? [];
        }
        
        // Prepare data - only include fields present; keep existing values otherwise
        $updateData = [
            'nama_lengkap' => $data['nama_lengkap'] ?? $personil['nama_lengkap'],
            'role' => $data['role'] ?? $personil['role'],
            'spesialisasi' => $data['spesialisasi'] ?? ($personil['spesialisasi'] ?? ''),
            'email' => $data['email'] ?? $personil['email'],
            'phone' => $data['phone'] ?? ($personil['phone'] ?? ''),
            'location' => $data['location'] ?? ($personil['location'] ?? ''),
            'tanggal_bergabung' => $data['tanggal_bergabung'] ?? ($personil['tanggal_bergabung'] ?? null),
            'bio' => $data['bio'] ?? ($personil['bio'] ?? ''),
            'skills' => json_encode($skills),
            'foto_url' => $personil['foto_url']
        ];

        // Optional nim_nip update & uniqueness check
        if (isset($data['nim_nip']) && $data['nim_nip'] !== '' && $data['nim_nip'] !== $personil['nim_nip']) {
            if ($this->personilModel->nimNipExists($data['nim_nip'], $id)) {
                throw new \Exception('NIM/NIP sudah terdaftar');
            }
            $updateData['nim_nip'] = $data['nim_nip'];
        }

        // Handle photo upload
        if (!empty($files['foto_url']) && $files['foto_url']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->fileService->uploadImage($files['foto_url'], 'img/foto-profil', 'profile_');
            
            if (!$uploadResult['success']) {
                throw new \Exception($uploadResult['message']);
            }
            
            // Delete old photo if exists
            if (!empty($personil['foto_url'])) {
                $this->fileService->deleteFile($personil['foto_url']);
            }
            
            $updateData['foto_url'] = $uploadResult['path'];
        }

        // Update personil
        if (!$this->personilModel->updatePersonil($id, $updateData)) {
            throw new \Exception('Gagal update personil');
        }
        
        // Handle projects parsing if it's JSON string
        $projects = $data['projects'] ?? null;
        if (is_string($projects)) {
            $projects = json_decode($projects, true);
        }
        
        // Handle projects
        if (isset($projects)) {
            $this->projectModel->deleteProjectsByPersonilId($id);
            $this->createProjects($id, $projects);
        }
        
        return true;
    }
    
    /**
     * Delete personil
     */
    public function deletePersonil(int $id): bool
    {
        $personil = $this->personilModel->getPersonilById($id);
        if (!$personil) {
            throw new \Exception('Personil tidak ditemukan');
        }
        
        // Delete photo
        if (!empty($personil['foto_url'])) {
            $this->fileService->deleteFile($personil['foto_url']);
        }
        
        // Delete projects
        $this->projectModel->deleteProjectsByPersonilId($id);
        
        return $this->personilModel->deletePersonil($id);
    }
    
    /**
     * Create projects for personil
     */
    private function createProjects(int $personilId, ?array $projects): void
    {
        if (!is_array($projects)) {
            return;
        }
        
        foreach ($projects as $project) {
            if (!empty($project['title'])) {
                $this->projectModel->createProject([
                    'personil_id' => $personilId,
                    'title' => $project['title'],
                    'description' => $project['description'] ?? ''
                ]);
            }
        }
    }
}
