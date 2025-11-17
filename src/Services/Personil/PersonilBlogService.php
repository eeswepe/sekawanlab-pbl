<?php

namespace App\Services\Personil;

use App\Models\BlogModel;
use App\Models\KategoriModel;
use App\Models\PersonilModel;
use App\Services\Shared\FileUploadService;

/**
 * PersonilBlogService
 * 
 * Service untuk handle blog management di area personil
 */
class PersonilBlogService
{
    private $blogModel;
    private $kategoriModel;
    private $personilModel;
    private $fileService;
    
    public function __construct()
    {
        $this->blogModel = new BlogModel();
        $this->kategoriModel = new KategoriModel();
        $this->personilModel = new PersonilModel();
        $this->fileService = new FileUploadService();
    }
    
    /**
     * Get all categories
     */
    public function getAllCategories(): array
    {
        return $this->kategoriModel->getAllKategori();
    }
    
    /**
     * Get blogs by personil with pagination
     */
    public function getBlogsByPersonil(int $personilId, int $page = 1, int $limit = 10): array
    {
        $offset = ($page - 1) * $limit;
        
        $blogs = $this->blogModel->getBlogsByPenulis($personilId, $limit, $offset);
        $totalBlogs = $this->blogModel->getTotalBlogsByPenulis($personilId);
        $totalPages = ceil($totalBlogs / $limit);
        $stats = $this->blogModel->getBlogStatsByPenulis($personilId);
        
        return [
            'blogs' => $blogs,
            'totalBlogs' => $totalBlogs,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'stats' => $stats
        ];
    }
    
    /**
     * Get blog by ID (check ownership)
     */
    public function getBlogForEdit(int $blogId, int $personilId): ?array
    {
        $blog = $this->blogModel->getBlogById($blogId);
        
        if (!$blog || $blog['penulis_id'] != $personilId) {
            return null;
        }
        
        return $blog;
    }
    
    /**
     * Create new blog
     */
    public function createBlog(array $data, array $files, int $personilId): int
    {
        // Validate
        if (empty($data['judul']) || empty($data['konten']) || empty($data['kategori_id'])) {
            throw new \Exception('Field wajib tidak boleh kosong');
        }
        
        // Get personil data
        $personil = $this->personilModel->getPersonilById($personilId);
        if (!$personil) {
            throw new \Exception('Personil tidak ditemukan');
        }
        
        // Handle image upload
        $featuredImageUrl = null;
        if (!empty($files['featured_image']) && $files['featured_image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->fileService->uploadImage($files['featured_image'], 'blog', 'blog_');
            
            if (!$uploadResult['success']) {
                throw new \Exception($uploadResult['message']);
            }
            
            $featuredImageUrl = $uploadResult['path'];
        }
        
        // Prepare blog data
        $blogData = [
            'penulis_id' => $personilId,
            'kategori_id' => $data['kategori_id'],
            'slug' => $this->generateSlug($data['judul']),
            'judul' => $data['judul'],
            'cuplikan' => $data['cuplikan'] ?? $this->generateExcerpt($data['konten']),
            'konten' => $data['konten'],
            'penulis_nama' => $personil['nama_lengkap'],
            'penulis_bio' => $personil['bio'] ?? '',
            'tanggal_publish' => $data['status'] === 'published' ? date('Y-m-d H:i:s') : null,
            'featured_image_url' => $featuredImageUrl,
            'status' => $data['status'],
            'reading_time' => $this->calculateReadingTime($data['konten'])
        ];
        
        return $this->blogModel->createBlog($blogData);
    }
    
    /**
     * Update blog
     */
    public function updateBlog(int $blogId, array $data, array $files, int $personilId): bool
    {
        // Check ownership
        $existingBlog = $this->blogModel->getBlogById($blogId);
        if (!$existingBlog || $existingBlog['penulis_id'] != $personilId) {
            throw new \Exception('Blog tidak ditemukan atau Anda tidak memiliki akses');
        }
        
        // Validate
        if (empty($data['judul']) || empty($data['konten']) || empty($data['kategori_id'])) {
            throw new \Exception('Field wajib tidak boleh kosong');
        }
        
        // Handle image upload
        $featuredImageUrl = $existingBlog['featured_image_url'];
        if (!empty($files['featured_image']) && $files['featured_image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->fileService->uploadImage($files['featured_image'], 'blog', 'blog_');
            
            if ($uploadResult['success']) {
                // Delete old image
                if ($featuredImageUrl) {
                    $this->fileService->deleteFile($featuredImageUrl);
                }
                $featuredImageUrl = $uploadResult['path'];
            }
        }
        
        // Prepare update data
        $updateData = [
            'kategori_id' => $data['kategori_id'],
            'slug' => $existingBlog['slug'],
            'judul' => $data['judul'],
            'cuplikan' => $data['cuplikan'] ?? $this->generateExcerpt($data['konten']),
            'konten' => $data['konten'],
            'tanggal_publish' => $this->getPublishDate($data['status'], $existingBlog['tanggal_publish']),
            'featured_image_url' => $featuredImageUrl,
            'status' => $data['status'],
            'reading_time' => $this->calculateReadingTime($data['konten'])
        ];
        
        return $this->blogModel->updateBlog($blogId, $updateData);
    }
    
    /**
     * Delete blog
     */
    public function deleteBlog(int $blogId, int $personilId): bool
    {
        $blog = $this->blogModel->getBlogById($blogId);
        
        if (!$blog || $blog['penulis_id'] != $personilId) {
            throw new \Exception('Blog tidak ditemukan atau Anda tidak memiliki akses');
        }
        
        // Delete image
        if (!empty($blog['featured_image_url'])) {
            $this->fileService->deleteFile($blog['featured_image_url']);
        }
        
        return $this->blogModel->deleteBlog($blogId);
    }
    
    /**
     * Generate slug from title
     */
    private function generateSlug(string $title): string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $slug = preg_replace('/-+/', '-', $slug);
        return trim($slug, '-') . '-' . time();
    }
    
    /**
     * Calculate reading time
     */
    private function calculateReadingTime(string $content): int
    {
        $wordCount = str_word_count(strip_tags($content));
        $readingTime = ceil($wordCount / 200);
        return max(1, $readingTime);
    }
    
    /**
     * Generate excerpt
     */
    private function generateExcerpt(string $content, int $length = 150): string
    {
        $text = strip_tags($content);
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . '...';
    }
    
    /**
     * Get publish date
     */
    private function getPublishDate(string $status, ?string $currentPublishDate): ?string
    {
        if ($status === 'published' && !$currentPublishDate) {
            return date('Y-m-d H:i:s');
        } elseif ($status === 'draft') {
            return null;
        }
        return $currentPublishDate;
    }
}
