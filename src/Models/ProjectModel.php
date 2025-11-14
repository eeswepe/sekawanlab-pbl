<?php

namespace App\Models;

use App\Database;
use PDO;

class ProjectModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getProjectsByPersonilId($personil_id)
    {
        $sql = "SELECT * FROM project WHERE personil_id = :personil_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':personil_id', $personil_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createProject($data)
    {
        $sql = "INSERT INTO project (personil_id, title, description) 
                VALUES (:personil_id, :title, :description) RETURNING id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':personil_id', $data['personil_id'], PDO::PARAM_INT);
        $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
        $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['id'];
        }
        return false;
    }

    public function updateProject($id, $data)
    {
        $sql = "UPDATE project SET 
                    title = :title,
                    description = :description,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
        $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    public function deleteProject($id)
    {
        $sql = "DELETE FROM project WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
