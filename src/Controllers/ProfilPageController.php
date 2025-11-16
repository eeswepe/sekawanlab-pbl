<?php

namespace App\Controllers;

use App\Controller;
use App\Models\ProfilPageModel;

class ProfilPageController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new ProfilPageModel();
    }

    public function show($slug)
    {
        $data["profil"] = $this->model->getProfilPage($slug);
        $this->render("landing/profil/index", $data);
    }
}
