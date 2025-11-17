<?php

namespace App\Controllers;

use App\Controller;
use App\Services\Public\ProfilPagePublicService;
use Exception;

class ProfilPageController extends Controller
{
    private ProfilPagePublicService $profilPageService;

    public function __construct()
    {
        $this->profilPageService = new ProfilPagePublicService();
    }

    public function show($slug)
    {
        try {
            $data["profil"] = $this->profilPageService->getPageBySlug($slug);
            $this->render("landing/profil/index", $data);
        } catch (Exception $e) {
            http_response_code(404);
            echo "Halaman tidak ditemukan";
        }
    }
}
