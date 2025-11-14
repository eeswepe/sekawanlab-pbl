<?php
namespace App\Models;

use App\Database;
use PDO;

class JoinApplicationModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAllApplications()
    {
        $query = "SELECT * FROM join_application";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sendApplication(array $data): bool
    {
        $query = "INSERT INTO join_application
            (nama_lengkap, email, phone, nim, prodi, semester, alasan_bergabung, github_url, cv_file_path)
            VALUES (:nama_lengkap, :email, :phone, :nim, :prodi, :semester, :alasan_bergabung, :github_url, :cv_file_path)";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            ":nama_lengkap" => $data["nama_lengkap"],
            ":email" => $data["email"],
            ":phone" => $data["phone"],
            ":nim" => $data["nim"],
            ":prodi" => $data["prodi"],
            ":semester" => $data["semester"],
            ":alasan_bergabung" => $data["alasan_bergabung"],
            ":github_url" => $data["github_url"] ?? null,
            ":cv_file_path" => $data["cv_file_path"] ?? null,
        ]);
    }

    /**
     * Get applications for admin with filters and pagination
     * @param array $filters ['search', 'status', 'prodi']
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getApplicationsForAdmin($filters = [], $limit = 10, $offset = 0)
    {
        $sql = "SELECT * FROM join_application WHERE 1=1";
        
        $params = [];
        
        // Search filter by name
        if (!empty($filters['search'])) {
            $sql .= " AND nama_lengkap ILIKE :search";
            $params[':search'] = '%' . $filters['search'] . '%';
        }
        
        // Status filter
        if (!empty($filters['status'])) {
            $sql .= " AND status = :status";
            $params[':status'] = $filters['status'];
        }
        
        // Prodi filter
        if (!empty($filters['prodi'])) {
            $sql .= " AND prodi = :prodi";
            $params[':prodi'] = $filters['prodi'];
        }
        
        $sql .= " ORDER BY tanggal_apply DESC LIMIT :limit OFFSET :offset";
        
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
     * Count applications with filters
     * @param array $filters
     * @return int
     */
    public function countApplicationsForAdmin($filters = [])
    {
        $sql = "SELECT COUNT(*) as total FROM join_application WHERE 1=1";
        
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
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return (int)$result['total'];
    }

    /**
     * Get application statistics
     * @return array
     */
    public function getApplicationStats()
    {
        $sql = "SELECT 
                    COUNT(*) as total,
                    COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending,
                    COUNT(CASE WHEN status = 'accepted' THEN 1 END) as accepted,
                    COUNT(CASE WHEN status = 'rejected' THEN 1 END) as rejected,
                    COUNT(CASE WHEN status = 'reviewed' THEN 1 END) as reviewed
                FROM join_application";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get application by ID
     * @param int $id
     * @return array|null
     */
    public function getApplicationById($id)
    {
        $sql = "SELECT * FROM join_application WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Delete application by ID
     * @param int $id
     * @return bool
     */
    public function deleteApplication($id)
    {
        $sql = "DELETE FROM join_application WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}
