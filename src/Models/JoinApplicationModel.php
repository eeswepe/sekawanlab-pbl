<?php
namespace App\Models;

use App\Database;
use PDO;

class JoinApplicationModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAllApplications()
    {
        $query = "SELECT * FROM join_application";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sendApplication(array $data): bool
    {
        $query = "INSERT INTO join_application
            (nama_lengkap, email, phone, nim, prodi, semester, alasan_bergabung, github_url, cv_file_path)
            VALUES (:nama_lengkap, :email, :phone, :nim, :prodi, :semester, :alasan_bergabung, :github_url, :cv_file_path)";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            ":nama_lengkap" => $data["nama_lengkap"],
            ":email" => $data["email"],
            ":phone" => $data["phone"],
            ":nim" => $data["nim"],
            ":prodi" => $data["prodi"],
            ":semester" => $data["semester"],
            ":alasan_bergabung" => $data["alasan_bergabung"],
            ":github_url" => $data["github_url"] ?? null,
            ":cv_file_path" => $data["cv_file_path"] ?? null,
        ]);
    }
}
