<?php

namespace App\Controllers;

use App\Controller;
use App\Models\PersonilModel;

class PersonilController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new PersonilModel();
    }

    public function index()
    {
        $data["personils"] = $this->model->getAllPersonils();
        $this->render("personil/index", $data);
    }
}
