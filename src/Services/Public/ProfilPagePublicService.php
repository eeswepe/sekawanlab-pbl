<?php

namespace App\Services\Public;

use App\Models\ProfilPageModel;
use Exception;

class ProfilPagePublicService
{
    private ProfilPageModel $profilPageModel;

    public function __construct()
    {
        $this->profilPageModel = new ProfilPageModel();
    }

    /**
     * Get profile page by slug for public display
     * 
     * @param string $slug
     * @return array
     * @throws Exception
     */
    public function getPageBySlug(string $slug): array
    {
        if (empty($slug)) {
            throw new Exception("Slug tidak boleh kosong");
        }

        $page = $this->profilPageModel->getProfilPage($slug);
        
        if (!$page) {
            throw new Exception("Halaman profil tidak ditemukan");
        }

        return $page;
    }

    /**
     * Get all published profile pages
     * 
     * @return array
     */
    public function getAllPublishedPages(): array
    {
        return $this->profilPageModel->getAllProfilPages();
    }

    /**
     * Check if page exists by slug
     * 
     * @param string $slug
     * @return bool
     */
    public function pageExists(string $slug): bool
    {
        try {
            $page = $this->profilPageModel->getProfilPage($slug);
            return !empty($page);
        } catch (Exception $e) {
            return false;
        }
    }
}
