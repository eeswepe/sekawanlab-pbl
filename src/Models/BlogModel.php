<?php

namespace App\Models;

use App\Database;
use PDO;

class BlogModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAllBlogPosts(): array
    {
        $query = "SELECT * FROM blog_post";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get recent blog posts by penulis_id
     * @param int $penulis_id
     * @param int $limit
     * @return array
     */
    public function getRecentBlogsByPenulis($penulis_id, $limit = 5)
    {
        $sql = "SELECT 
                    bp.id,
                    bp.judul,
                    bp.tanggal_publish,
                    bp.created_at,
                    bp.status,
                    k.name as kategori_nama
                FROM blog_post bp
                LEFT JOIN kategori k ON bp.kategori_id = k.id
                WHERE bp.penulis_id = :penulis_id
                ORDER BY bp.created_at DESC
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':penulis_id', $penulis_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all blog posts by penulis_id with pagination
     * @param int $penulis_id
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getBlogsByPenulis($penulis_id, $limit = 10, $offset = 0)
    {
        $sql = "SELECT 
                    bp.id,
                    bp.judul,
                    bp.slug,
                    bp.cuplikan,
                    bp.featured_image_url,
                    bp.tanggal_publish,
                    bp.created_at,
                    bp.updated_at,
                    bp.status,
                    bp.reading_time,
                    k.name as kategori_nama
                FROM blog_post bp
                LEFT JOIN kategori k ON bp.kategori_id = k.id
                WHERE bp.penulis_id = :penulis_id
                ORDER BY bp.created_at DESC
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':penulis_id', $penulis_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get total blog count by penulis_id
     * @param int $penulis_id
     * @return int
     */
    public function getTotalBlogsByPenulis($penulis_id)
    {
        $sql = "SELECT COUNT(*) as total FROM blog_post WHERE penulis_id = :penulis_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':penulis_id', $penulis_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['total'];
    }

    /**
     * Get blog statistics by penulis_id
     * @param int $penulis_id
     * @return array
     */
    public function getBlogStatsByPenulis($penulis_id)
    {
        $sql = "SELECT 
                    COUNT(*) as total_posts,
                    COUNT(CASE WHEN status = 'published' THEN 1 END) as published_posts,
                    COUNT(CASE WHEN status = 'draft' THEN 1 END) as draft_posts
                FROM blog_post 
                WHERE penulis_id = :penulis_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':penulis_id', $penulis_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get blog post by id
     * @param int $id
     * @return array|null
     */
    public function getBlogById($id)
    {
        $sql = "SELECT 
                    bp.*,
                    k.name as kategori_nama
                FROM blog_post bp
                LEFT JOIN kategori k ON bp.kategori_id = k.id
                WHERE bp.id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Delete blog post by id
     * @param int $id
     * @return bool
     */
    public function deleteBlog($id)
    {
        $sql = "DELETE FROM blog_post WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    /**
     * Create new blog post
     * @param array $data
     * @return int|bool - ID of created blog or false
     */
    public function createBlog($data)
    {
        $sql = "INSERT INTO blog_post (
                    penulis_id, 
                    kategori_id, 
                    slug, 
                    judul, 
                    cuplikan, 
                    konten, 
                    penulis_nama, 
                    penulis_bio, 
                    tanggal_publish, 
                    featured_image_url, 
                    status, 
                    reading_time
                ) VALUES (
                    :penulis_id, 
                    :kategori_id, 
                    :slug, 
                    :judul, 
                    :cuplikan, 
                    :konten, 
                    :penulis_nama, 
                    :penulis_bio, 
                    :tanggal_publish, 
                    :featured_image_url, 
                    :status, 
                    :reading_time
                ) RETURNING id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':penulis_id', $data['penulis_id'], PDO::PARAM_INT);
        $stmt->bindParam(':kategori_id', $data['kategori_id'], PDO::PARAM_INT);
        $stmt->bindParam(':slug', $data['slug'], PDO::PARAM_STR);
        $stmt->bindParam(':judul', $data['judul'], PDO::PARAM_STR);
        $stmt->bindParam(':cuplikan', $data['cuplikan'], PDO::PARAM_STR);
        $stmt->bindParam(':konten', $data['konten'], PDO::PARAM_STR);
        $stmt->bindParam(':penulis_nama', $data['penulis_nama'], PDO::PARAM_STR);
        $stmt->bindParam(':penulis_bio', $data['penulis_bio'], PDO::PARAM_STR);
        $stmt->bindParam(':tanggal_publish', $data['tanggal_publish']);
        $stmt->bindParam(':featured_image_url', $data['featured_image_url'], PDO::PARAM_STR);
        $stmt->bindParam(':status', $data['status'], PDO::PARAM_STR);
        $stmt->bindParam(':reading_time', $data['reading_time'], PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['id'];
        }
        
        return false;
    }

    /**
     * Update blog post
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateBlog($id, $data)
    {
        $sql = "UPDATE blog_post SET 
                    kategori_id = :kategori_id,
                    slug = :slug,
                    judul = :judul,
                    cuplikan = :cuplikan,
                    konten = :konten,
                    tanggal_publish = :tanggal_publish,
                    featured_image_url = :featured_image_url,
                    status = :status,
                    reading_time = :reading_time,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':kategori_id', $data['kategori_id'], PDO::PARAM_INT);
        $stmt->bindParam(':slug', $data['slug'], PDO::PARAM_STR);
        $stmt->bindParam(':judul', $data['judul'], PDO::PARAM_STR);
        $stmt->bindParam(':cuplikan', $data['cuplikan'], PDO::PARAM_STR);
        $stmt->bindParam(':konten', $data['konten'], PDO::PARAM_STR);
        $stmt->bindParam(':tanggal_publish', $data['tanggal_publish']);
        $stmt->bindParam(':featured_image_url', $data['featured_image_url'], PDO::PARAM_STR);
        $stmt->bindParam(':status', $data['status'], PDO::PARAM_STR);
        $stmt->bindParam(':reading_time', $data['reading_time'], PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function getBlogBySlug($slug)
    {
        $sql = "SELECT 
                    bp.*,
                    k.name as kategori_nama
                FROM blog_post bp
                LEFT JOIN kategori k ON bp.kategori_id = k.id
                WHERE bp.slug = :slug";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

