<?php
declare(strict_types=1);

namespace App\Models;

use App\BaseModel;
use App\Database;
use PDO;

class BlogModel extends BaseModel
{
    public function __construct(?PDO $db = null)
    {
        $db = $db ?? Database::getConnection();
        parent::__construct($db);
        
        $this->table = 'blog_post';
        $this->primaryKey = 'id';
        $this->fillable = [
            'penulis_id',
            'kategori_id',
            'slug',
            'judul',
            'cuplikan',
            'konten',
            'penulis_nama',
            'penulis_bio',
            'tanggal_publish',
            'featured_image_url',
            'status',
            'reading_time'
        ];
    }

    // Ambil semua postingan
    public function getAllBlogPosts(): array
    {
        return $this->all();
    }

    /**
     * Get all published blog posts only
     */
    public function getAllPublishedBlogPosts(): array
    {
        $sql = "SELECT bp.id, bp.judul, bp.slug, bp.cuplikan, bp.featured_image_url,
                       bp.tanggal_publish, bp.reading_time, bp.penulis_nama, bp.penulis_bio,
                       k.name AS kategori_nama
                FROM {$this->table} bp
                LEFT JOIN kategori k ON bp.kategori_id = k.id
                WHERE bp.status = 'published'
                ORDER BY bp.tanggal_publish DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Recent posts by author
    public function getRecentBlogsByPenulis(int $penulis_id, int $limit = 5): array
    {
        $sql = "SELECT bp.id, bp.judul, bp.tanggal_publish, bp.created_at, bp.status,
                       k.name AS kategori_nama
                FROM {$this->table} bp
                LEFT JOIN kategori k ON bp.kategori_id = k.id
                WHERE bp.penulis_id = :penulis_id
                ORDER BY bp.created_at DESC
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':penulis_id', $penulis_id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Posts by author with pagination
    public function getBlogsByPenulis(int $penulis_id, int $limit = 10, int $offset = 0): array
    {
        $sql = "SELECT bp.id, bp.judul, bp.slug, bp.cuplikan, bp.featured_image_url,
                       bp.tanggal_publish, bp.created_at, bp.updated_at, bp.status,
                       bp.reading_time, k.name AS kategori_nama
                FROM {$this->table} bp
                LEFT JOIN kategori k ON bp.kategori_id = k.id
                WHERE bp.penulis_id = :penulis_id
                ORDER BY bp.created_at DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':penulis_id', $penulis_id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Total posts by author
    public function getTotalBlogsByPenulis(int $penulis_id): int
    {
        return (int) $this->count(['penulis_id' => $penulis_id]);
    }

    // Basic stats by author
    public function getBlogStatsByPenulis(int $penulis_id): array
    {
        $sql = "SELECT 
                    COUNT(*) AS total_posts,
                    COUNT(CASE WHEN status = 'published' THEN 1 END) AS published_posts,
                    COUNT(CASE WHEN status = 'draft' THEN 1 END) AS draft_posts
                FROM {$this->table}
                WHERE penulis_id = :penulis_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':penulis_id', $penulis_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    // Cari by id
    public function getBlogById(int $id): ?array
    {
        $sql = "SELECT bp.*, k.name AS kategori_nama
                FROM {$this->table} bp
                LEFT JOIN kategori k ON bp.kategori_id = k.id
                WHERE bp.id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: null;
    }

    // Hapus postingan
    public function deleteBlog(int $id): bool
    {
        return $this->delete($id);
    }

    // Create menggunakan BaseModel::create()
    public function createBlog(array $data)
    {
        $data = $this->filterFillable($data);

        // jika perlu meng-handle tanggal/format sebelum insert, lakukan di sini
        return $this->create($data);
    }

    // Update postingan
    public function updateBlog(int $id, array $data): bool
    {
        $data = $this->filterFillable($data);
        return $this->update($id, $data);
    }

    // Ambil by slug
    public function getBlogBySlug(string $slug): ?array
    {
        $sql = "SELECT bp.*, k.name AS kategori_nama
                FROM {$this->table} bp
                LEFT JOIN kategori k ON bp.kategori_id = k.id
                WHERE bp.slug = :slug
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();

        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: null;
    }

    /**
     * Ambil daftar untuk admin dengan filter, pagination, dan sanitasi order by.
     */
    public function getBlogsForAdmin(array $filters = [], int $limit = 10, int $offset = 0, string $orderBy = 'bp.created_at DESC'): array
    {
        // whitelist kolom/order untuk mencegah SQL injection
        $allowedOrders = [
            'created_at DESC' => 'bp.created_at DESC',
            'created_at ASC'  => 'bp.created_at ASC',
            'judul ASC'       => 'bp.judul ASC',
            'judul DESC'      => 'bp.judul DESC'
        ];

        $orderByKey = $orderBy;
        $orderSql = $allowedOrders[$orderByKey] ?? 'bp.created_at DESC';

        $sql = "SELECT bp.id, bp.judul, bp.featured_image_url, bp.tanggal_publish,
                       bp.status, bp.created_at, k.name AS kategori_nama, p.nama_lengkap AS penulis_nama
                FROM {$this->table} bp
                LEFT JOIN kategori k ON bp.kategori_id = k.id
                LEFT JOIN personil p ON bp.penulis_id = p.id
                WHERE 1=1";

        [$sql, $params] = $this->applyFiltersToSql($sql, $filters);

        $sql .= " ORDER BY {$orderSql} LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countBlogsForAdmin(array $filters = []): int
    {
        $sql = "SELECT COUNT(*) AS total FROM {$this->table} bp WHERE 1=1";
        [$sql, $params] = $this->applyFiltersToSql($sql, $filters);

        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();

        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($res['total'] ?? 0);
    }

    /**
     * Helper untuk menambahkan kondisi filter ke SQL dan mengembalikan params siap bind.
     * Menggunakan named params seperti :search, :kategori_id, dll.
     */
    protected function applyFiltersToSql(string $sql, array $filters): array
    {
        $params = [];

        if (!empty($filters['search'])) {
            $sql .= " AND bp.judul ILIKE :search";
            $params[':search'] = '%' . $filters['search'] . '%';
        }

        if (!empty($filters['kategori_id'])) {
            $sql .= " AND bp.kategori_id = :kategori_id";
            $params[':kategori_id'] = (int)$filters['kategori_id'];
        }

        if (!empty($filters['penulis_id'])) {
            $sql .= " AND bp.penulis_id = :penulis_id";
            $params[':penulis_id'] = (int)$filters['penulis_id'];
        }

        if (!empty($filters['status'])) {
            $sql .= " AND bp.status = :status";
            $params[':status'] = $filters['status'];
        }

        return [$sql, $params];
    }

    /**
     * Get published blogs with filters (for public)
     */
    public function getPublishedBlogsWithFilters(array $filters = [], int $limit = 12, int $offset = 0): array
    {
        $sql = "SELECT bp.id, bp.judul, bp.slug, bp.cuplikan, bp.featured_image_url,
                       bp.tanggal_publish, bp.reading_time, bp.penulis_nama, bp.penulis_bio,
                       k.name AS kategori_nama
                FROM {$this->table} bp
                LEFT JOIN kategori k ON bp.kategori_id = k.id
                WHERE bp.status = 'published'";

        [$sql, $params] = $this->applyPublicFiltersToSql($sql, $filters);

        $sql .= " ORDER BY bp.tanggal_publish DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Count published blogs with filters (for public)
     */
    public function countPublishedBlogsWithFilters(array $filters = []): int
    {
        $sql = "SELECT COUNT(*) AS total FROM {$this->table} bp WHERE bp.status = 'published'";
        [$sql, $params] = $this->applyPublicFiltersToSql($sql, $filters);

        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();

        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($res['total'] ?? 0);
    }

    /**
     * Get recent published blogs
     */
    public function getRecentBlogs(int $limit = 5): array
    {
        $sql = "SELECT bp.id, bp.judul, bp.slug, bp.cuplikan, bp.featured_image_url,
                       bp.tanggal_publish, bp.reading_time, bp.penulis_nama,
                       k.name AS kategori_nama
                FROM {$this->table} bp
                LEFT JOIN kategori k ON bp.kategori_id = k.id
                WHERE bp.status = 'published'
                ORDER BY bp.tanggal_publish DESC
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get featured blogs (can be based on criteria like most recent, or add a 'featured' flag)
     */
    public function getFeaturedBlogs(int $limit = 3): array
    {
        // For now, just return most recent published blogs
        // You can add a 'is_featured' column later if needed
        return $this->getRecentBlogs($limit);
    }

    /**
     * Get related blogs based on same category
     */
    public function getRelatedBlogs(int $blogId, int $kategoriId, int $limit = 3): array
    {
        $sql = "SELECT bp.id, bp.judul, bp.slug, bp.cuplikan, bp.featured_image_url,
                       bp.tanggal_publish, bp.reading_time, bp.penulis_nama,
                       k.name AS kategori_nama
                FROM {$this->table} bp
                LEFT JOIN kategori k ON bp.kategori_id = k.id
                WHERE bp.status = 'published'
                  AND bp.kategori_id = :kategori_id
                  AND bp.id != :blog_id
                ORDER BY bp.tanggal_publish DESC
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':kategori_id', $kategoriId, PDO::PARAM_INT);
        $stmt->bindValue(':blog_id', $blogId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Helper for public filters (search by title, filter by category)
     */
    protected function applyPublicFiltersToSql(string $sql, array $filters): array
    {
        $params = [];

        if (!empty($filters['search'])) {
            $sql .= " AND bp.judul ILIKE :search";
            $params[':search'] = '%' . $filters['search'] . '%';
        }

        if (!empty($filters['kategori_id'])) {
            $sql .= " AND bp.kategori_id = :kategori_id";
            $params[':kategori_id'] = (int)$filters['kategori_id'];
        }

        return [$sql, $params];
    }
}
