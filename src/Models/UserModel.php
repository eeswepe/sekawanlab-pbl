<?php
declare(strict_types=1);

namespace App\Models;

use App\BaseModel;
use App\Database;
use PDO;

class UserModel extends BaseModel
{
    protected string $table = 'users';
    protected string $primaryKey = 'id';
    protected array $fillable = [
        'username',
        'password',
        'role',
        'created_at'
    ];

    public function __construct(?PDO $db = null)
    {
        $db = $db ?? Database::getConnection();
        parent::__construct($db);
    }

    // Ambil semua users (safe fields)
    public function getAllUsers(): array
    {
        $sql = "SELECT id, username, role, created_at FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ambil user berdasarkan id (safe fields)
    public function getUserById(int $id): ?array
    {
        $rows = $this->where(['id' => $id], null, 1);
        return $rows[0] ?? null;
    }

    // Ambil user lengkap berdasarkan username (termasuk password untuk auth)
    public function getUserByUsername(string $username): ?array
    {
        $sql = "SELECT id, username, password, role, created_at FROM {$this->table} WHERE username = :username LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: null;
    }

    // Buat user baru (hash password), kembalikan id atau false
    public function createUser(array $data)
    {
        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;
        $role = $data['role'] ?? 'personil';

        if ($username === null || $password === null) {
            return false;
        }

        // Normalisasi role
        if (!in_array($role, ['admin', 'personil'], true)) {
            $role = 'personil';
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $payload = [
            'username' => $username,
            'password' => $passwordHash,
            'role'     => $role
        ];

        $payload = $this->filterFillable($payload);
        $insertId = $this->create($payload);

        return ($insertId === false || $insertId === '') ? false : (int)$insertId;
    }

    // Update user (bisa update username/password/role)
    public function updateUser(int $id, array $data): bool
    {
        $update = [];

        if (isset($data['username']) && $data['username'] !== '') {
            $update['username'] = $data['username'];
        }

        if (isset($data['password']) && $data['password'] !== '') {
            $update['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        if (isset($data['role']) && in_array($data['role'], ['admin', 'personil'], true)) {
            $update['role'] = $data['role'];
        }

        if (empty($update)) {
            return false;
        }

        $update = $this->filterFillable($update);
        return $this->update($id, $update);
    }

    // Hapus user
    public function deleteUser(int $id): bool
    {
        return $this->delete($id);
    }

    // Cek apakah username sudah ada; optionally exclude an id (for updates)
    public function usernameExists(string $username, ?int $excludeId = null): bool
    {
        if ($excludeId !== null) {
            $sql = "SELECT COUNT(*) FROM {$this->table} WHERE username = :username AND id != :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->bindValue(':id', $excludeId, PDO::PARAM_INT);
        } else {
            $sql = "SELECT COUNT(*) FROM {$this->table} WHERE username = :username";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        }

        $stmt->execute();
        return (int)$stmt->fetchColumn() > 0;
    }

    // Validasi kredensial user
    public function validateCredentials(string $username, string $password)
    {
        $user = $this->getUserByUsername($username);
        if ($user === null) {
            return false;
        }

        if (!isset($user['password'])) {
            return false;
        }

        if (password_verify($password, $user['password'])) {
            return [
                'id' => (int)$user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'created_at' => $user['created_at']
            ];
        }

        return false;
    }

    // Dapatkan jumlah users (opsional filter role)
    public function getUsersCount(?string $role = null): int
    {
        if ($role !== null && in_array($role, ['admin', 'personil'], true)) {
            return $this->count(['role' => $role]);
        }
        return (int)$this->count();
    }

    // Ganti password user
    public function changePassword(int $id, string $newPassword): bool
    {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->update($id, ['password' => $hash]);
    }

    // Ambil users berdasarkan role
    public function getUsersByRole(string $role): array
    {
        if (!in_array($role, ['admin', 'personil'], true)) {
            return [];
        }

        $sql = "SELECT id, username, role, created_at FROM {$this->table} WHERE role = :role ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':role', $role, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
