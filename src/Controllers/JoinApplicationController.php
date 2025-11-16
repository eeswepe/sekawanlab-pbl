<?php

namespace App\Controllers;

use App\Controller;
use App\Models\JoinApplicationModel;

class JoinApplicationController extends Controller
{
    private JoinApplicationModel $model;
    private $uploadDir;

    public function __construct()
    {
        $this->model = new JoinApplicationModel();
        $this->uploadDir = "upload/cv";
    }

    public function index()
    {
        $this->render("landing/join/application", []);
    }

    public function submitApplication()
    {
        header("Content-Type: application/json");

        try {
            $requiredFields = [
                "nama_lengkap",
                "email",
                "phone",
                "nim",
                "prodi",
                "semester",
                "alasan_bergabung",
                "github_url",
            ];
            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    echo json_encode([
                        "success" => false,
                        "message" => "Field {$field} wajib diisi",
                    ]);
                    return;
                }
            }

            // Validate email format
            if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                echo json_encode([
                    "success" => false,
                    "message" => "Format email tidak valid",
                ]);
                return;
            }

            // Validate GitHub URL
            if (!filter_var($_POST["github_url"], FILTER_VALIDATE_URL)) {
                echo json_encode([
                    "success" => false,
                    "message" => "Format URL GitHub tidak valid",
                ]);
                return;
            }

            // Handle file upload
            $cvFilePath = null;
            if (
                isset($_FILES["cv"]) &&
                $_FILES["cv"]["error"] === UPLOAD_ERR_OK
            ) {
                $cvFilePath = $this->handleFileUpload($_FILES["cv"]);

                if ($cvFilePath === false) {
                    echo json_encode([
                        "success" => false,
                        "message" => "Gagal mengupload file CV",
                    ]);
                    return;
                }
            }

            // Prepare data for database
            $data = [
                "nama_lengkap" => htmlspecialchars(
                    trim($_POST["nama_lengkap"]),
                ),
                "email" => htmlspecialchars(trim($_POST["email"])),
                "phone" => htmlspecialchars(trim($_POST["phone"])),
                "nim" => htmlspecialchars(trim($_POST["nim"])),
                "prodi" => htmlspecialchars(trim($_POST["prodi"])),
                "semester" => (int) $_POST["semester"],
                "alasan_bergabung" => htmlspecialchars(
                    trim($_POST["alasan_bergabung"]),
                ),
                "github_url" => htmlspecialchars(trim($_POST["github_url"])),
                "cv_file_path" => $cvFilePath,
            ];

            // Save to database
            $saved = $this->model->sendApplication($data);

            if ($saved) {
                echo json_encode([
                    "success" => true,
                    "message" =>
                        "Pendaftaran berhasil dikirim! Tim kami akan menghubungi Anda dalam 3-5 hari kerja.",
                ]);
            } else {
                // Delete uploaded file if database save fails
                if (
                    $cvFilePath &&
                    file_exists($this->uploadDir . basename($cvFilePath))
                ) {
                    unlink($this->uploadDir . basename($cvFilePath));
                }

                echo json_encode([
                    "success" => false,
                    "message" => "Gagal menyimpan data pendaftaran",
                ]);
            }
        } catch (\Exception $e) {
            error_log("Join Application Error: " . $e->getMessage());
            echo json_encode([
                "success" => false,
                "message" =>
                    "Terjadi kesalahan pada server. Silakan coba lagi.",
            ]);
        }
    }

    private function handleFileUpload(array $file): string|false
    {
        // Validate file type
        $allowedTypes = ["application/pdf"];
        $allowedExtensions = ["pdf"];

        $fileExtension = strtolower(
            pathinfo($file["name"], PATHINFO_EXTENSION),
        );

        if (
            !in_array($file["type"], $allowedTypes) &&
            !in_array($fileExtension, $allowedExtensions)
        ) {
            return false;
        }

        // Validate file size (5MB max)
        $maxSize = 5 * 1024 * 1024;
        if ($file["size"] > $maxSize) {
            return false;
        }

        // Generate unique filename
        $uniqueName = uniqid("cv_", true) . "." . $fileExtension;
        $destination = $this->uploadDir . $uniqueName;

        // Move uploaded file
        if (move_uploaded_file($file["tmp_name"], $destination)) {
            return "/upload/cv/" . $uniqueName;
        }

        return false;
    }
}
