<?php 

namespace App\Controllers\Admin;

use App\Controller;
use App\Services\Admin\BlogService;
use Exception;

/**
 * BlogController
 * 
 * Handles admin blog management
 */
class BlogController extends Controller
{
    private BlogService $blogService;

    public function __construct()
    {
        $this->blogService = new BlogService();
    }

    /**
     * Display blog list with filters
     * 
     * GET /admin/blog-list
     */
    public function index()
    {
        try {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            
            // Service akan handle filtering
            $data = $this->blogService->getBlogsWithFilters($_GET, $page);
            $data['filters'] = $_GET;
            
            $this->render("admin/blog/list", $data);
        } catch (Exception $e) {
            http_response_code(500);
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Display blog create form
     * 
     * GET /admin/blog/create
     */
    public function create()
    {
        try {
            $data = $this->blogService->getFilterOptions();
            $this->render("admin/blog/create", $data);
        } catch (Exception $e) {
            http_response_code(500);
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Store new blog
     * 
     * POST /admin/blog/create
     */
    public function store()
    {
        try {
            $blogId = $this->blogService->createBlog($_POST, $_FILES);
            
            $this->jsonResponse([
                'success' => true, 
                'message' => 'Blog berhasil dibuat',
                'blog_id' => $blogId
            ]);
        } catch (Exception $e) {
            $this->jsonResponse([
                'success' => false, 
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display blog edit form
     * 
     * GET /admin/blog/edit/{id}
     */
    public function edit($id)
    {
        try {
            $data = $this->blogService->getFilterOptions();
            $data['blog'] = $this->blogService->getBlogById($id);
            
            $this->render("admin/blog/edit", $data);
        } catch (Exception $e) {
            $this->redirect('/admin/blog-list');
        }
    }

    /**
     * Update blog
     * 
     * POST /admin/blog/update/{id}
     */
    public function update($id)
    {
        try {
            $this->blogService->updateBlog($id, $_POST, $_FILES);
            
            $this->jsonResponse([
                'success' => true, 
                'message' => 'Blog berhasil diupdate'
            ]);
        } catch (Exception $e) {
            $this->jsonResponse([
                'success' => false, 
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Delete blog
     * 
     * DELETE /admin/blog/delete/{id}
     */
    public function delete($id)
    {
        try {
            $this->blogService->deleteBlog($id);
            
            $this->jsonResponse([
                'success' => true, 
                'message' => 'Blog berhasil dihapus'
            ]);
        } catch (Exception $e) {
            $this->jsonResponse([
                'success' => false, 
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
