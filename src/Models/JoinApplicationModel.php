<?php
declare(strict_types=1);

namespace App\Models;

use App\BaseModel;
use App\Database;
use PDO;

class JoinApplicationModel extends BaseModel
{
    protected string $table = 'join_application';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'nama_lengkap',
        'email',
        'phone',
        'nim',
        'prodi',
        'semester',
        'alasan_bergabung',
        'github_url',
        'cv_file_path',
        'status',
        'catatan_admin',
        'tanggal_apply'
    ];

    public function __construct(?PDO $db = null)
    {
        $db = $db ?? Database::getConnection();
        parent::__construct($db);
    }

    // Ambil semua aplikasi
    public function getAllApplications(): array
    {
        return $this->all();
    }

    // Simpan aplikasi baru
    public function sendApplication(array $data): bool
    {
        $data = $this->filterFillable($data);

        // Pastikan field opsional ada
        $data['github_url'] = $data['github_url'] ?? null;
        $data['cv_file_path'] = $data['cv_file_path'] ?? null;

        $result = $this->create($data);
        return $result !== false && (int)$result > 0;
    }

    // Ambil aplikasi untuk admin dengan filter dan pagination
    public function getApplicationsForAdmin(array $filters = [], int $limit = 10, int $offset = 0): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE 1=1";
        [$sql, $params] = $this->applyFiltersToSql($sql, $filters);

        $sql .= " ORDER BY tanggal_apply DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hitung jumlah aplikasi untuk admin sesuai filter
    public function countApplicationsForAdmin(array $filters = []): int
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE 1=1";
        [$sql, $params] = $this->applyFiltersToSql($sql, $filters);

        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();

        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($res['total'] ?? 0);
    }

    // Statistik ringkas aplikasi
    public function getApplicationStats(): array
    {
        $sql = "SELECT 
                    COUNT(*) as total,
                    COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending,
                    COUNT(CASE WHEN status = 'accepted' THEN 1 END) as accepted,
                    COUNT(CASE WHEN status = 'rejected' THEN 1 END) as rejected,
                    COUNT(CASE WHEN status = 'reviewed' THEN 1 END) as reviewed
                FROM {$this->table}";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [
            'total' => 0, 'pending' => 0, 'accepted' => 0, 'rejected' => 0, 'reviewed' => 0
        ];
    }

    // Ambil aplikasi berdasarkan ID
    public function getApplicationById(int $id): ?array
    {
        return $this->find($id) ?: null;
    }

    // Hapus aplikasi
    public function deleteApplication(int $id): bool
    {
        return $this->delete($id);
    }

    // Update status aplikasi
    public function updateApplicationStatus(int $id, string $status): bool
    {
        return $this->update($id, ['status' => $status]);
    }

    // Update catatan admin
    public function updateAdminNotes(int $id, string $notes): bool
    {
        return $this->update($id, ['catatan_admin' => $notes]);
    }

    /**
     * Helper untuk menambahkan kondisi filter ke SQL.
     * Mengembalikan array [$sql, $params]
     */
    protected function applyFiltersToSql(string $sql, array $filters): array
    {
        $params = [];

        if (!empty($filters['search'])) {
            $sql .= " AND nama_lengkap ILIKE :search";
            $params[':search'] = '%' . $filters['search'] . '%';
        }

        if (!empty($filters['status'])) {
            $sql .= " AND status = :status";
            $params[':status'] = $filters['status'];
        }

        if (!empty($filters['prodi'])) {
            $sql .= " AND prodi = :prodi";
            $params[':prodi'] = $filters['prodi'];
        }

        return [$sql, $params];
    }
}
