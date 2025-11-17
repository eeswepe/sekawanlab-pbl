<?php

namespace App\Services\Public;

use App\Models\PersonilModel;
use App\Models\ProjectModel;

/**
 * PersonilPublicService
 * 
 * Service untuk handle personil functionality di area public
 */
class PersonilPublicService
{
    private $personilModel;
    private $projectModel;
    
    public function __construct()
    {
        $this->personilModel = new PersonilModel();
        $this->projectModel = new ProjectModel();
    }
    
    /**
     * Get all personils (for public display)
     */
    public function getAllPersonils(): array
    {
        return $this->personilModel->getAllPersonils();
    }
    
    /**
     * Get personils by role
     */
    public function getPersonilsByRole(string $role): array
    {
        return $this->personilModel->getPersonilsByRole($role);
    }
    
    /**
     * Get personil by ID
     */
    public function getPersonilById(int $id): ?array
    {
        return $this->personilModel->getPersonilById($id);
    }
    
    /**
     * Get personil with full details (including projects)
     */
    public function getPersonilWithDetails(int $id): ?array
    {
        $personil = $this->personilModel->getPersonilById($id);
        
        if (!$personil) {
            return null;
        }
        
        // Parse skills if JSON
        if (!empty($personil['skills']) && is_string($personil['skills'])) {
            $decoded = json_decode($personil['skills'], true);
            $personil['skills'] = is_array($decoded) ? $decoded : [];
        } elseif (empty($personil['skills'])) {
            $personil['skills'] = [];
        }
        
        // Get projects
        $personil['projects'] = $this->projectModel->getProjectsByPersonilId($id);
        
        return $personil;
    }
    
    /**
     * Get personils with pagination
     */
    public function getPersonilsWithPagination(int $page = 1, int $limit = 12, ?string $role = null): array
    {
        $offset = ($page - 1) * $limit;
        
        $filters = [];
        if ($role) {
            $filters['role'] = $role;
        }
        
        $personils = $this->personilModel->getPersonilsWithFilters($filters, $limit, $offset);
        $totalPersonils = $this->personilModel->countPersonilsByRole($role);
        $totalPages = ceil($totalPersonils / $limit);
        
        return [
            'personils' => $personils,
            'totalPersonils' => $totalPersonils,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ];
    }
    
    /**
     * Search personils by name or specialization
     */
    public function searchPersonils(string $query, ?string $role = null): array
    {
        return $this->personilModel->searchPersonils($query, $role);
    }
}
