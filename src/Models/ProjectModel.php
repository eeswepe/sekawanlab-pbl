<?php
declare(strict_types=1);

namespace App\Models;

use App\BaseModel;
use App\Database;
use PDO;

class ProjectModel extends BaseModel
{
    public function __construct(?PDO $db = null)
    {
        $db = $db ?? Database::getConnection();
        parent::__construct($db);
        
        $this->table = 'project';
        $this->primaryKey = 'id';
        $this->fillable = [
            'personil_id',
            'title',
            'description',
            'created_at',
            'updated_at'
        ];
    }

    // Ambil project berdasarkan personil_id
    public function getProjectsByPersonilId(int $personil_id): array
    {
        // gunakan BaseModel::where dengan order
        return $this->where(['personil_id' => $personil_id], 'created_at DESC');
    }

    // Buat project baru, kembalikan id atau false
    public function createProject(array $data)
    {
        $data = $this->filterFillable($data);
        $insertId = $this->create($data);

        // BaseModel::create() bisa mengembalikan string id atau false
        return $insertId === false || $insertId === '' ? false : (int) $insertId;
    }

    // Update project
    public function updateProject(int $id, array $data): bool
    {
        $data = $this->filterFillable($data);
        return $this->update($id, $data);
    }

    // Hapus project by id
    public function deleteProject(int $id): bool
    {
        return $this->delete($id);
    }

    // Hapus semua project milik personil
    public function deleteProjectsByPersonilId(int $personil_id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE personil_id = :personil_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':personil_id', $personil_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
