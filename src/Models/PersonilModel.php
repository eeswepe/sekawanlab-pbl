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
                    bio = :bio,
                    email = :email,
                    phone = :phone,
                    skillks = :skillks,
                    foto_url = :foto_url,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':bio', $data['bio'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(':phone', $data['phone'], PDO::PARAM_STR);
        $stmt->bindParam(':skillks', $data['skillks'], PDO::PARAM_STR);
        $stmt->bindParam(':foto_url', $data['foto_url'], PDO::PARAM_STR);
        
        return $stmt->execute();
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
}
?>
