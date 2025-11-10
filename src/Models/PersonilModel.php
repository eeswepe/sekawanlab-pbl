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
}
?>
