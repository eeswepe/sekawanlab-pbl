<?php

namespace App;

use PDO;

abstract class BaseModel
{
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    // Find by ID
    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Get all records
    public function all()
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Get with conditions
    public function where($conditions = [], $orderBy = null, $limit = null)
    {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];
        
        if (!empty($conditions)) {
            $sql .= " WHERE ";
            $whereClauses = [];
            foreach ($conditions as $key => $value) {
                $whereClauses[] = "$key = ?";
                $params[] = $value;
            }
            $sql .= implode(" AND ", $whereClauses);
        }
        
        if ($orderBy) {
            $sql .= " ORDER BY $orderBy";
        }
        
        if ($limit) {
            $sql .= " LIMIT $limit";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Create new record
    public function create($data)
    {
        $data = $this->filterFillable($data);
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_values($data));
        
        return $this->db->lastInsertId();
    }
    
    // Update record
    public function update($id, $data)
    {
        $data = $this->filterFillable($data);
        $setClauses = [];
        $params = [];
        
        foreach ($data as $key => $value) {
            $setClauses[] = "$key = ?";
            $params[] = $value;
        }
        $params[] = $id;
        
        $sql = "UPDATE {$this->table} SET " . implode(", ", $setClauses) . " WHERE {$this->primaryKey} = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
    
    // Delete record
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?");
        return $stmt->execute([$id]);
    }
    
    // Count records
    public function count($conditions = [])
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $params = [];
        
        if (!empty($conditions)) {
            $sql .= " WHERE ";
            $whereClauses = [];
            foreach ($conditions as $key => $value) {
                $whereClauses[] = "$key = ?";
                $params[] = $value;
            }
            $sql .= implode(" AND ", $whereClauses);
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    
    // Pagination
    public function paginate($page = 1, $perPage = 10, $conditions = [])
    {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT * FROM {$this->table}";
        $params = [];
        
        if (!empty($conditions)) {
            $sql .= " WHERE ";
            $whereClauses = [];
            foreach ($conditions as $key => $value) {
                $whereClauses[] = "$key = ?";
                $params[] = $value;
            }
            $sql .= implode(" AND ", $whereClauses);
        }
        
        $sql .= " LIMIT ? OFFSET ?";
        $params[] = $perPage;
        $params[] = $offset;
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        return [
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total' => $this->count($conditions),
            'page' => $page,
            'perPage' => $perPage
        ];
    }
    
    // First record
    public function first($conditions = [])
    {
        $results = $this->where($conditions, null, 1);
        return !empty($results) ? $results[0] : null;
    }
    
    // Check if exists
    public function exists($conditions)
    {
        return $this->count($conditions) > 0;
    }
    
    // Filter fillable fields
    protected function filterFillable($data)
    {
        if (empty($this->fillable)) {
            return $data;
        }
        
        return array_intersect_key($data, array_flip($this->fillable));
    }
    
    // Begin transaction
    public function beginTransaction()
    {
        return $this->db->beginTransaction();
    }
    
    // Commit transaction
    public function commit()
    {
        return $this->db->commit();
    }
    
    // Rollback transaction
    public function rollback()
    {
        return $this->db->rollBack();
    }
}