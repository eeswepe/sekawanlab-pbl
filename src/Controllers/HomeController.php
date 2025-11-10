<?php

namespace App\Controllers;

use App\Controller;
use App\Models\ProfilPageModel;

class HomeController extends Controller
{
    public function index()
    {
        $data["list-profil"] = $this->profilModel->getProfilTitle();
        $this->render("index", $data);
    }
}
