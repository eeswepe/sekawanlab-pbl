<?php
namespace App\Models;

use App\Database;
use PDO;

class AdminStatsModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Get total personil count
     */
    public function getTotalPersonil()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM personil");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    /**
     * Get total blog posts count
     */
    public function getTotalBlogPosts()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM blog_post");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    /**
     * Get pending applications count
     */
    public function getPendingApplications()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM join_application WHERE status = 'pending'");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    /**
     * Get total views (placeholder - views column not in schema)
     */
    public function getTotalViews()
    {
        return 0;
    }

    /**
     * Get recent activities
     */
    public function getRecentActivities($limit = 10)
    {
        $query = "
            SELECT 
                'blog' as type,
                p.nama_lengkap as nama,
                'Menambahkan Blog Baru' as aktivitas,
                bp.judul as target,
                bp.status,
                bp.created_at as waktu
            FROM blog_post bp
            JOIN personil p ON bp.penulis_id = p.id
            ORDER BY bp.created_at DESC
            LIMIT :limit
        ";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
