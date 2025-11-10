<?php

namespace App;

use App\Models\ProfilPageModel;

class Controller
{
    protected $profilModel;

    public function __construct()
    {
        $this->profilModel = new ProfilPageModel();
    }

    protected function render($view, $data = [])
    {
        $data["list-profil"] = $this->profilModel->getProfilTitle();
        extract($data);
        include "Views/$view.php";
    }
}
