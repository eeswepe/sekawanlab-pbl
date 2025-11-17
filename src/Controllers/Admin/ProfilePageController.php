<?php 

namespace App\Controllers\Admin;

use App\Controller;
use App\Services\Admin\ProfilePageService;
use Exception;

/**
 * ProfilePageController
 * 
 * Handles admin profile pages management
 */
class ProfilePageController extends Controller
{
    private ProfilePageService $profilePageService;

    public function __construct()
    {
        $this->profilePageService = new ProfilePageService();
    }

    /**
     * Display profile pages list
     * 
     * GET /admin/profil-pages
     */
    public function index()
    {
        try {
            $data = ['pages' => $this->profilePageService->getAllPages()];
            $this->render("admin/profile-pages/list", $data);
        } catch (Exception $e) {
            http_response_code(500);
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Display profile page create form
     * 
     * GET /admin/profil-pages/create
     */
    public function create()
    {
        $this->render("admin/profile-pages/create");
    }

    /**
     * Store new profile page
     * 
     * POST /admin/profil-pages/create
     */
    public function store()
    {
        try {
            $this->profilePageService->createPage($_POST, $_FILES);
            
            $this->jsonResponse([
                'success' => true, 
                'message' => 'Halaman berhasil dibuat'
            ]);
        } catch (Exception $e) {
            $this->jsonResponse([
                'success' => false, 
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display profile page edit form
     * 
     * GET /admin/profil-pages/edit/{id}
     */
    public function edit($id)
    {
        try {
            $data = ['page' => $this->profilePageService->getPageById($id)];
            $this->render("admin/profile-pages/edit", $data);
        } catch (Exception $e) {
            $this->redirect('/admin/profil-pages');
        }
    }

    /**
     * Update profile page
     * 
     * POST /admin/profil-pages/update/{id}
     */
    public function update($id)
    {
        try {
            $this->profilePageService->updatePage($id, $_POST, $_FILES);
            
            $this->jsonResponse([
                'success' => true, 
                'message' => 'Halaman berhasil diupdate'
            ]);
        } catch (Exception $e) {
            $this->jsonResponse([
                'success' => false, 
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
