<?php 

namespace App\Controllers\Admin;

use App\Controller;
use App\Models\AdminStatsModel;
use App\Models\PersonilModel;
use App\Helpers\SessionHelper;

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

        // Add current user's full name for greeting (fallback to role name)
        $currentName = null;
        $userId = SessionHelper::getUserId();
        if ($userId) {
            $personilModel = new PersonilModel();
            $personil = $personilModel->getPersonilById((int)$userId);
            if ($personil && !empty($personil['nama_lengkap'])) {
                $currentName = $personil['nama_lengkap'];
            }
        }
        $data['currentUserName'] = $currentName;
        
        $this->render("admin/dashboard/index", $data);
    }
}
