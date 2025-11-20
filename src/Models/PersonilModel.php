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
            'nim_nip',
            'password',
            'nama_lengkap',
            'role',
            'spesialisasi',
            'email',
            'phone',
            'location',
            'tanggal_bergabung',
            'bio',
            'skills',
            'foto_url',
            'created_at',
            'updated_at'
        ];
    }

    // ============================================
    // AUTHENTICATION METHODS
    // ============================================

    /**
     * Validasi credentials (nim_nip dan password)
     * 
     * @param string $nimNip NIM/NIP untuk login
     * @param string $password Password
     * @return array|false Personil data jika valid, false jika tidak
     */
    public function validateCredentials(string $nimNip, string $password): array|false
    {
        $personil = $this->getPersonilByNimNip($nimNip);
        if ($personil === null) {
            return false;
        }

        if (!isset($personil['password'])) {
            return false;
        }

        if (password_verify($password, $personil['password'])) {
            // Return data tanpa password
            unset($personil['password']);
            return $personil;
        }

        return false;
    }

    /**
     * Ambil personil berdasarkan nim_nip (untuk login)
     * 
     * @param string $nimNip
     * @return array|null
     */
    public function getPersonilByNimNip(string $nimNip): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE nim_nip = :nim_nip LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nim_nip', $nimNip, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: null;
    }

    public function passwordExist($nimNip): bool
    {
        $sql = "SELECT password FROM {$this->table} WHERE nim_nip = :nim_nip LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nim_nip', $nimNip);
        $stmt->execute();

        return ($stmt->fetchColumn() !== null);
    }


    /**
     * Cek apakah nim_nip sudah ada
     * 
     * @param string $nimNip
     * @param int|null $excludeId ID personil yang dikecualikan (untuk update)
     * @return bool
     */
    public function nimNipExists(string $nimNip, ?int $excludeId = null): bool
    {
        if ($excludeId !== null) {
            $sql = "SELECT COUNT(*) FROM {$this->table} WHERE nim_nip = :nim_nip AND id != :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':nim_nip', $nimNip, PDO::PARAM_STR);
            $stmt->bindValue(':id', $excludeId, PDO::PARAM_INT);
        } else {
            $sql = "SELECT COUNT(*) FROM {$this->table} WHERE nim_nip = :nim_nip";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':nim_nip', $nimNip, PDO::PARAM_STR);
        }

        $stmt->execute();
        return (int)$stmt->fetchColumn() > 0;
    }

    /**
     * Ganti password personil
     * 
     * @param int $id
     * @param string $newPassword
     * @return bool
     */
    public function changePassword(int $id, string $newPassword): bool
    {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->update($id, ['password' => $hash]);
    }

    /**
     * Ambil personil berdasarkan role
     * 
     * @param string $role admin / dosen / talent
     * @return array
     */
    public function getPersonilsByRole(string $role): array
    {
        if (!in_array($role, ['admin', 'dosen', 'talent'], true)) {
            return [];
        }

        $sql = "SELECT * FROM {$this->table} WHERE role = :role ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':role', $role, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ambil semua admin dan dosen (yang punya privilege tinggi)
     * 
     * @return array
     */
    public function getAdminsAndDosen(): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE role IN ('admin', 'dosen') ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Count personil berdasarkan role
     * 
     * @param string|null $role
     * @return int
     */
    public function countByRole(?string $role = null): int
    {
        if ($role !== null && in_array($role, ['admin', 'dosen', 'talent'], true)) {
            return $this->count(['role' => $role]);
        }
        return $this->count();
    }

    /**
     * Check apakah personil memiliki privilege admin (admin atau dosen)
     * 
     * @param int $personilId
     * @return bool
     */
    public function hasAdminPrivilege(int $personilId): bool
    {
        $personil = $this->getPersonilById($personilId);
        if ($personil === null) {
            return false;
        }
        return in_array($personil['role'], ['admin', 'dosen'], true);
    }

    // ============================================
    // EXISTING METHODS (tetap ada)
    // ============================================

    /**
     * Ambil semua personil
     */
    public function getAllPersonils(): array
    {
        return $this->all();
    }

    /**
     * Ambil personil berdasarkan id
     */
    public function getPersonilById(int $id): ?array
    {
        return $this->find($id) ?: null;
    }

    /**
     * Statistik personil (total blogs, projects)
     */
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

    /**
     * Ambil personil beserta project terkait
     */
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

        // Parse JSON field 'skills' ke array jika masih string
        if (!empty($personil['skills']) && is_string($personil['skills'])) {
            $decoded = json_decode($personil['skills'], true);
            $personil['skills'] = is_array($decoded) ? $decoded : [];
        } elseif (empty($personil['skills'])) {
            $personil['skills'] = [];
        }

        return $personil;
    }

    /**
     * Update personil
     * 
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updatePersonil(int $id, array $data): bool
    {
        $data = $this->filterFillable($data);

        // Hash password jika ada dalam data
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            // Jangan update password jika tidak ada
            unset($data['password']);
        }

        // Pastikan skills tersimpan sebagai JSON string jika diberikan array
        if (isset($data['skills']) && is_array($data['skills'])) {
            $data['skills'] = json_encode($data['skills']);
        }

        return $this->update($id, $data);
    }

    /**
     * Buat personil baru
     * 
     * @param array $data
     * @return int|false ID personil baru atau false
     */
    public function createPersonil(array $data)
    {
        $data = $this->filterFillable($data);

        // Hash password jika ada
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        // Pastikan skills tersimpan sebagai JSON string
        if (isset($data['skills']) && is_array($data['skills'])) {
            $data['skills'] = json_encode($data['skills']);
        }

        // Set default role jika tidak ada
        if (!isset($data['role'])) {
            $data['role'] = 'talent';
        }

        return $this->create($data);
    }

    /**
     * Ambil personils untuk admin dengan filter & pagination
     */
    public function getPersonilsForAdmin(array $filters = [], int $limit = 10, int $offset = 0): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE 1=1";

        [$sql, $params] = $this->applyFiltersToSql($sql, $filters);

        $sql .= " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
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
     * Hitung personil untuk admin sesuai filter
     */
    public function countPersonilsForAdmin(array $filters = []): int
    {
        $sql = "SELECT COUNT(*) AS total FROM {$this->table} WHERE 1=1";
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
     * Hapus personil
     */
    public function deletePersonil(int $id): bool
    {
        return $this->delete($id);
    }

    /**
     * Get personils with filters (for pagination)
     */
    public function getPersonilsWithFilters(array $filters = [], int $limit = 12, int $offset = 0): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE 1=1";
        [$sql, $params] = $this->applyFiltersToSql($sql, $filters);
        $sql .= " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";

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
     * Count personils by role
     */
    public function countPersonilsByRole(?string $role = null): int
    {
        if ($role === null) {
            return $this->count();
        }
        return $this->count(['role' => $role]);
    }

    /**
     * Search personils by name or specialization
     */
    public function searchPersonils(string $query, ?string $role = null): array
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE (nama_lengkap ILIKE :query OR spesialisasi ILIKE :query)";

        $params = [':query' => '%' . $query . '%'];

        if ($role !== null) {
            $sql .= " AND role = :role";
            $params[':role'] = $role;
        }

        $sql .= " ORDER BY nama_lengkap ASC";

        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Helper untuk menambahkan kondisi filter ke SQL.
     * Mengembalikan tuple [$sql, $params]
     */
    protected function applyFiltersToSql(string $sql, array $filters): array
    {
        $params = [];

        if (!empty($filters['search'])) {
            $sql .= " AND (nama_lengkap ILIKE :search OR nim_nip ILIKE :search)";
            $params[':search'] = '%' . $filters['search'] . '%';
        }

        if (!empty($filters['role'])) {
            $sql .= " AND role = :role";
            $params[':role'] = $filters['role'];
        }

        return [$sql, $params];
    }
}
