<?php
namespace App\Models;

use App;
use App\BaseModel;
use App\Database;
use PDO;
    
class AdminStatsModel extends BaseModel
{
    public function __construct(?PDO $db = null)
    {
        $db = $db ?? Database::getConnection();
        parent::__construct($db);
    }

    /**
     * Membantu menjalankan query di tabel tertentu secara sementara.
     */
    protected function withTable(string $table, callable $callback)
    {
        $old = $this->table;
        $this->table = $table;

        try {
            return $callback();
        } finally {
            $this->table = $old;
        }
    }

    /**
     * Total data personil.
     */
    public function getTotalPersonil(): int
    {
        return (int) $this->withTable('personil', fn() => $this->count());
    }

    /**
     * Total postingan blog.
     */
    public function getTotalBlogPosts(): int
    {
        return (int) $this->withTable('blog_post', fn() => $this->count());
    }

    /**
     * Total aplikasi masuk yang statusnya pending.
     */
    public function getPendingApplications(): int
    {
        return (int) $this->withTable('join_application', fn() => $this->count(['status' => 'pending']));
    }

    /**
     * Aktivitas terbaru dari blog & aplikasi join.
     */
    public function getRecentActivities(int $limit = 10): array
    {
        $query = "
            SELECT 
                'blog' AS type,
                p.nama_lengkap AS nama,
                'Menambahkan Blog Baru' AS aktivitas,
                bp.judul AS target,
                bp.status,
                bp.created_at AS waktu
            FROM blog_post bp
            JOIN personil p ON bp.penulis_id = p.id

            UNION ALL

            SELECT
                'application' AS type,
                ja.nama_lengkap AS nama,
                'Mengajukan Permintaan Bergabung' AS aktivitas,
                ja.email AS target,
                ja.status,
                ja.tanggal_apply AS waktu
            FROM join_application ja

            ORDER BY waktu DESC
            LIMIT :limit
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
