<?php

namespace App\Controllers;

use App\Controller;
use App\Services\Public\BlogPublicService;

/**
 * BlogController (REFACTORED)
 * 
 * Controller untuk handle blog di area public
 * Menggunakan BlogPublicService untuk business logic
 */
class BlogController extends Controller
{
    private $blogService;

    public function __construct()
    {
        $this->blogService = new BlogPublicService();
    }

    /**
     * Display all published blogs
     * 
     * GET /blog
     */
    public function index()
    {
        $blogs = $this->blogService->getAllPublishedBlogs();
        $categories = $this->blogService->getAllCategories();

        $data = [
            'blogs' => $blogs,
            'categories' => $categories
        ];

        $this->render("landing/blog/list", $data);
    }

    /**
     * Display blog detail by slug
     * 
     * GET /blog/{slug}
     */
    public function showBySlug($slug)
    {
        $blog = $this->blogService->getBlogBySlug($slug);

        if (!$blog) {
            header('Location: /blog');
            exit;
        }

        $data = [
            'blog' => $blog
        ];

        $this->render("landing/blog/detail", $data);
    }
}
