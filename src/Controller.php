<?php

namespace App;

use App\Models\ProfilPageModel;

class Controller
{
    protected $profilModel;

    public function __construct()
    {
        // Inisialisasi profilModel hanya jika dibutuhkan
        // Child class bisa override constructor tanpa masalah
    }

    protected function render($view, $data = [])
    {
        // Lazy loading - hanya load profilModel jika belum di-set
        if ($this->profilModel === null) {
            $this->profilModel = new ProfilPageModel();
        }
        
        $data["list-profil"] = $this->profilModel->getProfilTitle();
        extract($data);
        include "Views/$view.php";
    }
}
