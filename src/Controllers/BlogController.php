<?php

namespace App\Controllers;

use App\Controller;
use App\Models\BlogModel;

class BlogController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new BlogModel();
    }

    public function index()
    {
        $data["blogs"] = $this->model->getAllBlogPosts();
        $this->render("blog/index", $data);
    }

    public function showBySlug($slug)
    {
        $blog = $this->model->getBlogBySlug($slug);
        
        if (!$blog) {
            header('Location: /blog');
            exit;
        }
        
        $data = [
            'blog' => $blog
        ];
        
        $this->render("blog/blog-detail", $data);
    }
}
