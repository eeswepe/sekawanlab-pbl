<?php

namespace App\Services\Personil;

use App\Models\PersonilModel;
use App\Models\ProjectModel;
use App\Services\Shared\FileUploadService;

/**
 * PersonilProfileService
 * 
 * Service untuk handle profile management di area personil
 */
class PersonilProfileService
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
     * Get personil profile with projects
     */
    public function getProfileWithProjects(int $personilId): ?array
    {
        $personil = $this->personilModel->getPersonilById($personilId);
        
        if (!$personil) {
            return null;
        }
        
        // Parse skills
        $personil['skills'] = !empty($personil['skillks']) ? json_decode($personil['skillks'], true) : [];
        
        // Get projects
        $personil['projects'] = $this->projectModel->getProjectsByPersonilId($personilId);
        
        return $personil;
    }
    
    /**
     * Update personil profile
     */
    public function updateProfile(int $personilId, array $data, array $files = []): bool
    {
        $personil = $this->personilModel->getPersonilById($personilId);
        
        if (!$personil) {
            throw new \Exception('Personil tidak ditemukan');
        }
        
        // Handle photo upload
        $fotoUrl = $personil['foto_url'];
        if (!empty($files['photo']) && $files['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->fileService->uploadImage($files['photo'], 'img/foto-profil', 'profile_');
            
            if ($uploadResult['success']) {
                // Delete old photo
                if ($fotoUrl) {
                    $this->fileService->deleteFile($fotoUrl);
                }
                $fotoUrl = $uploadResult['path'];
            }
        }
        
        // Prepare update data
        $updateData = [
            'nama_lengkap' => $data['nama_lengkap'] ?? $personil['nama_lengkap'],
            'role' => $personil['role'], // Don't allow role change
            'spesialisasi' => $data['spesialisasi'] ?? $personil['spesialisasi'],
            'email' => $data['email'] ?? $personil['email'],
            'phone' => $data['phone'] ?? $personil['phone'],
            'location' => $data['location'] ?? $personil['location'],
            'tanggal_bergabung' => $personil['tanggal_bergabung'],
            'bio' => $data['bio'] ?? $personil['bio'],
            'skillks' => json_encode($data['skills'] ?? []),
            'foto_url' => $fotoUrl
        ];
        
        return $this->personilModel->updatePersonil($personilId, $updateData);
    }
    
    /**
     * Update personil projects
     */
    public function updateProjects(int $personilId, array $projects): bool
    {
        // Delete existing projects
        $this->projectModel->deleteProjectsByPersonilId($personilId);
        
        // Create new projects
        foreach ($projects as $project) {
            if (!empty($project['title'])) {
                $this->projectModel->createProject([
                    'personil_id' => $personilId,
                    'title' => $project['title'],
                    'description' => $project['description'] ?? ''
                ]);
            }
        }
        
        return true;
    }
    
    /**
     * Update personil skills
     */
    public function updateSkills(int $personilId, array $skills): bool
    {
        $personil = $this->personilModel->getPersonilById($personilId);
        
        if (!$personil) {
            throw new \Exception('Personil tidak ditemukan');
        }
        
        $updateData = [
            'nama_lengkap' => $personil['nama_lengkap'],
            'role' => $personil['role'],
            'spesialisasi' => $personil['spesialisasi'],
            'email' => $personil['email'],
            'phone' => $personil['phone'],
            'location' => $personil['location'],
            'tanggal_bergabung' => $personil['tanggal_bergabung'],
            'bio' => $personil['bio'],
            'skillks' => json_encode($skills),
            'foto_url' => $personil['foto_url']
        ];
        
        return $this->personilModel->updatePersonil($personilId, $updateData);
    }
}
