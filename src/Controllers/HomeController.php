<?php

namespace App\Controllers;

use App\Controller;
use App\Models\PersonilModel;
use App\Models\ProjectModel;
use App\Models\KategoriModel;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch dynamic stats
        $personilModel = new PersonilModel();
        $projectModel = new ProjectModel();
        $kategoriModel = new KategoriModel();

        $studentsCount = (int) $personilModel->countByRole('talent');
        $researchersCount = (int) $personilModel->countByRole('dosen');
        $projectsCount = (int) $projectModel->count();

        $categories = $kategoriModel->getAllKategori();

        $this->render("landing/home/index", [
            'studentsCount' => $studentsCount,
            'researchersCount' => $researchersCount,
            'projectsCount' => $projectsCount,
            'categories' => $categories,
        ]);
    }
}
