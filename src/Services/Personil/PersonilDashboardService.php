<?php

namespace App\Services\Personil;

use App\Models\PersonilModel;
use App\Models\BlogModel;
use App\Models\ProjectModel;

/**
 * PersonilDashboardService
 * 
 * Service untuk handle dashboard functionality di area personil
 */
class PersonilDashboardService
{
    private $personilModel;
    private $blogModel;
    private $projectModel;
    
    public function __construct()
    {
        $this->personilModel = new PersonilModel();
        $this->blogModel = new BlogModel();
        $this->projectModel = new ProjectModel();
    }
    
    /**
     * Get dashboard data for personil
     */
    public function getDashboardData(int $personilId): array
    {
        // Get personil data
        $personil = $this->personilModel->getPersonilById($personilId);
        
        if (!$personil) {
            throw new \Exception('Personil tidak ditemukan');
        }
        
        // Get statistics
        $stats = $this->personilModel->getPersonilStats($personilId);
        
        // Get recent blogs
        $recentBlogs = $this->blogModel->getRecentBlogsByPenulis($personilId, 5);
        
        return [
            'personil' => $personil,
            'stats' => $stats,
            'recentBlogs' => $recentBlogs
        ];
    }
    
    /**
     * Get personil statistics
     */
    public function getPersonilStats(int $personilId): array
    {
        return $this->personilModel->getPersonilStats($personilId);
    }
}
