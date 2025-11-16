<?php 

namespace App\Controllers;

use App\Controller;
use App\Models\AdminStatsModel;
use App\Models\KategoriModel;
use App\Models\PersonilModel;
use App\Models\BlogModel;
use App\Models\UserModel;
use App\Models\ProjectModel;

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
        
        $this->render("admin/dashboard/index", $data);
    }

    public function blogList()
    {
        $blogModel = new BlogModel();
        $kategoriModel = new KategoriModel();
        $personilModel = new PersonilModel();
        
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
        
        // Pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        // Get blogs and total count
        $blogs = $blogModel->getBlogsForAdmin($filters, $limit, $offset);
        $totalBlogs = $blogModel->countBlogsForAdmin($filters);
        $totalPages = ceil($totalBlogs / $limit);
        
        // Get categories and personils for filters
        $categories = $kategoriModel->getAllKategori();
        $personils = $personilModel->getAllPersonils();
        
        $data = [
            'blogs' => $blogs,
            'categories' => $categories,
            'personils' => $personils,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalBlogs' => $totalBlogs,
            'filters' => $filters,
            'offset' => $offset
        ];
        
        $this->render("admin/blog/list", $data);
    }
    
    public function deleteBlog($id)
    {
        header('Content-Type: application/json');
        
        $blogModel = new BlogModel();
        
        // Check if blog exists
        $blog = $blogModel->getBlogById($id);
        if (!$blog) {
            echo json_encode(['success' => false, 'message' => 'Blog tidak ditemukan']);
            return;
        }
        
        // Delete featured image if exists
        if (!empty($blog['featured_image_url'])) {
            $imagePath = __DIR__ . '/../../public' . $blog['featured_image_url'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        // Delete blog
        if ($blogModel->deleteBlog($id)) {
            echo json_encode(['success' => true, 'message' => 'Blog berhasil dihapus']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus blog']);
        }
    }

    public function renderBlogEdit($id)
    {
        $blogModel = new BlogModel();
        $kategoriModel = new KategoriModel();
        $personilModel = new PersonilModel();
        
        $blog = $blogModel->getBlogById($id);
        
        if (!$blog) {
            header('Location: /admin/blog-list');
            exit;
        }
        
        $data = [
            'blog' => $blog,
            'categories' => $kategoriModel->getAllKategori(),
            'personils' => $personilModel->getAllPersonils()
        ];

        $this->render("admin/blog/edit", $data);
    }
    
    public function updateBlog($id)
    {
        header('Content-Type: application/json');
        
        $blogModel = new BlogModel();
        
        // Check if blog exists
        $existingBlog = $blogModel->getBlogById($id);
        if (!$existingBlog) {
            echo json_encode(['success' => false, 'message' => 'Blog tidak ditemukan']);
            return;
        }
        
        // Validate input
        if (empty($_POST['judul']) || empty($_POST['konten']) || empty($_POST['kategori_id'])) {
            echo json_encode(['success' => false, 'message' => 'Field wajib tidak boleh kosong']);
            return;
        }
        
        // Calculate reading time
        $readingTime = $this->calculateReadingTime($_POST['konten']);
        
        // Generate excerpt if not provided
        $cuplikan = !empty($_POST['cuplikan']) ? $_POST['cuplikan'] : $this->generateExcerpt($_POST['konten']);
        
        // Handle featured image upload
        $featuredImageUrl = $existingBlog['featured_image_url'];
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $uploadedImage = $this->handleImageUpload($_FILES['featured_image']);
            if ($uploadedImage) {
                // Delete old image if exists
                if ($featuredImageUrl && file_exists(__DIR__ . '/../../public' . $featuredImageUrl)) {
                    unlink(__DIR__ . '/../../public' . $featuredImageUrl);
                }
                $featuredImageUrl = $uploadedImage;
            }
        }
        
        // Set publish date if status changes to published
        $tanggalPublish = $existingBlog['tanggal_publish'];
        if ($_POST['status'] === 'published' && !$tanggalPublish) {
            $tanggalPublish = date('Y-m-d H:i:s');
        } elseif ($_POST['status'] === 'draft') {
            $tanggalPublish = null;
        }
        
        // Prepare update data
        $updateData = [
            'kategori_id' => $_POST['kategori_id'],
            'slug' => $existingBlog['slug'], // Keep original slug
            'judul' => $_POST['judul'],
            'cuplikan' => $cuplikan,
            'konten' => $_POST['konten'],
            'tanggal_publish' => $tanggalPublish,
            'featured_image_url' => $featuredImageUrl,
            'status' => $_POST['status'],
            'reading_time' => $readingTime
        ];
        
        // Update blog post
        if ($blogModel->updateBlog($id, $updateData)) {
            echo json_encode([
                'success' => true, 
                'message' => 'Blog berhasil diupdate'
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal mengupdate blog']);
        }
    }

    public function renderBlogCreate()
    {
        $kategoriModel = new KategoriModel();
        $personilModel = new PersonilModel();
        
        $data = [
            'categories' => $kategoriModel->getAllKategori(),
            'personils' => $personilModel->getAllPersonils()
        ];
        
        $this->render("admin/blog/create", $data);
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
    
    private function handleImageUpload($file, $type = 'blog')
    {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        
        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }
        
        if ($file['size'] > $maxSize) {
            return false;
        }
        
        $uploadDir = __DIR__ . '/../../public/upload/' . $type . '/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $type . '_' . time() . '_' . uniqid() . '.' . $extension;
        $filepath = $uploadDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return '/upload/' . $type . '/' . $filename;
        }
        
        return false;
    }

    public function renderProfilePages()
    {
        $profilPageModel = new \App\Models\ProfilPageModel();
        $pages = $profilPageModel->getAllProfilPages();
        
        $data = ['pages' => $pages];
        $this->render("admin/profile-pages/list", $data);
    }

    public function renderProfilePagesEdit($id)
    {
        $profilPageModel = new \App\Models\ProfilPageModel();
        $page = $profilPageModel->getProfilPageById($id);
        
        if (!$page) {
            header('Location: /admin/profil-pages');
            exit;
        }
        
        $data = ['page' => $page];
        $this->render("admin/profile-pages/edit", $data);
    }

    public function updateProfilePage($id)
    {
        header('Content-Type: application/json');
        
        $profilPageModel = new \App\Models\ProfilPageModel();
        
        // Check if page exists
        $page = $profilPageModel->getProfilPageById($id);
        if (!$page) {
            echo json_encode(['success' => false, 'message' => 'Halaman tidak ditemukan']);
            return;
        }
        
        // Handle image upload
        $featuredImageUrl = $page['featured_image_url'];
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $uploadedImage = $this->handleImageUpload($_FILES['featured_image'], 'profil');
            if ($uploadedImage) {
                // Delete old image
                if (!empty($page['featured_image_url']) && file_exists(__DIR__ . '/../../public' . $page['featured_image_url'])) {
                    unlink(__DIR__ . '/../../public' . $page['featured_image_url']);
                }
                $featuredImageUrl = $uploadedImage;
            }
        }
        
        // Update page
        $success = $profilPageModel->updateProfilPage(
            $id,
            $_POST['slug'],
            $_POST['page_title'],
            $_POST['page_subtitle'],
            $featuredImageUrl,
            $_POST['content_title'],
            $_POST['content_subtitle']
        );
        
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Halaman berhasil diupdate']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal mengupdate halaman']);
        }
    }

    public function renderProfilePageCreate()
    {
        $this->render("admin/profile-pages/create");
    }

    public function createProfilePage()
    {
        header('Content-Type: application/json');
        
        $profilPageModel = new \App\Models\ProfilPageModel();
        
        // Validate required fields
        if (empty($_POST['slug']) || empty($_POST['page_title']) || empty($_POST['page_subtitle']) 
            || empty($_POST['content_title']) || empty($_POST['content_subtitle'])) {
            echo json_encode(['success' => false, 'message' => 'Semua field wajib diisi']);
            return;
        }
        
        // Handle image upload
        $featuredImageUrl = null;
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $featuredImageUrl = $this->handleImageUpload($_FILES['featured_image'], 'profil');
        }
        
        // Create page
        $pageId = $profilPageModel->createProfilPage(
            $_POST['slug'],
            $_POST['page_title'],
            $_POST['page_subtitle'],
            $featuredImageUrl,
            $_POST['content_title'],
            $_POST['content_subtitle']
        );
        
        if ($pageId) {
            echo json_encode(['success' => true, 'message' => 'Halaman berhasil dibuat']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal membuat halaman']);
        }
    }

    public function renderPersonilList()
    {
        $personilModel = new PersonilModel();
        
        // Get filters from query params
        $filters = [];
        if (!empty($_GET['search'])) {
            $filters['search'] = $_GET['search'];
        }
        if (!empty($_GET['role']) && $_GET['role'] !== 'all') {
            $filters['role'] = $_GET['role'];
        }
        
        // Pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        // Get personils and counts
        $personils = $personilModel->getPersonilsForAdmin($filters, $limit, $offset);
        $totalPersonils = $personilModel->countPersonilsForAdmin($filters);
        $totalPages = ceil($totalPersonils / $limit);
        
        // Get counts by role for tabs
        $totalAll = $personilModel->countByRole();
        $totalDosen = $personilModel->countByRole('dosen');
        $totalTalent = $personilModel->countByRole('talent');
        
        $data = [
            'personils' => $personils,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalPersonils' => $totalPersonils,
            'totalAll' => $totalAll,
            'totalDosen' => $totalDosen,
            'totalTalent' => $totalTalent,
            'filters' => $filters,
            'offset' => $offset
        ];
        
        $this->render("admin/personil/list", $data);
    }
    
    public function deletePersonil($id)
    {
        header('Content-Type: application/json');
        
        $personilModel = new PersonilModel();
        $projectModel = new \App\Models\ProjectModel();
        
        // Check if personil exists
        $personil = $personilModel->getPersonilById($id);
        if (!$personil) {
            echo json_encode(['success' => false, 'message' => 'Personil tidak ditemukan']);
            return;
        }
        
        // Delete foto if exists
        if (!empty($personil['foto_url'])) {
            $fotoPath = __DIR__ . '/../../public' . $personil['foto_url'];
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }
        
        // Delete projects first
        $projectModel->deleteProjectsByPersonilId($id);
        
        // Delete personil
        if ($personilModel->deletePersonil($id)) {
            echo json_encode(['success' => true, 'message' => 'Personil berhasil dihapus']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus personil']);
        }
    }

    public function renderPersonilCreate()
    {
        $this->render("admin/personil/create");
    }
    
    public function createPersonil()
    {
        header('Content-Type: application/json');
        
        // Validate required fields
        if (empty($_POST['nama_lengkap']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['role'])) {
            echo json_encode(['success' => false, 'message' => 'Field wajib tidak boleh kosong']);
            return;
        }
        
        $db = \App\Database::getConnection();
        
        try {
            $db->beginTransaction();
            
            $userId = null;
            
            // Create user account if requested
            if (!empty($_POST['create_account']) && $_POST['create_account'] === 'true') {
                if (empty($_POST['username']) || empty($_POST['password'])) {
                    echo json_encode(['success' => false, 'message' => 'Username dan password wajib diisi untuk membuat akun']);
                    return;
                }
                
                $userModel = new UserModel();
                $userId = $userModel->createUser([
                    'username' => $_POST['username'],
                    'password' => $_POST['password'],
                    'role' => 'personil'
                ]);
                
                if (!$userId) {
                    $db->rollBack();
                    echo json_encode(['success' => false, 'message' => 'Gagal membuat akun user']);
                    return;
                }
            }
            
            // Handle photo upload
            $fotoUrl = null;
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $fotoUrl = $this->handlePhotoUpload($_FILES['photo']);
                if (!$fotoUrl) {
                    $db->rollBack();
                    echo json_encode(['success' => false, 'message' => 'Gagal upload foto']);
                    return;
                }
            }
            
            // Parse skills JSON
            $skills = [];
            if (!empty($_POST['skills'])) {
                $skills = json_decode($_POST['skills'], true) ?? [];
            }
            
            // Create personil
            $personilModel = new PersonilModel();
            $personilData = [
                'user_id' => $userId,
                'nama_lengkap' => $_POST['nama_lengkap'],
                'role' => $_POST['role'],
                'spesialisasi' => $_POST['spesialisasi'] ?? null,
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'location' => $_POST['location'] ?? null,
                'tanggal_bergabung' => $_POST['tanggal_bergabung'] ?? date('Y-m-d'),
                'bio' => $_POST['bio'] ?? null,
                'skillks' => json_encode($skills),
                'foto_url' => $fotoUrl
            ];
            
            $personilId = $personilModel->createPersonil($personilData);
            
            if (!$personilId) {
                $db->rollBack();
                echo json_encode(['success' => false, 'message' => 'Gagal membuat personil']);
                return;
            }
            
            // Create projects if any
            if (!empty($_POST['projects'])) {
                $projects = json_decode($_POST['projects'], true);
                if (is_array($projects)) {
                    $projectModel = new ProjectModel();
                    foreach ($projects as $project) {
                        if (!empty($project['title'])) {
                            $projectModel->createProject([
                                'personil_id' => $personilId,
                                'title' => $project['title'],
                                'description' => $project['description'] ?? ''
                            ]);
                        }
                    }
                }
            }
            
            $db->commit();
            
            echo json_encode([
                'success' => true,
                'message' => 'Personil berhasil dibuat',
                'personil_id' => $personilId
            ]);
            
        } catch (\Exception $e) {
            $db->rollBack();
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
    
    private function handlePhotoUpload($file)
    {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        
        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }
        
        if ($file['size'] > $maxSize) {
            return false;
        }
        
        $uploadDir = __DIR__ . '/../../public/upload/img/foto-profil/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'personil_' . time() . '_' . uniqid() . '.' . $extension;
        $filepath = $uploadDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return '/upload/img/foto-profil/' . $filename;
        }
        
        return false;
    }

    public function renderPersonilEdit($id)
    {
        $personilModel = new \App\Models\PersonilModel();
        $projectModel = new \App\Models\ProjectModel();
        
        $personil = $personilModel->getPersonilWithUser($id);
        
        if (!$personil) {
            header("Location: /admin/personil");
            exit;
        }
        
        // Parse skills JSON
        $personil['skills'] = !empty($personil['skillks']) ? json_decode($personil['skillks'], true) : [];
        
        // Get projects
        $personil['projects'] = $projectModel->getProjectsByPersonilId($id);
        
        $data = [
            "personil" => $personil,
        ];

        $this->render("admin/personil/edit", $data);
    }

    public function updatePersonil($id)
    {
        header('Content-Type: application/json');
        
        $personilModel = new \App\Models\PersonilModel();
        $projectModel = new \App\Models\ProjectModel();
        
        // Read JSON body
        $rawData = json_decode(file_get_contents('php://input'), true);
        
        if (empty($rawData)) {
            echo json_encode(['success' => false, 'message' => 'Data tidak boleh kosong']);
            return;
        }
        
        // Check if personil exists
        $personil = $personilModel->getPersonilById($id);
        if (!$personil) {
            echo json_encode(['success' => false, 'message' => 'Personil tidak ditemukan']);
            return;
        }
        
        // Prepare personil data
        $data = [
            'nama_lengkap' => $rawData['nama_lengkap'] ?? '',
            'role' => $rawData['role'] ?? 'talent',
            'spesialisasi' => $rawData['spesialisasi'] ?? '',
            'email' => $rawData['email'] ?? '',
            'phone' => $rawData['phone'] ?? '',
            'location' => $rawData['location'] ?? '',
            'tanggal_bergabung' => $rawData['tanggal_bergabung'] ?? null,
            'bio' => $rawData['bio'] ?? '',
            'skillks' => json_encode($rawData['skills'] ?? []),
            'foto_url' => $personil['foto_url'] // Keep existing photo for now
        ];
        
        // Update personil
        if (!$personilModel->updatePersonil($id, $data)) {
            echo json_encode(['success' => false, 'message' => 'Gagal update personil']);
            return;
        }
        
        // Handle projects - delete old and create new
        if (isset($rawData['projects'])) {
            $projectModel->deleteProjectsByPersonilId($id);
            
            foreach ($rawData['projects'] as $project) {
                if (!empty($project['title'])) {
                    $projectModel->createProject([
                        'personil_id' => $id,
                        'title' => $project['title'],
                        'description' => $project['description'] ?? ''
                    ]);
                }
            }
        }
        
        echo json_encode(['success' => true, 'message' => 'Data personil berhasil diupdate']);
    }
    
    public function renderApplicationsList()
    {
        $applicationModel = new \App\Models\JoinApplicationModel();
        
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
        
        // Pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        // Get applications and stats
        $applications = $applicationModel->getApplicationsForAdmin($filters, $limit, $offset);
        $totalApplications = $applicationModel->countApplicationsForAdmin($filters);
        $totalPages = ceil($totalApplications / $limit);
        $stats = $applicationModel->getApplicationStats();
        
        $data = [
            'applications' => $applications,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalApplications' => $totalApplications,
            'stats' => $stats,
            'filters' => $filters,
            'offset' => $offset
        ];
        
        $this->render("admin/applications/list", $data);
    }
    
    public function deleteApplication($id)
    {
        header('Content-Type: application/json');
        
        $applicationModel = new \App\Models\JoinApplicationModel();
        
        // Check if application exists
        $application = $applicationModel->getApplicationById($id);
        if (!$application) {
            echo json_encode(['success' => false, 'message' => 'Application tidak ditemukan']);
            return;
        }
        
        // Delete CV file if exists
        if (!empty($application['cv_file_path'])) {
            $cvPath = __DIR__ . '/../../public' . $application['cv_file_path'];
            if (file_exists($cvPath)) {
                unlink($cvPath);
            }
        }
        
        // Delete application
        if ($applicationModel->deleteApplication($id)) {
            echo json_encode(['success' => true, 'message' => 'Application berhasil dihapus']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus application']);
        }
    }

    public function renderApplicationView($id)
    {
        $applicationModel = new \App\Models\JoinApplicationModel();
        
        $application = $applicationModel->getApplicationById($id);
        
        if (!$application) {
            header('Location: /admin/join-applications');
            exit;
        }
        
        $data = [
            'application' => $application
        ];

        $this->render("admin/applications/detail", $data);
    }
    
    public function updateApplicationStatus($id)
    {
        header('Content-Type: application/json');
        
        $applicationModel = new \App\Models\JoinApplicationModel();
        
        // Read JSON body
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Validate input
        if (!isset($data['status']) || trim($data['status']) === '') {
            echo json_encode(['success' => false, 'message' => 'Status harus diisi']);
            return;
        }
        
        // Check if application exists
        $application = $applicationModel->getApplicationById($id);
        if (!$application) {
            echo json_encode(['success' => false, 'message' => 'Application tidak ditemukan']);
            return;
        }
        
        // Update status
        if (!$applicationModel->updateApplicationStatus($id, $data['status'])) {
            echo json_encode(['success' => false, 'message' => 'Gagal mengupdate status']);
            return;
        }
        
        // If status is 'accepted', create personil and invitation
        if ($data['status'] === 'accepted') {
            $personilModel = new \App\Models\PersonilModel();
            $invitationModel = new \App\Models\PersonilInvitationModel();
            
            // Check if personil already created from this application (by email)
            $db = \App\Database::getConnection();
            $stmt = $db->prepare("SELECT id FROM personil WHERE email = :email");
            $stmt->bindParam(':email', $application['email']);
            $stmt->execute();
            $existingPersonil = $stmt->fetch();
            
            if (!$existingPersonil) {
                // Create personil from application data
                $personilData = [
                    'user_id' => null,
                    'nama_lengkap' => $application['nama_lengkap'],
                    'role' => 'talent', // default role
                    'spesialisasi' => null,
                    'email' => $application['email'],
                    'phone' => $application['phone'],
                    'location' => null,
                    'tanggal_bergabung' => date('Y-m-d'),
                    'bio' => $application['alasan_bergabung'],
                    'skillks' => json_encode([]),
                    'foto_url' => null
                ];
                
                $personilId = $personilModel->createPersonil($personilData);
                
                if ($personilId) {
                    // Generate invitation secret key
                    $secretKey = $invitationModel->createInvitation($personilId, $id);
                    
                    if ($secretKey) {
                        echo json_encode([
                            'success' => true, 
                            'message' => 'Status berhasil diupdate dan personil telah dibuat',
                            'secret_key' => $secretKey,
                            'personil_id' => $personilId
                        ]);
                        return;
                    }
                }
            } else {
                echo json_encode([
                    'success' => true, 
                    'message' => 'Status berhasil diupdate (Personil sudah ada sebelumnya)'
                ]);
                return;
            }
        }
        
        echo json_encode(['success' => true, 'message' => 'Status berhasil diupdate']);
    }
    
    public function updateAdminNotes($id)
    {
        header('Content-Type: application/json');
        
        $applicationModel = new \App\Models\JoinApplicationModel();
        
        // Read JSON body
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Check if application exists
        $application = $applicationModel->getApplicationById($id);
        if (!$application) {
            echo json_encode(['success' => false, 'message' => 'Application tidak ditemukan']);
            return;
        }
        
        // Update notes (allow empty)
        $notes = $data['admin_notes'] ?? '';
        if ($applicationModel->updateAdminNotes($id, $notes)) {
            echo json_encode(['success' => true, 'message' => 'Catatan admin berhasil disimpan']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menyimpan catatan']);
        }
    }
}