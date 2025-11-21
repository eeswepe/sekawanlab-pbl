<?php

namespace App\Services\Admin;

use App\Models\ProfilPageModel;
use App\Services\Shared\FileUploadService;

/**
 * ProfilePageService
 * 
 * Service untuk admin profile page management
 */
class ProfilePageService
{
    private $profilPageModel;
    private $fileService;
    
    public function __construct()
    {
        $this->profilPageModel = new ProfilPageModel();
        $this->fileService = new FileUploadService();
    }
    
    /**
     * Get all profile pages
     */
    public function getAllPages(): array
    {
        return $this->profilPageModel->getAllProfilPages();
    }
    
    /**
     * Get profile page by ID
     */
    public function getPageById(int $id): ?array
    {
        return $this->profilPageModel->getProfilPageById($id);
    }
    
    /**
     * Create new profile page
     */
    public function createPage(array $data, array $files): int
    {
        // Validate
        if (empty($data['slug']) || empty($data['page_title']) || empty($data['page_subtitle']) || empty($data['content_title']) || empty($data['content_subtitle'])) {
            throw new \Exception('Field wajib tidak boleh kosong');
        }
        
        // Handle image upload
        $featuredImageUrl = null;
        if (!empty($files['featured_image']) && $files['featured_image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->fileService->uploadImage($files['featured_image'], 'profil', 'profil_');
            
            if (!$uploadResult['success']) {
                throw new \Exception($uploadResult['message']);
            }
            
            $featuredImageUrl = $uploadResult['path'];
        }
        
        // Map fields to model signature
        $slug = $data['slug'];
        $pageTitle = $data['page_title'];
        $pageSubtitle = $data['page_subtitle'];
        $contentTitle = $data['content_title'] ?? null;
        $contentSubtitle = $data['content_subtitle'] ?? null;

        // Create page (model expects: slug, pageTitle, pageSubtitle, featuredImageUrl, contentTitle, contentSubtitle)
        $pageId = $this->profilPageModel->createProfilPage(
            $slug,
            $pageTitle,
            $pageSubtitle,
            $featuredImageUrl,
            $contentTitle,
            $contentSubtitle
        );
        
        if (!$pageId) {
            throw new \Exception('Gagal membuat halaman profil');
        }
        
        return $pageId;
    }
    
    /**
     * Update profile page
     */
    public function updatePage(int $id, array $data, array $files): bool
    {
        // Check if page exists
        $page = $this->profilPageModel->getProfilPageById($id);
        if (!$page) {
            throw new \Exception('Halaman tidak ditemukan');
        }
        
        // Handle image upload
        $featuredImageUrl = $page['featured_image_url'];
        if (!empty($files['featured_image']) && $files['featured_image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $this->fileService->uploadImage($files['featured_image'], 'profil', 'profil_');
            
            if ($uploadResult['success']) {
                // Delete old image if exists
                if ($featuredImageUrl) {
                    $this->fileService->deleteFile($featuredImageUrl);
                }
                $featuredImageUrl = $uploadResult['path'];
            }
        }
        
        // Map incoming data
        $slug = $data['slug'] ?? $page['slug'];
        $pageTitle = $data['page_title'] ?? $page['page_title'];
        $pageSubtitle = $data['page_subtitle'] ?? $page['page_subtitle'];
        $contentTitle = $data['content_title'] ?? $page['content_title'];
        $contentSubtitle = $data['content_subtitle'] ?? $page['content_subtitle'];

        // Update page (signature: id, slug, pageTitle, pageSubtitle, featuredImageUrl, contentTitle, contentSubtitle)
        $success = $this->profilPageModel->updateProfilPage(
            $id,
            $slug,
            $pageTitle,
            $pageSubtitle,
            $featuredImageUrl,
            $contentTitle,
            $contentSubtitle
        );
        
        if (!$success) {
            throw new \Exception('Gagal mengupdate halaman');
        }
        
        return true;
    }
    
    /**
     * Delete profile page
     */
    public function deletePage(int $id): bool
    {
        $page = $this->profilPageModel->getProfilPageById($id);
        if (!$page) {
            throw new \Exception('Halaman tidak ditemukan');
        }
        
        // Delete image if exists
        if (!empty($page['featured_image_url'])) {
            $this->fileService->deleteFile($page['featured_image_url']);
        }
        
        return $this->profilPageModel->deleteProfilPage($id);
    }
}
