<?php 

namespace App\Controllers\Admin;

use App\Controller;
use App\Models\AdminStatsModel;

/**
 * DashboardController
 * 
 * Handles admin dashboard functionality
 */
class DashboardController extends Controller
{
    private AdminStatsModel $statsModel;

    public function __construct()
    {
        $this->statsModel = new AdminStatsModel();
    }

    /**
     * Display admin dashboard
     * 
     * GET /admin
     */
    public function index()
    {
        $data = [
            'totalPersonil' => $this->statsModel->getTotalPersonil(),
            'totalBlogPosts' => $this->statsModel->getTotalBlogPosts(),
            'pendingApplications' => $this->statsModel->getPendingApplications(),
            'recentActivities' => $this->statsModel->getRecentActivities(5)
        ];
        
        $this->render("admin/dashboard/index", $data);
    }
}
