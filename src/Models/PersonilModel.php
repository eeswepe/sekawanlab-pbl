<?php
namespace App\Models;

use App\Database;
use \PDO;

class PersonilModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAllPersonils()
    {
        $stmt = $this->db->prepare("SELECT * FROM personil");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get personil data by user_id
     * @param int $userId
     * @return array|false
     */
    public function getPersonilByUserId($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM personil WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get personil data by id
     * @param int $id
     * @return array|false
     */
    public function getPersonilById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM personil WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get personil statistics (total blogs, projects)
     * @param int $personil_id
     * @return array
     */
    public function getPersonilStats($personil_id)
    {
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM blog_post WHERE penulis_id = :personil_id) as total_blogs,
                    (SELECT COUNT(*) FROM project WHERE personil_id = :personil_id) as total_projects";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':personil_id', $personil_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return [
            'total_blogs' => (int) $result['total_blogs'],
            'total_projects' => (int) $result['total_projects']
        ];
    }

    /**
     * Get personil with all related data (projects)
     * @param int $personil_id
     * @return array|false
     */
    public function getPersonilWithProjects($personil_id)
    {
        // Get personil data
        $personil = $this->getPersonilById($personil_id);
        
        if (!$personil) {
            return false;
        }
        
        // Get projects
        $sql = "SELECT * FROM project WHERE personil_id = :personil_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':personil_id', $personil_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $personil['projects'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Parse JSON fields
        if (isset($personil['skillks'])) {
            $personil['skills'] = json_decode($personil['skillks'], true) ?? [];
        } else {
            $personil['skills'] = [];
        }
        
        return $personil;
    }

    public function updatePersonil($id, $data)
    {
        $sql = "UPDATE personil SET 
                    nama_lengkap = :nama_lengkap,
                    role = :role,
                    spesialisasi = :spesialisasi,
                    email = :email,
                    phone = :phone,
                    location = :location,
                    tanggal_bergabung = :tanggal_bergabung,
                    bio = :bio,
                    skillks = :skillks,
                    foto_url = :foto_url,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nama_lengkap', $data['nama_lengkap'], PDO::PARAM_STR);
        $stmt->bindParam(':role', $data['role'], PDO::PARAM_STR);
        $stmt->bindParam(':spesialisasi', $data['spesialisasi'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(':phone', $data['phone'], PDO::PARAM_STR);
        $stmt->bindParam(':location', $data['location'], PDO::PARAM_STR);
        $stmt->bindParam(':tanggal_bergabung', $data['tanggal_bergabung'], PDO::PARAM_STR);
        $stmt->bindParam(':bio', $data['bio'], PDO::PARAM_STR);
        $stmt->bindParam(':skillks', $data['skillks'], PDO::PARAM_STR);
        $stmt->bindParam(':foto_url', $data['foto_url'], PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    public function getPersonilWithUser($id)
    {
        $sql = "SELECT p.*, u.username, u.role as user_role 
                FROM personil p 
                LEFT JOIN users u ON p.user_id = u.id 
                WHERE p.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create new personil
     * @param array $data
     * @return int|false - personil ID if success
     */
    public function createPersonil($data)
    {
        $sql = "INSERT INTO personil (
                    user_id, nama_lengkap, role, spesialisasi, 
                    email, phone, location, tanggal_bergabung, 
                    bio, skillks, foto_url
                ) VALUES (
                    :user_id, :nama_lengkap, :role, :spesialisasi,
                    :email, :phone, :location, :tanggal_bergabung,
                    :bio, :skillks, :foto_url
                ) RETURNING id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':nama_lengkap', $data['nama_lengkap'], PDO::PARAM_STR);
        $stmt->bindParam(':role', $data['role'], PDO::PARAM_STR);
        $stmt->bindParam(':spesialisasi', $data['spesialisasi'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(':phone', $data['phone'], PDO::PARAM_STR);
        $stmt->bindParam(':location', $data['location'], PDO::PARAM_STR);
        $stmt->bindParam(':tanggal_bergabung', $data['tanggal_bergabung']);
        $stmt->bindParam(':bio', $data['bio'], PDO::PARAM_STR);
        $stmt->bindParam(':skillks', $data['skillks'], PDO::PARAM_STR);
        $stmt->bindParam(':foto_url', $data['foto_url'], PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['id'];
        }
        
        return false;
    }

    /**
     * Get personils for admin with filters and pagination
     * @param array $filters ['search', 'role']
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getPersonilsForAdmin($filters = [], $limit = 10, $offset = 0)
    {
        $sql = "SELECT 
                    p.*,
                    u.username
                FROM personil p
                LEFT JOIN users u ON p.user_id = u.id
                WHERE 1=1";
        
        $params = [];
        
        // Search filter by name
        if (!empty($filters['search'])) {
            $sql .= " AND p.nama_lengkap ILIKE :search";
            $params[':search'] = '%' . $filters['search'] . '%';
        }
        
        // Role filter
        if (!empty($filters['role'])) {
            $sql .= " AND p.role = :role";
            $params[':role'] = $filters['role'];
        }
        
        $sql .= " ORDER BY p.created_at DESC LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Count personils with filters
     * @param array $filters
     * @return int
     */
    public function countPersonilsForAdmin($filters = [])
    {
        $sql = "SELECT COUNT(*) as total FROM personil p WHERE 1=1";
        
        $params = [];
        
        if (!empty($filters['search'])) {
            $sql .= " AND p.nama_lengkap ILIKE :search";
            $params[':search'] = '%' . $filters['search'] . '%';
        }
        
        if (!empty($filters['role'])) {
            $sql .= " AND p.role = :role";
            $params[':role'] = $filters['role'];
        }
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return (int)$result['total'];
    }

    /**
     * Get count by role
     * @param string $role
     * @return int
     */
    public function countByRole($role = null)
    {
        if ($role) {
            $sql = "SELECT COUNT(*) as total FROM personil WHERE role = :role";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        } else {
            $sql = "SELECT COUNT(*) as total FROM personil";
            $stmt = $this->db->prepare($sql);
        }
        
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['total'];
    }

    /**
     * Delete personil by ID
     * @param int $id
     * @return bool
     */
    public function deletePersonil($id)
    {
        $sql = "DELETE FROM personil WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}
?>
