<?php 

namespace App\Controllers;

use App\Controller;
use App\Models\AdminStatsModel;
use App\Services\Admin\BlogService;
use App\Services\Admin\PersonilService;
use App\Services\Admin\ApplicationService;
use App\Services\Admin\ProfilePageService;
use Exception;

class AdminController extends Controller
{
    private BlogService $blogService;
    private PersonilService $personilService;
    private ApplicationService $applicationService;
    private ProfilePageService $profilePageService;

    public function __construct()
    {
        $this->blogService = new BlogService();
        $this->personilService = new PersonilService();
        $this->applicationService = new ApplicationService();
        $this->profilePageService = new ProfilePageService();
    }

    public function dashboard()
    {
        $statsModel = new AdminStatsModel();
        
        $data = [
            'totalPersonil' => $statsModel->getTotalPersonil(),
            'totalBlogPosts' => $statsModel->getTotalBlogPosts(),
            'pendingApplications' => $statsModel->getPendingApplications(),
            'recentActivities' => $statsModel->getRecentActivities(5)
        ];
        
        $this->render("admin/dashboard/index", $data);
    }

    // ============= BLOG MANAGEMENT =============
    
    public function blogList()
    {
        try {
            // Get filters from query params
            $filters = [];
            if (!empty($_GET['search'])) {
                $filters['search'] = $_GET['search'];
            }
            if (!empty($_GET['kategori']) && $_GET['kategori'] !== 'all') {
                $filters['kategori_id'] = $_GET['kategori'];
            }
            if (!empty($_GET['penulis']) && $_GET['penulis'] !== 'all') {
                $filters['penulis_id'] = $_GET['penulis'];
            }
            if (!empty($_GET['status']) && $_GET['status'] !== 'all') {
                $filters['status'] = $_GET['status'];
            }
            
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $data = $this->blogService->getBlogsWithFilters($filters, $page);
            $data['filters'] = $filters;
            
            $this->render("admin/blog/list", $data);
        } catch (Exception $e) {
            http_response_code(500);
            echo "Error: " . $e->getMessage();
        }
    }
    
    public function deleteBlog($id)
    {
        header('Content-Type: application/json');
        
        try {
            $this->blogService->deleteBlog($id);
            echo json_encode(['success' => true, 'message' => 'Blog berhasil dihapus']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function renderBlogEdit($id)
    {
        try {
            $data = $this->blogService->getFilterOptions();
            $data['blog'] = $this->blogService->getBlogById($id);
            $this->render("admin/blog/edit", $data);
        } catch (Exception $e) {
            header('Location: /admin/blog-list');
            exit;
        }
    }
    
    public function updateBlog($id)
    {
        header('Content-Type: application/json');
        
        try {
            $this->blogService->updateBlog($id, $_POST, $_FILES);
            echo json_encode(['success' => true, 'message' => 'Blog berhasil diupdate']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function renderBlogCreate()
    {
        try {
            $data = $this->blogService->getFilterOptions();
            $this->render("admin/blog/create", $data);
        } catch (Exception $e) {
            http_response_code(500);
            echo "Error: " . $e->getMessage();
        }
    }
    
    public function createBlog()
    {
        header('Content-Type: application/json');
        
        try {
            $blogId = $this->blogService->createBlog($_POST, $_FILES);
            echo json_encode([
                'success' => true, 
                'message' => 'Blog berhasil dibuat',
                'blog_id' => $blogId
            ]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    // ============= PROFILE PAGES MANAGEMENT =============
    
    public function renderProfilePages()
    {
        try {
            $data = ['pages' => $this->profilePageService->getAllPages()];
            $this->render("admin/profile-pages/list", $data);
        } catch (Exception $e) {
            http_response_code(500);
            echo "Error: " . $e->getMessage();
        }
    }

    public function renderProfilePagesEdit($id)
    {
        try {
            $data = ['page' => $this->profilePageService->getPageById($id)];
            $this->render("admin/profile-pages/edit", $data);
        } catch (Exception $e) {
            header('Location: /admin/profil-pages');
            exit;
        }
    }

    public function updateProfilePage($id)
    {
        header('Content-Type: application/json');
        
        try {
            $this->profilePageService->updatePage($id, $_POST, $_FILES);
            echo json_encode(['success' => true, 'message' => 'Halaman berhasil diupdate']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function renderProfilePageCreate()
    {
        $this->render("admin/profile-pages/create");
    }

    public function createProfilePage()
    {
        header('Content-Type: application/json');
        
        try {
            $this->profilePageService->createPage($_POST, $_FILES);
            echo json_encode(['success' => true, 'message' => 'Halaman berhasil dibuat']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // ============= PERSONIL MANAGEMENT =============
    
    public function renderPersonilList()
    {
        try {
            // Get filters from query params
            $filters = [];
            if (!empty($_GET['search'])) {
                $filters['search'] = $_GET['search'];
            }
            if (!empty($_GET['role']) && $_GET['role'] !== 'all') {
                $filters['role'] = $_GET['role'];
            }
            
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $data = $this->personilService->getPersonilsWithFilters($filters, $page);
            $data['filters'] = $filters;
            
            $this->render("admin/personil/list", $data);
        } catch (Exception $e) {
            http_response_code(500);
            echo "Error: " . $e->getMessage();
        }
    }
    
    public function deletePersonil($id)
    {
        header('Content-Type: application/json');
        
        try {
            $this->personilService->deletePersonil($id);
            echo json_encode(['success' => true, 'message' => 'Personil berhasil dihapus']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function renderPersonilCreate()
    {
        $this->render("admin/personil/create");
    }
    
    public function createPersonil()
    {
        header('Content-Type: application/json');
        
        try {
            $db = \App\Database::getConnection();
            $personilId = $this->personilService->createPersonil($_POST, $_FILES, $db);
            echo json_encode([
                'success' => true,
                'message' => 'Personil berhasil dibuat',
                'personil_id' => $personilId
            ]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function renderPersonilEdit($id)
    {
        try {
            $personil = $this->personilService->getPersonilForEdit($id);
            if (!$personil) {
                header("Location: /admin/personil");
                exit;
            }
            
            // Parse skills JSON
            $personil['skills'] = !empty($personil['skillks']) ? json_decode($personil['skillks'], true) : [];
            
            $data = ['personil' => $personil];
            $this->render("admin/personil/edit", $data);
        } catch (Exception $e) {
            header("Location: /admin/personil");
            exit;
        }
    }

    public function updatePersonil($id)
    {
        header('Content-Type: application/json');
        
        try {
            // Read JSON body
            $rawData = json_decode(file_get_contents('php://input'), true);
            $this->personilService->updatePersonil($id, $rawData);
            echo json_encode(['success' => true, 'message' => 'Data personil berhasil diupdate']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    // ============= APPLICATIONS MANAGEMENT =============
    
    public function renderApplicationsList()
    {
        try {
            // Get filters from query params
            $filters = [];
            if (!empty($_GET['search'])) {
                $filters['search'] = $_GET['search'];
            }
            if (!empty($_GET['status']) && $_GET['status'] !== 'all') {
                $filters['status'] = $_GET['status'];
            }
            if (!empty($_GET['prodi']) && $_GET['prodi'] !== 'all') {
                $filters['prodi'] = $_GET['prodi'];
            }
            
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $data = $this->applicationService->getApplicationsWithFilters($filters, $page);
            $data['filters'] = $filters;
            
            $this->render("admin/applications/list", $data);
        } catch (Exception $e) {
            http_response_code(500);
            echo "Error: " . $e->getMessage();
        }
    }
    
    public function deleteApplication($id)
    {
        header('Content-Type: application/json');
        
        try {
            $this->applicationService->deleteApplication($id);
            echo json_encode(['success' => true, 'message' => 'Application berhasil dihapus']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function renderApplicationView($id)
    {
        try {
            $data = ['application' => $this->applicationService->getApplicationById($id)];
            $this->render("admin/applications/detail", $data);
        } catch (Exception $e) {
            header('Location: /admin/join-applications');
            exit;
        }
    }
    
    public function updateApplicationStatus($id)
    {
        header('Content-Type: application/json');
        
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $db = \App\Database::getConnection();
            $result = $this->applicationService->updateStatus($id, $data['status'], $db);
            
            if (isset($result['secret_key'])) {
                echo json_encode([
                    'success' => true,
                    'message' => $result['message'],
                    'secret_key' => $result['secret_key'],
                    'personil_id' => $result['personil_id']
                ]);
            } else {
                echo json_encode(['success' => true, 'message' => $result['message']]);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    public function updateAdminNotes($id)
    {
        header('Content-Type: application/json');
        
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $this->applicationService->updateNotes($id, $data['admin_notes'] ?? '');
            echo json_encode(['success' => true, 'message' => 'Catatan admin berhasil disimpan']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}