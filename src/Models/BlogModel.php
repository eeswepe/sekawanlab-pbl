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

    public function getAllBlogPosts()
    {
        $query = "SELECT * FROM blog_post";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
