<?php

namespace App\Controllers;

use App\Controller;
use App\Services\Public\PersonilPublicService;
use App\Services\Personil\PersonilDashboardService;
use App\Services\Personil\PersonilBlogService;
use App\Services\Personil\PersonilProfileService;
use App\Helpers\SessionHelper;

/**
 * PersonilController (REFACTORED)
 * 
 * Controller untuk handle personil area
 * Menggunakan services untuk business logic
 */
class PersonilController extends Controller
{
    private $publicService;
    private $dashboardService;
    private $blogService;
    private $profileService;

    public function __construct()
    {
        $this->publicService = new PersonilPublicService();
        $this->dashboardService = new PersonilDashboardService();
        $this->blogService = new PersonilBlogService();
        $this->profileService = new PersonilProfileService();
    }

    // ===== PUBLIC AREA =====
    
    /**
     * Display all personils (public)
     * 
     * GET /personil
     */
    public function index()
    {
        $personils = $this->publicService->getAllPersonils();
        
        $data = [
            'personils' => $personils
        ];
        
        $this->render("landing/personil/list", $data);
    }

    // ===== PERSONIL DASHBOARD =====
    
    /**
     * Personil dashboard
     * 
     * GET /personil/dashboard
     */
    public function dashboard()
    {
        $personil_id = SessionHelper::getPersonilId();
        
        if (!$personil_id) {
            SessionHelper::setFlash('error', 'Session tidak valid. Silakan login kembali.');
            header('Location: /login');
            exit;
        }
        
        try {
            $data = $this->dashboardService->getDashboardData($personil_id);
            $this->render("personil/dashboard/index", $data);
        } catch (\Exception $e) {
            SessionHelper::setFlash('error', $e->getMessage());
            header('Location: /login');
            exit;
        }
    }

    // ===== BLOG MANAGEMENT =====
    
    /**
     * Render blog create form
     * 
     * GET /personil/blog/create
     */
    public function renderBlogCreate()
    {
        $personil_id = SessionHelper::getPersonilId();
        
        if (!$personil_id) {
            SessionHelper::setFlash('error', 'Session tidak valid. Silakan login kembali.');
            header('Location: /login');
            exit;
        }
        
        try {
            $personil = $this->publicService->getPersonilById($personil_id);
            $categories = $this->blogService->getAllCategories();
            
            $data = [
                'personil' => $personil,
                'categories' => $categories
            ];
            
            $this->render("personil/blog/create", $data);
        } catch (\Exception $e) {
            SessionHelper::setFlash('error', $e->getMessage());
            header('Location: /personil/dashboard');
            exit;
        }
    }

    /**
     * Render blog list
     * 
     * GET /personil/blog
     */
    public function renderBlogList()
    {
        $personil_id = SessionHelper::getPersonilId();
        
        if (!$personil_id) {
            SessionHelper::setFlash('error', 'Session tidak valid. Silakan login kembali.');
            header('Location: /login');
            exit;
        }
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        
        try {
            $result = $this->blogService->getBlogsByPersonil($personil_id, $page);
            $personil = $this->publicService->getPersonilById($personil_id);
            
            $data = array_merge($result, ['personil' => $personil]);
            
            $this->render("personil/blog/list", $data);
        } catch (\Exception $e) {
            SessionHelper::setFlash('error', $e->getMessage());
            header('Location: /personil/dashboard');
            exit;
        }
    }

    /**
     * Render blog edit form
     * 
     * GET /personil/blog/edit/{id}
     */
    public function renderBlogEdit($id)
    {
        $personil_id = SessionHelper::getPersonilId();
        
        if (!$personil_id) {
            header('Location: /login');
            exit;
        }
        
        try {
            $blog = $this->blogService->getBlogForEdit($id, $personil_id);
            
            if (!$blog) {
                header('Location: /personil/blog');
                exit;
            }
            
            $personil = $this->publicService->getPersonilById($personil_id);
            $categories = $this->blogService->getAllCategories();
            
            $data = [
                'blog' => $blog,
                'personil' => $personil,
                'categories' => $categories
            ];

            $this->render("personil/blog/edit", $data);
        } catch (\Exception $e) {
            SessionHelper::setFlash('error', $e->getMessage());
            header('Location: /personil/blog');
            exit;
        }
    }

    /**
     * Create blog
     * 
     * POST /personil/blog/create
     */
    public function createBlog()
    {
        header('Content-Type: application/json');
        
        $personil_id = SessionHelper::getPersonilId();
        
        if (!$personil_id) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }
        
        try {
            $blog_id = $this->blogService->createBlog($_POST, $_FILES, $personil_id);
            
            echo json_encode([
                'success' => true, 
                'message' => 'Blog berhasil dibuat',
                'blog_id' => $blog_id,
                'redirect' => '/personil/blog'
            ]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    /**
     * Update blog
     * 
     * POST /personil/blog/update/{id}
     */
    public function updateBlog($id)
    {
        header('Content-Type: application/json');
        
        $personil_id = SessionHelper::getPersonilId();
        
        if (!$personil_id) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }
        
        try {
            $this->blogService->updateBlog($id, $_POST, $_FILES, $personil_id);
            
            echo json_encode([
                'success' => true, 
                'message' => 'Blog berhasil diupdate',
                'redirect' => '/personil/blog'
            ]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    /**
     * Delete blog
     * 
     * DELETE /personil/blog/{id}
     */
    public function deleteBlog($id)
    {
        header('Content-Type: application/json');
        
        $personil_id = SessionHelper::getPersonilId();
        
        if (!$personil_id) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }
        
        try {
            $this->blogService->deleteBlog($id, $personil_id);
            echo json_encode(['success' => true, 'message' => 'Blog deleted successfully']);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    // ===== PROFILE MANAGEMENT =====
    
    /**
     * Render profile
     * 
     * GET /personil/profile
     */
    public function renderProfile()
    {
        $personil_id = SessionHelper::getPersonilId();
        
        if (!$personil_id) {
            SessionHelper::setFlash('error', 'Session tidak valid. Silakan login kembali.');
            header('Location: /login');
            exit;
        }
        
        try {
            $personil = $this->profileService->getProfileWithProjects($personil_id);
            
            if (!$personil) {
                SessionHelper::setFlash('error', 'Data personil tidak ditemukan.');
                header('Location: /personil/dashboard');
                exit;
            }
            
            $data = [
                'personil' => $personil
            ];
            
            $this->render("personil/profile/index", $data);
        } catch (\Exception $e) {
            SessionHelper::setFlash('error', $e->getMessage());
            header('Location: /personil/dashboard');
            exit;
        }
    }

    /**
     * Render profile edit form
     * 
     * GET /personil/profile/edit
     */
    public function renderProfileEdit()
    {
        $personil_id = SessionHelper::getPersonilId();
        
        if (!$personil_id) {
            header('Location: /login');
            exit;
        }
        
        try {
            $personil = $this->profileService->getProfileWithProjects($personil_id);
            
            $data = [
                'personil' => $personil,
                'projects' => $personil['projects']
            ];
            
            $this->render("personil/profile/edit", $data);
        } catch (\Exception $e) {
            SessionHelper::setFlash('error', $e->getMessage());
            header('Location: /personil/profile');
            exit;
        }
    }

    /**
     * Update profile
     * 
     * POST /personil/profile/update
     */
    public function updateProfile()
    {
        header('Content-Type: application/json');
        
        $personil_id = SessionHelper::getPersonilId();
        
        if (!$personil_id) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }
        
        try {
            // Update profile
            $this->profileService->updateProfile($personil_id, $_POST, $_FILES);
            
            // Update projects if provided
            if (isset($_POST['projects'])) {
                $projects = json_decode($_POST['projects'], true);
                $this->profileService->updateProjects($personil_id, $projects);
            }
            
            echo json_encode([
                'success' => true, 
                'message' => 'Profile berhasil diupdate',
                'redirect' => '/personil/profile'
            ]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }
}
