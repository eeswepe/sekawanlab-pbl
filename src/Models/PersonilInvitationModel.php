<?php
declare(strict_types=1);

namespace App\Models;

use App\BaseModel;
use App\Database;
use PDO;

class PersonilInvitationModel extends BaseModel
{
    public function __construct(?PDO $db = null)
    {
        $db = $db ?? Database::getConnection();
        parent::__construct($db);
        
        $this->table = 'personil_invitation';
        $this->primaryKey = 'id';
        $this->fillable = [
            'secret_key',
            'personil_id',
            'application_id',
            'is_used',
            'created_at'
        ];
    }

    // Buat invitation dan kembalikan secret_key (Postgres RETURNING)
    public function createInvitation(int $personil_id, int $application_id)
    {
        $secret_key = bin2hex(random_bytes(32)); // 64-char hex

        $sql = "INSERT INTO {$this->table} (secret_key, personil_id, application_id)
                VALUES (:secret_key, :personil_id, :application_id)
                RETURNING secret_key";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':secret_key', $secret_key, PDO::PARAM_STR);
        $stmt->bindValue(':personil_id', $personil_id, PDO::PARAM_INT);
        $stmt->bindValue(':application_id', $application_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['secret_key'] ?? false;
        }

        return false;
    }

    // Ambil invitation berdasarkan secret_key
    public function getInvitationBySecretKey(string $secret_key): ?array
    {
        $sql = "SELECT pi.*, p.nama_lengkap, p.email
                FROM {$this->table} pi
                JOIN personil p ON pi.personil_id = p.id
                WHERE pi.secret_key = :secret_key
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':secret_key', $secret_key, PDO::PARAM_STR);
        $stmt->execute();

        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: null;
    }

    // Ambil invitation berdasarkan application_id
    public function getInvitationByApplicationId(int $application_id): ?array
    {
        $rows = $this->where(['application_id' => $application_id], null, 1);
        return $rows[0] ?? null;
    }

    // Tandai invitation sudah digunakan
    public function markAsUsed(string $secret_key): bool
    {
        $sql = "UPDATE {$this->table} SET is_used = TRUE WHERE secret_key = :secret_key";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':secret_key', $secret_key, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Cek validitas invitation (ada dan belum dipakai)
    public function isValidInvitation(string $secret_key): bool
    {
        $inv = $this->getInvitationBySecretKey($secret_key);
        return is_array($inv) && empty($inv['is_used']);
    }
}
