<?php
declare(strict_types=1);

namespace App\Models;

use App\BaseModel;
use App\Database;
use PDO;

class KategoriModel extends BaseModel
{
    protected string $table = 'kategori';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'name',
        'post_count'
    ];

    public function __construct(?PDO $db = null)
    {
        $db = $db ?? Database::getConnection();
        parent::__construct($db);
    }

    // Ambil semua kategori
    public function getAllKategori(): array
    {
        return $this->all();
    }

    // Ambil kategori berdasarkan ID
    public function getKategoriById(int $id): ?array
    {
        return $this->find($id) ?: null;
    }

    // Ambil kategori berdasarkan nama
    public function getKategoriByName(string $name): ?array
    {
        $rows = $this->where(['name' => $name], null, 1);
        return $rows[0] ?? null;
    }

    // Buat kategori baru, kembalikan id atau false
    public function createKategori(string $name)
    {
        $data = [
            'name'      => $name,
            'post_count'=> 0
        ];

        $data = $this->filterFillable($data);
        $insertId = $this->create($data);

        return $insertId === '' || $insertId === false ? false : (int)$insertId;
    }

    // Tambah post_count
    public function incrementPostCount(int $id): bool
    {
        $sql = "UPDATE {$this->table} SET post_count = post_count + 1 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Kurangi post_count (maksimal 0)
    public function decrementPostCount(int $id): bool
    {
        $sql = "UPDATE {$this->table} 
                SET post_count = GREATEST(post_count - 1, 0) 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
