<?php

namespace App\Models;

use App\Database;
use PDO;

class PersonilInvitationModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function createInvitation($personil_id, $application_id)
    {
        $secret_key = bin2hex(random_bytes(32)); // 64 char hex string
        
        $sql = "INSERT INTO personil_invitation (secret_key, personil_id, application_id) 
                VALUES (:secret_key, :personil_id, :application_id) RETURNING secret_key";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':secret_key', $secret_key, PDO::PARAM_STR);
        $stmt->bindParam(':personil_id', $personil_id, PDO::PARAM_INT);
        $stmt->bindParam(':application_id', $application_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['secret_key'];
        }
        
        return false;
    }

    public function getInvitationBySecretKey($secret_key)
    {
        $sql = "SELECT pi.*, p.nama_lengkap, p.email 
                FROM personil_invitation pi
                JOIN personil p ON pi.personil_id = p.id
                WHERE pi.secret_key = :secret_key";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':secret_key', $secret_key, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function markAsUsed($secret_key)
    {
        $sql = "UPDATE personil_invitation SET is_used = TRUE WHERE secret_key = :secret_key";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':secret_key', $secret_key, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function isValidInvitation($secret_key)
    {
        $invitation = $this->getInvitationBySecretKey($secret_key);
        return $invitation && !$invitation['is_used'];
    }
}
