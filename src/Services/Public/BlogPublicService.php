<?php

namespace App\Services\Public;

use App\Models\BlogModel;

/**
 * BlogPublicService
 * 
 * Service untuk handle blog functionality di area public
 */
class BlogPublicService
{
    private $blogModel;

    public function __construct()
    {
        $this->blogModel = new BlogModel();
    }

    /**
     * Get all published blogs
     */
    public function getAllPublishedBlogs(): array
    {
        return $this->blogModel->getAllPublishedBlogPosts();
    }

    /**
     * Get blog by slug
     */
    public function getBlogBySlug(string $slug): ?array
    {
        $blog = $this->blogModel->getBlogBySlug($slug);

        if (!$blog || $blog['status'] !== 'published') {
            return null;
        }

        return $blog;
    }

    /**
     * Get blogs with pagination and filters
     */
    public function getBlogsWithFilters(array $filters = [], int $page = 1, int $limit = 12): array
    {
        $offset = ($page - 1) * $limit;

        $blogs = $this->blogModel->getPublishedBlogsWithFilters($filters, $limit, $offset);
        $totalBlogs = $this->blogModel->countPublishedBlogsWithFilters($filters);
        $totalPages = ceil($totalBlogs / $limit);

        return [
            'blogs' => $blogs,
            'totalBlogs' => $totalBlogs,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ];
    }

    /**
     * Get recent blogs
     */
    public function getRecentBlogs(int $limit = 5): array
    {
        return $this->blogModel->getRecentBlogs($limit);
    }

    /**
     * Get featured blogs
     */
    public function getFeaturedBlogs(int $limit = 3): array
    {
        return $this->blogModel->getFeaturedBlogs($limit);
    }

    /**
     * Get related blogs based on category
     */
    public function getRelatedBlogs(int $blogId, int $kategoriId, int $limit = 3): array
    {
        return $this->blogModel->getRelatedBlogs($blogId, $kategoriId, $limit);
    }
    /**
     * Get all categories with count
     */
    public function getAllCategories(): array
    {
        return $this->blogModel->getAllCategoriesWithCount();
    }
}
