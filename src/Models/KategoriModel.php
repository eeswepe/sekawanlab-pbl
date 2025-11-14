<?php

namespace App\Models;

use App\Database;
use PDO;

class KategoriModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Get all categories
     * @return array
     */
    public function getAllKategori()
    {
        $sql = "SELECT * FROM kategori ORDER BY name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get category by ID
     * @param int $id
     * @return array|null
     */
    public function getKategoriById($id)
    {
        $sql = "SELECT * FROM kategori WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get category by name
     * @param string $name
     * @return array|null
     */
    public function getKategoriByName($name)
    {
        $sql = "SELECT * FROM kategori WHERE name = :name";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create new category
     * @param string $name
     * @return int|bool - ID of created category or false
     */
    public function createKategori($name)
    {
        $sql = "INSERT INTO kategori (name, post_count) VALUES (:name, 0) RETURNING id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['id'];
        }
        
        return false;
    }

    /**
     * Increment post count for a category
     * @param int $id
     * @return bool
     */
    public function incrementPostCount($id)
    {
        $sql = "UPDATE kategori SET post_count = post_count + 1 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    /**
     * Decrement post count for a category
     * @param int $id
     * @return bool
     */
    public function decrementPostCount($id)
    {
        $sql = "UPDATE kategori SET post_count = post_count - 1 WHERE id = :id AND post_count > 0";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}
