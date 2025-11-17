<?php 

namespace App\Controllers\Admin;

use App\Controller;
use App\Services\Admin\ApplicationService;
use Exception;

/**
 * ApplicationController
 * 
 * Handles admin join application management
 */
class ApplicationController extends Controller
{
    private ApplicationService $applicationService;

    public function __construct()
    {
        $this->applicationService = new ApplicationService();
    }

    /**
     * Display applications list with filters
     * 
     * GET /admin/join-applications
     */
    public function index()
    {
        try {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            
            // Service akan handle filtering
            $data = $this->applicationService->getApplicationsWithFilters($_GET, $page);
            $data['filters'] = $_GET;
            
            $this->render("admin/applications/list", $data);
        } catch (Exception $e) {
            http_response_code(500);
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Display application detail
     * 
     * GET /admin/join-application/{id}
     */
    public function show($id)
    {
        try {
            $data = ['application' => $this->applicationService->getApplicationById($id)];
            $this->render("admin/applications/detail", $data);
        } catch (Exception $e) {
            $this->redirect('/admin/join-applications');
        }
    }

    /**
     * Update application status
     * 
     * POST /admin/join-application/update-status/{id}
     */
    public function updateStatus($id)
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $result = $this->applicationService->updateStatus($id, $data['status']);
            
            if (isset($result['secret_key'])) {
                $this->jsonResponse([
                    'success' => true,
                    'message' => $result['message'],
                    'secret_key' => $result['secret_key'],
                    'personil_id' => $result['personil_id']
                ]);
            } else {
                $this->jsonResponse([
                    'success' => true, 
                    'message' => $result['message']
                ]);
            }
        } catch (Exception $e) {
            $this->jsonResponse([
                'success' => false, 
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Update admin notes
     * 
     * POST /admin/join-application/update-notes/{id}
     */
    public function updateNotes($id)
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $this->applicationService->updateNotes($id, $data['admin_notes'] ?? '');
            
            $this->jsonResponse([
                'success' => true, 
                'message' => 'Catatan admin berhasil disimpan'
            ]);
        } catch (Exception $e) {
            $this->jsonResponse([
                'success' => false, 
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Delete application
     * 
     * DELETE /admin/join-application/delete/{id}
     */
    public function delete($id)
    {
        try {
            $this->applicationService->deleteApplication($id);
            
            $this->jsonResponse([
                'success' => true, 
                'message' => 'Application berhasil dihapus'
            ]);
        } catch (Exception $e) {
            $this->jsonResponse([
                'success' => false, 
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
