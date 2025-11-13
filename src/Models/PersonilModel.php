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

    public function getPersonilById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM personil WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPersonilByUserId($user_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM personil WHERE user_id = :user_id");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
?>
