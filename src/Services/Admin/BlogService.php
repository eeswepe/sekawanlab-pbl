<?php

namespace App\Services\Admin;

use App\Models\BlogModel;
use App\Models\KategoriModel;
use App\Models\PersonilModel;
use App\Services\Shared\FileUploadService;

/**
 * BlogService
 * 
 * Service untuk admin blog management
 */
class BlogService
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
     * Get blogs with filters and pagination
     * 
     * @param array $rawFilters Raw filters dari $_GET
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getBlogsWithFilters(array $rawFilters, int $page = 1, int $limit = 10): array
    {
        // Normalize filters - Service menangani logika filtering
        $filters = $this->normalizeFilters($rawFilters);
        
        $offset = ($page - 1) * $limit;
        
        $blogs = $this->blogModel->getBlogsForAdmin($filters, $limit, $offset);
        $totalBlogs = $this->blogModel->countBlogsForAdmin($filters);
        $totalPages = ceil($totalBlogs / $limit);
        
        return [
            'blogs' => $blogs,
            'totalBlogs' => $totalBlogs,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'offset' => $offset
        ];
    }
    
    /**
     * Normalize and sanitize filters
     * 
     * @param array $rawFilters
     * @return array
     */
    private function normalizeFilters(array $rawFilters): array
    {
        $filters = [];
        
        if (!empty($rawFilters['search'])) {
            $filters['search'] = trim($rawFilters['search']);
        }
        
        if (!empty($rawFilters['kategori']) && $rawFilters['kategori'] !== 'all') {
            $filters['kategori_id'] = (int)$rawFilters['kategori'];
        }
        
        if (!empty($rawFilters['penulis']) && $rawFilters['penulis'] !== 'all') {
            $filters['penulis_id'] = (int)$rawFilters['penulis'];
        }
        
        if (!empty($rawFilters['status']) && $rawFilters['status'] !== 'all') {
            $filters['status'] = $rawFilters['status'];
        }
        
        return $filters;
    }
    
    /**
     * Get filter options (categories and personils)
     */
    public function getFilterOptions(): array
    {
        return [
            'categories' => $this->kategoriModel->getAllKategori(),
            'personils' => $this->personilModel->getAllPersonils()
        ];
    }
    
    /**
     * Get blog by ID
     */
    public function getBlogById(int $id): ?array
    {
        return $this->blogModel->getBlogById($id);
    }
    
    /**
     * Create new blog
     */
    public function createBlog(array $data, array $files = []): int
    {
        // Validate
        if (empty($data['judul']) || empty($data['konten']) || empty($data['kategori_id']) || empty($data['penulis_id'])) {
            throw new \Exception('Field wajib tidak boleh kosong');
        }
        
        // Get personil data
        $personil = $this->personilModel->getPersonilById($data['penulis_id']);
        if (!$personil) {
            throw new \Exception('Penulis tidak ditemukan');
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
            'penulis_id' => $data['penulis_id'],
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
     * Update existing blog
     */
    public function updateBlog(int $id, array $data, array $files = []): bool
    {
        // Validate
        $existingBlog = $this->blogModel->getBlogById($id);
        if (!$existingBlog) {
            throw new \Exception('Blog tidak ditemukan');
        }
        
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
        
        return $this->blogModel->updateBlog($id, $updateData);
    }
    
    /**
     * Delete blog
     */
    public function deleteBlog(int $id): bool
    {
        $blog = $this->blogModel->getBlogById($id);
        if (!$blog) {
            throw new \Exception('Blog tidak ditemukan');
        }
        
        // Delete image
        if (!empty($blog['featured_image_url'])) {
            $this->fileService->deleteFile($blog['featured_image_url']);
        }
        
        return $this->blogModel->deleteBlog($id);
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
     * Calculate reading time based on word count
     */
    private function calculateReadingTime(string $content): int
    {
        $wordCount = str_word_count(strip_tags($content));
        $readingTime = ceil($wordCount / 200);
        return max(1, $readingTime);
    }
    
    /**
     * Generate excerpt from content
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
     * Get publish date based on status
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
