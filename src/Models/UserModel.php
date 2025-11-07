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

    // Get All User
    public function getAllUser()
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get User By ID
    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get User By Username
    public function getUserByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create User
    public function create($data)
    {
        $sql =
            "INSERT INTO users (username, password_hash, role, created_at) VALUES (:username, :password_hash, :role, NOW())";
        $stmt = $this->db->prepare($sql);

        $password_hash = password_hash($data["password"], PASSWORD_DEFAULT);

        $stmt->bindParam(":username", $data["username"]);
        $stmt->bindParam(":password_hash", $password_hash);
        $stmt->bindParam(":role", $data["role"]);

        return $stmt->execute();
    }

    // Update User Data
    public function update($id, $data)
    {
        $fields = [];
        $params = ["id" => $id];

        if (isset($data["username"])) {
            $fields[] = "username = :username";
            $params["username"] = $data["username"];
        }

        if (isset($data["password"])) {
            $fields[] = "password_hash = :password_hash";
            $params["password_hash"] = password_hash(
                $data["password"],
                PASSWORD_DEFAULT,
            );
        }

        if (isset($data["role"])) {
            $fields[] = "role = :role";
            $params["role"] = $data["role"];
        }

        if (empty($fields)) {
            return false;
        }

        $sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount() > 0;
    }

    // Delete User
    public function delete($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["id" => $id]);
        return $stmt->rowCount() > 0;
    }

    // Verify User
    public function verify($username, $password)
    {
        $user = $this->getUserByUsername($username);
        if ($user && password_verify($password, $user["password_hash"])) {
            return $user;
        }
        return false;
    }

    // Check Username Exist
    public function usernameExists($username)
    {
        $sql = "SELECT COUNT(*) FROM users WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["username" => $username]);
        return $stmt->fetchColumn() > 0;
    }
}
