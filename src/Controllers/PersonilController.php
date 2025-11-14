<?php

namespace App\Controllers;

use App\Controller;
use App\Models\PersonilModel;
use App\Models\BlogModel;
use App\Models\KategoriModel;
use App\Helpers\SessionHelper;

class PersonilController extends Controller
{
    private $model;
    private $blogModel;
    private $kategoriModel;

    public function __construct()
    {
        $this->model = new PersonilModel();
        $this->blogModel = new BlogModel();
        $this->kategoriModel = new KategoriModel();
    }

    public function dashboard()
    {
        // Get personil_id from session
        $personil_id = SessionHelper::getPersonilId();
        
        if (!$personil_id) {
            SessionHelper::setFlash('error', 'Session tidak valid. Silakan login kembali.');
            header('Location: /login');
            exit;
        }
        
        // Get personil data
        $personil = $this->model->getPersonilById($personil_id);
        
        // Get statistics
        $stats = $this->model->getPersonilStats($personil_id);
        
        // Get recent blogs (5 latest)
        $recentBlogs = $this->blogModel->getRecentBlogsByPenulis($personil_id, 5);
        
        // Prepare data for view
        $data = [
            'personil' => $personil,
            'stats' => $stats,
            'recentBlogs' => $recentBlogs
        ];
        
        $this->render("personil/dashboard", $data);
    }

    public function index()
    {
        $data["personils"] = $this->model->getAllPersonils();
        $this->render("personil/index", $data);
    }

    public function renderBlogCreate()
    {
        // Get personil_id from session
        $personil_id = SessionHelper::getPersonilId();
        
        if (!$personil_id) {
            SessionHelper::setFlash('error', 'Session tidak valid. Silakan login kembali.');
            header('Location: /login');
            exit;
        }
        
        // Get personil data
        $personil = $this->model->getPersonilById($personil_id);
        
        // Get all categories
        $categories = $this->kategoriModel->getAllKategori();
        
        $data = [
            'personil' => $personil,
            'categories' => $categories
        ];
        
        $this->render("personil/personil_blog_create", $data);
    }

    public function renderBlogList()
    {
        // Get personil_id from session
        $personil_id = SessionHelper::getPersonilId();
        
        if (!$personil_id) {
            SessionHelper::setFlash('error', 'Session tidak valid. Silakan login kembali.');
            header('Location: /login');
            exit;
        }
        
        // Get pagination parameters
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10; // Items per page
        $offset = ($page - 1) * $limit;
        
        // Get blog posts
        $blogs = $this->blogModel->getBlogsByPenulis($personil_id, $limit, $offset);
        
        // Get total blogs for pagination
        $totalBlogs = $this->blogModel->getTotalBlogsByPenulis($personil_id);
        $totalPages = ceil($totalBlogs / $limit);
        
        // Get statistics
        $stats = $this->blogModel->getBlogStatsByPenulis($personil_id);
        
        // Get personil data for display
        $personil = $this->model->getPersonilById($personil_id);
        
        // Prepare data for view
        $data = [
            'blogs' => $blogs,
            'stats' => $stats,
            'personil' => $personil,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalBlogs' => $totalBlogs,
            'limit' => $limit
        ];
        
        $this->render("personil/personil_blog_list", $data);
    }

    public function renderBlogEdit($id)
    {
        $data = [
            "blog_id" => $id,
        ];

        $this->render("personil/personil_blog_edit", $data);
    }

    public function renderProfile()
    {
        // Get personil_id from session
        $personil_id = SessionHelper::getPersonilId();
        
        if (!$personil_id) {
            SessionHelper::setFlash('error', 'Session tidak valid. Silakan login kembali.');
            header('Location: /login');
            exit;
        }
        
        // Get personil data with projects
        $personil = $this->model->getPersonilWithProjects($personil_id);
        
        if (!$personil) {
            SessionHelper::setFlash('error', 'Data personil tidak ditemukan.');
            header('Location: /personil/dashboard');
            exit;
        }
        
        // Prepare data for view
        $data = [
            'personil' => $personil
        ];
        
        $this->render("personil/personil_profil-view", $data);
    }

    public function renderProfileEdit()
    {
        $this->render("personil/personil_profile-edit");
    }

    /**
     * API: Delete blog post
     */
    public function deleteBlog($id)
    {
        header('Content-Type: application/json');
        
        // Get personil_id from session
        $personil_id = SessionHelper::getPersonilId();
        
        if (!$personil_id) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }
        
        // Get blog to verify ownership
        $blog = $this->blogModel->getBlogById($id);
        
        if (!$blog) {
            echo json_encode(['success' => false, 'message' => 'Blog not found']);
            exit;
        }
        
        // Verify ownership
        if ($blog['penulis_id'] != $personil_id) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized to delete this blog']);
            exit;
        }
        
        // Only allow deleting drafts
        if ($blog['status'] !== 'draft') {
            echo json_encode(['success' => false, 'message' => 'Only draft posts can be deleted']);
            exit;
        }
        
        // Delete the blog
        $result = $this->blogModel->deleteBlog($id);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Blog deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete blog']);
        }
        exit;
    }

    /**
     * API: Create new blog post
     */
    public function createBlog()
    {
        header('Content-Type: application/json');
        
        // Get personil_id from session
        $personil_id = SessionHelper::getPersonilId();
        
        if (!$personil_id) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }
        
        // Get personil data for author info
        $personil = $this->model->getPersonilById($personil_id);
        
        if (!$personil) {
            echo json_encode(['success' => false, 'message' => 'Personil not found']);
            exit;
        }
        
        // Get POST data
        $judul = $_POST['judul'] ?? '';
        $konten = $_POST['konten'] ?? '';
        $kategori_id = $_POST['kategori_id'] ?? '';
        $status = $_POST['status'] ?? 'draft';
        $cuplikan = $_POST['cuplikan'] ?? '';
        
        // Validate required fields
        if (empty($judul) || empty($konten) || empty($kategori_id)) {
            echo json_encode(['success' => false, 'message' => 'Judul, konten, dan kategori harus diisi']);
            exit;
        }
        
        // Generate slug from title
        $slug = $this->generateSlug($judul);
        
        // Calculate reading time (words per minute = 200)
        $wordCount = str_word_count(strip_tags($konten));
        $reading_time = max(1, ceil($wordCount / 200));
        
        // Generate excerpt if not provided
        if (empty($cuplikan)) {
            $cuplikan = $this->generateExcerpt($konten);
        }
        
        // Handle file upload
        $featured_image_url = null;
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $featured_image_url = $this->handleImageUpload($_FILES['featured_image']);
            if ($featured_image_url === false) {
                echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
                exit;
            }
        }
        
        // Prepare blog data
        $blogData = [
            'penulis_id' => $personil_id,
            'kategori_id' => $kategori_id,
            'slug' => $slug,
            'judul' => $judul,
            'cuplikan' => $cuplikan,
            'konten' => $konten,
            'penulis_nama' => $personil['nama_lengkap'],
            'penulis_bio' => $personil['bio'] ?? '',
            'tanggal_publish' => $status === 'published' ? date('Y-m-d H:i:s') : null,
            'featured_image_url' => $featured_image_url,
            'status' => $status,
            'reading_time' => $reading_time
        ];
        
        // Create blog
        $blog_id = $this->blogModel->createBlog($blogData);
        
        if ($blog_id) {
            // Increment category post count if published
            if ($status === 'published') {
                $this->kategoriModel->incrementPostCount($kategori_id);
            }
            
            echo json_encode([
                'success' => true, 
                'message' => 'Blog berhasil dibuat',
                'blog_id' => $blog_id,
                'redirect' => '/personil/blog'
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal membuat blog']);
        }
        exit;
    }

    /**
     * Generate URL-friendly slug from title
     */
    private function generateSlug($title)
    {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        
        // Add timestamp to ensure uniqueness
        $slug .= '-' . time();
        
        return $slug;
    }

    /**
     * Generate excerpt from content
     */
    private function generateExcerpt($content, $length = 150)
    {
        $text = strip_tags($content);
        if (strlen($text) > $length) {
            $text = substr($text, 0, $length);
            $text = substr($text, 0, strrpos($text, ' ')) . '...';
        }
        return $text;
    }

    /**
     * Handle image upload
     */
    private function handleImageUpload($file)
    {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $max_size = 5 * 1024 * 1024; // 5MB
        
        // Validate file type
        if (!in_array($file['type'], $allowed_types)) {
            return false;
        }
        
        // Validate file size
        if ($file['size'] > $max_size) {
            return false;
        }
        
        // Create upload directory if not exists
        $upload_dir = __DIR__ . '/../../public/upload/blog/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'blog_' . time() . '_' . uniqid() . '.' . $extension;
        $filepath = $upload_dir . $filename;
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return '/upload/blog/' . $filename;
        }
        
        return false;
    }
}
