<?php

namespace App\Models;

use App\Database;
use \PDO;

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Get all users
     * @return array
     */
    public function getAllUsers()
    {
        $sql = "SELECT id, username, role, created_at FROM users ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get user by ID
     * @param int $id
     * @return array|false
     */
    public function getUserById($id)
    {
        $sql = "SELECT id, username, role, created_at FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get user by username
     * @param string $username
     * @return array|false
     */
    public function getUserByUsername($username)
    {
        $sql = "SELECT id, username, password, role, created_at FROM users WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create new user
     * @param array $data ['username', 'password', 'role' (optional)]
     * @return int|false User ID if success, false if failed
     */
    public function createUser($data)
    {
        $username = $data["username"];
        $password = $data["password"];
        $role = $data["role"] ?? 'personil';
    
        // Validate role
        if (!in_array($role, ['admin', 'personil'])) {
            $role = 'personil';
        }

        // Hash password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password, role) VALUES (:username, :password, :role)";
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->bindParam(":password", $passwordHash, PDO::PARAM_STR);
        $stmt->bindParam(":role", $role, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return (int) $this->db->lastInsertId();
        }
        
        return false;
    }

    /**
     * Update user data
     * @param int $id
     * @param array $data ['username', 'password', 'role']
     * @return bool
     */
    public function updateUser($id, $data)
    {
        $fields = [];
        $params = ["id" => $id];

        if (isset($data["username"]) && !empty($data["username"])) {
            $fields[] = "username = :username";
            $params["username"] = $data["username"];
        }

        if (isset($data["password"]) && !empty($data["password"])) {
            $fields[] = "password = :password";
            $params["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
        }

        if (isset($data["role"]) && in_array($data["role"], ['admin', 'personil'])) {
            $fields[] = "role = :role";
            $params["role"] = $data["role"];
        }

        if (empty($fields)) {
            return false;
        }

        $sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute($params);
    }

    /**
     * Delete user
     * @param int $id
     * @return bool
     */
    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    /**
     * Check if username exists
     * @param string $username
     * @param int|null $excludeId User ID to exclude from check (for update)
     * @return bool
     */
    public function usernameExists($username, $excludeId = null)
    {
        if ($excludeId) {
            $sql = "SELECT COUNT(*) FROM users WHERE username = :username AND id != :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->bindParam(":id", $excludeId, PDO::PARAM_INT);
        } else {
            $sql = "SELECT COUNT(*) FROM users WHERE username = :username";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        }
        
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Validate user credentials
     * @param string $username
     * @param string $password
     * @return array|false User data if valid, false if invalid
     */
    public function validateCredentials($username, $password)
    {
        $user = $this->getUserByUsername($username);
        
        if (!$user) {
            return false;
        }

        // Verify password
        if (password_verify($password, $user["password"])) {
            // Return only safe data (without password)
            return [
                "id" => (int) $user["id"],
                "username" => $user["username"],
                "role" => $user["role"],
                "created_at" => $user["created_at"]
            ];
        }

        return false;
    }

    /**
     * Get users count by role
     * @param string|null $role
     * @return int
     */
    public function getUsersCount($role = null)
    {
        if ($role && in_array($role, ['admin', 'personil'])) {
            $sql = "SELECT COUNT(*) FROM users WHERE role = :role";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":role", $role, PDO::PARAM_STR);
        } else {
            $sql = "SELECT COUNT(*) FROM users";
            $stmt = $this->db->prepare($sql);
        }
        
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    /**
     * Change user password
     * @param int $id
     * @param string $newPassword
     * @return bool
     */
    public function changePassword($id, $newPassword)
    {
        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":password", $passwordHash, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    /**
     * Get users by role
     * @param string $role
     * @return array
     */
    public function getUsersByRole($role)
    {
        if (!in_array($role, ['admin', 'personil'])) {
            return [];
        }

        $sql = "SELECT id, username, role, created_at FROM users WHERE role = :role ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":role", $role, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
