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

    public function dashboard()
    {
        $this->render("personil/dashboard");
    }

    public function index()
    {
        $data["personils"] = $this->model->getAllPersonils();
        $this->render("personil/index", $data);
    }

    public function renderBlogCreate()
    {
        $this->render("personil/personil_blog_create");
    }

    public function renderBlogList()
    {
        $this->render("personil/personil_blog_list");
    }

    public function renderBlogEdit($id)
    {
        $data = [
            "blog_id" => $id,
        ];

        $this->render("personil/personil_blog_edit", $data);
    }

    public function renderProfile()
    {
        $this->render("personil/personil_profile-view");
    }

    public function renderProfileEdit()
    {
        $this->render("personil/personil_profile-edit");
    }
}