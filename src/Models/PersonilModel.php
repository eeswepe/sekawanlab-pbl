<?php
declare(strict_types=1);

namespace App\Models;

use App\BaseModel;
use App\Database;
use PDO;

class PersonilModel extends BaseModel
{
    public function __construct(?PDO $db = null)
    {
        $db = $db ?? Database::getConnection();
        parent::__construct($db);
        
        $this->table = 'personil';
        $this->primaryKey = 'id';
        $this->fillable = [
            'user_id',
            'nama_lengkap',
            'role',
            'spesialisasi',
            'email',
            'phone',
            'location',
            'tanggal_bergabung',
            'bio',
            'skillks',
            'foto_url',
            'created_at',
            'updated_at'
        ];
    }

    // Ambil semua personil
    public function getAllPersonils(): array
    {
        return $this->all();
    }

    // Ambil personil berdasarkan user_id
    public function getPersonilByUserId(int $userId): ?array
    {
        return $this->first(['user_id' => $userId]);
    }

    // Ambil personil berdasarkan id
    public function getPersonilById(int $id): ?array
    {
        return $this->find($id) ?: null;
    }

    // Statistik personil (total blogs, projects)
    public function getPersonilStats(int $personil_id): array
    {
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM blog_post WHERE penulis_id = :personil_id) AS total_blogs,
                    (SELECT COUNT(*) FROM project WHERE personil_id = :personil_id) AS total_projects";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':personil_id', $personil_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC) ?: ['total_blogs' => 0, 'total_projects' => 0];

        return [
            'total_blogs' => (int) ($result['total_blogs'] ?? 0),
            'total_projects' => (int) ($result['total_projects'] ?? 0)
        ];
    }

    // Ambil personil beserta project terkait
    public function getPersonilWithProjects(int $personil_id): ?array
    {
        $personil = $this->getPersonilById($personil_id);
        if ($personil === null) {
            return null;
        }

        $sql = "SELECT * FROM project WHERE personil_id = :personil_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':personil_id', $personil_id, PDO::PARAM_INT);
        $stmt->execute();
        $personil['projects'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Parse JSON field 'skillks' ke array 'skills'
        $personil['skills'] = [];
        if (!empty($personil['skillks'])) {
            $decoded = json_decode($personil['skillks'], true);
            if (is_array($decoded)) {
                $personil['skills'] = $decoded;
            }
        }

        return $personil;
    }

    // Update personil (pakai BaseModel::update)
    public function updatePersonil(int $id, array $data): bool
    {
        $data = $this->filterFillable($data);
        // pastikan skillks tersimpan sebagai JSON string jika diberikan array
        if (isset($data['skillks']) && is_array($data['skillks'])) {
            $data['skillks'] = json_encode($data['skillks']);
        }
        return $this->update($id, $data);
    }

    // Ambil personil dengan info user
    public function getPersonilWithUser(int $id): ?array
    {
        $sql = "SELECT p.*, u.username, u.role AS user_role
                FROM {$this->table} p
                LEFT JOIN users u ON p.user_id = u.id
                WHERE p.id = :id
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: null;
    }

    // Buat personil baru
    public function createPersonil(array $data)
    {
        $data = $this->filterFillable($data);
        if (isset($data['skillks']) && is_array($data['skillks'])) {
            $data['skillks'] = json_encode($data['skillks']);
        }

        return $this->create($data);
    }

    // Ambil personils untuk admin dengan filter & pagination
    public function getPersonilsForAdmin(array $filters = [], int $limit = 10, int $offset = 0): array
    {
        $sql = "SELECT p.*, u.username
                FROM {$this->table} p
                LEFT JOIN users u ON p.user_id = u.id
                WHERE 1=1";

        [$sql, $params] = $this->applyFiltersToSql($sql, $filters);

        $sql .= " ORDER BY p.created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hitung personil untuk admin sesuai filter
    public function countPersonilsForAdmin(array $filters = []): int
    {
        $sql = "SELECT COUNT(*) AS total FROM {$this->table} p WHERE 1=1";
        [$sql, $params] = $this->applyFiltersToSql($sql, $filters);

        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($res['total'] ?? 0);
    }

    // Count by role (jika role null → count semua)
    public function countByRole(?string $role = null): int
    {
        if ($role === null) {
            return $this->count();
        }
        return $this->count(['role' => $role]);
    }

    // Hapus personil
    public function deletePersonil(int $id): bool
    {
        return $this->delete($id);
    }

    /**
     * Helper untuk menambahkan kondisi filter ke SQL.
     * Mengembalikan tuple [$sql, $params]
     */
    protected function applyFiltersToSql(string $sql, array $filters): array
    {
        $params = [];

        if (!empty($filters['search'])) {
            $sql .= " AND p.nama_lengkap ILIKE :search";
            $params[':search'] = '%' . $filters['search'] . '%';
        }

        if (!empty($filters['role'])) {
            $sql .= " AND p.role = :role";
            $params[':role'] = $filters['role'];
        }

        return [$sql, $params];
    }
}
