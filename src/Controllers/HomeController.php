<?php

namespace App\Controllers;

use App\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $data["list-profil"] = $this->profilModel->getProfilTitle();
        $this->render("index", $data);
    }
}
