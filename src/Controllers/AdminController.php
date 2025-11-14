<?php 

namespace App\Controllers;

use App\Controller;
use App\Models\AdminStatsModel;
use App\Models\KategoriModel;
use App\Models\PersonilModel;
use App\Models\BlogModel;

class AdminController extends Controller
{
    public function dashboard()
    {
        $statsModel = new AdminStatsModel();
        
        $data = [
            'totalPersonil' => $statsModel->getTotalPersonil(),
            'totalBlogPosts' => $statsModel->getTotalBlogPosts(),
            'pendingApplications' => $statsModel->getPendingApplications(),
            'totalViews' => $statsModel->getTotalViews(),
            'recentActivities' => $statsModel->getRecentActivities(5)
        ];
        
        $this->render("admin/dashboard", $data);
    }

    public function blogList()
    {
        $this->render("admin/admin_blog_list");
    }

    public function renderBlogEdit($id)
    {
        $data = [
            "blog_id" => $id,
        ];

        $this->render("admin/admin_blog_edit", $data);
    }

    public function renderBlogCreate()
    {
        $kategoriModel = new KategoriModel();
        $personilModel = new PersonilModel();
        
        $data = [
            'categories' => $kategoriModel->getAllKategori(),
            'personils' => $personilModel->getAllPersonils()
        ];
        
        $this->render("admin/admin_blog_create", $data);
    }
    
    public function createBlog()
    {
        header('Content-Type: application/json');
        
        // Validate input
        if (empty($_POST['judul']) || empty($_POST['konten']) || empty($_POST['kategori_id']) || empty($_POST['penulis_id'])) {
            echo json_encode(['success' => false, 'message' => 'Field wajib tidak boleh kosong']);
            return;
        }
        
        // Get personil data
        $personilModel = new PersonilModel();
        $personil = $personilModel->getPersonilById($_POST['penulis_id']);
        
        if (!$personil) {
            echo json_encode(['success' => false, 'message' => 'Penulis tidak ditemukan']);
            return;
        }
        
        // Generate slug
        $slug = $this->generateSlug($_POST['judul']);
        
        // Calculate reading time
        $readingTime = $this->calculateReadingTime($_POST['konten']);
        
        // Generate excerpt if not provided
        $cuplikan = !empty($_POST['cuplikan']) ? $_POST['cuplikan'] : $this->generateExcerpt($_POST['konten']);
        
        // Handle featured image upload
        $featuredImageUrl = null;
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $featuredImageUrl = $this->handleImageUpload($_FILES['featured_image']);
            if (!$featuredImageUrl) {
                echo json_encode(['success' => false, 'message' => 'Gagal upload gambar']);
                return;
            }
        }
        
        // Set publish date if status is published
        $tanggalPublish = null;
        if ($_POST['status'] === 'published') {
            $tanggalPublish = date('Y-m-d H:i:s');
        }
        
        // Prepare blog data
        $blogData = [
            'penulis_id' => $_POST['penulis_id'],
            'kategori_id' => $_POST['kategori_id'],
            'slug' => $slug,
            'judul' => $_POST['judul'],
            'cuplikan' => $cuplikan,
            'konten' => $_POST['konten'],
            'penulis_nama' => $personil['nama_lengkap'],
            'penulis_bio' => $personil['bio'] ?? '',
            'tanggal_publish' => $tanggalPublish,
            'featured_image_url' => $featuredImageUrl,
            'status' => $_POST['status'],
            'reading_time' => $readingTime
        ];
        
        // Create blog post
        $blogModel = new BlogModel();
        $blogId = $blogModel->createBlog($blogData);
        
        if ($blogId) {
            echo json_encode([
                'success' => true, 
                'message' => 'Blog berhasil dibuat',
                'blog_id' => $blogId
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal membuat blog']);
        }
    }
    
    private function generateSlug($title)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $slug = preg_replace('/-+/', '-', $slug);
        return trim($slug, '-') . '-' . time();
    }
    
    private function calculateReadingTime($content)
    {
        $wordCount = str_word_count(strip_tags($content));
        $readingTime = ceil($wordCount / 200);
        return max(1, $readingTime);
    }
    
    private function generateExcerpt($content, $length = 150)
    {
        $text = strip_tags($content);
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . '...';
    }
    
    private function handleImageUpload($file)
    {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        
        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }
        
        if ($file['size'] > $maxSize) {
            return false;
        }
        
        $uploadDir = __DIR__ . '/../../public/upload/blog/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'blog_' . time() . '_' . uniqid() . '.' . $extension;
        $filepath = $uploadDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return '/upload/blog/' . $filename;
        }
        
        return false;
    }

    public function renderProfilePages()
    {
        $this->render("admin/admin_profile-pages");
    }

    public function renderProfilePagesEdit($id)
    {
        $data = [
            "profile_page_id" => $id,
        ];

        $this->render("admin/admin_profile-page_edit", $data);
    }

    public function renderPersonilList()
    {
        $this->render("admin/admin_personil_list");
    }

    public function renderPersonilCreate()
    {
        $this->render("admin/admin_personil_create");
    }

    public function renderPersonilEdit($id)
    {
        $data = [
            "personil_id" => $id,
        ];

        $this->render("admin/admin_personil_edit", $data);
    }
    
    public function renderApplicationsList()
    {
        $this->render("admin/admin_applications-list");
    }

    public function renderApplicationView($id)
    {
        $data = [
            "application_id" => $id,
        ];

        $this->render("admin/admin_join_application_view", $data);
    }

    public function renderSiteSettings()
    {
        $this->render("admin/admin_site_settings");
    }
}