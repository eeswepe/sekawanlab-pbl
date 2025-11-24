<?php

namespace App\Controllers;

use App\Controller;
use App\Models\JoinApplicationModel;
use App\Services\Shared\FileUploadService;
use App\Services\External\AssessorService;

/**
 * JoinApplicationController (REFACTORED)
 * 
 * Controller untuk handle join application
 * Menggunakan FileUploadService untuk upload CV
 */
class JoinApplicationController extends Controller
{
    private JoinApplicationModel $model;
    private FileUploadService $fileUploadService;
    private AssessorService $assessorService;

    public function __construct()
    {
        $this->model = new JoinApplicationModel();
        $this->fileUploadService = new FileUploadService();
        $this->assessorService = new AssessorService();
    }

    /**
     * Render application form
     * 
     * GET /join
     */
    public function index()
    {
        $this->render("landing/join/application", []);
    }

    /**
     * Submit application
     * 
     * POST /join/submit
     */
    public function submitApplication()
    {
        header("Content-Type: application/json");

        try {
            // Validate required fields
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

            // Handle CV upload menggunakan FileUploadService
            $cvFilePath = null;
            if (isset($_FILES["cv"]) && $_FILES["cv"]["error"] === UPLOAD_ERR_OK) {
                $uploadResult = $this->fileUploadService->uploadPDF(
                    $_FILES["cv"],
                    "cv",
                    "cv_"
                );

                if (!$uploadResult['success']) {
                    echo json_encode([
                        "success" => false,
                        "message" => "Upload CV gagal: " . $uploadResult['message'],
                    ]);
                    return;
                }

                $cvFilePath = $uploadResult['path'];

                // 5. Panggil Assessor Service
                $githubUsername = $this->extractGithubUsername($_POST["github_url"]);
                
                $data['assessor_summary'] = null;

                try {
                    $assessorResult = $this->assessorService->analyzeApplication($githubUsername, $cvFilePath);
                    // Simpan hasil analisis ke variabel untuk disimpan ke DB atau ditampilkan
                    $data['assessor_summary'] = $assessorResult;
                    // Log atau tangani hasil analisis sesuai kebutuhan
                    error_log("Assessor Result for {$githubUsername}: " . json_encode($assessorResult));
                } catch (\Exception $assessorE) {
                    // Jika Assessor gagal, log error dan lanjutkan proses pendaftaran
                    error_log("Assessor Service Error: " . $assessorE->getMessage());
                }
            }

            // Prepare data for database
            $data = [
                "nama_lengkap" => htmlspecialchars(trim($_POST["nama_lengkap"])),
                "email" => htmlspecialchars(trim($_POST["email"])),
                "phone" => htmlspecialchars(trim($_POST["phone"])),
                "nim" => htmlspecialchars(trim($_POST["nim"])),
                "prodi" => htmlspecialchars(trim($_POST["prodi"])),
                "semester" => (int) $_POST["semester"],
                "alasan_bergabung" => htmlspecialchars(trim($_POST["alasan_bergabung"])),
                "github_url" => htmlspecialchars(trim($_POST["github_url"])),
                "assessor_summary" => $data['assessor_summary'],
                "cv_file_path" => $cvFilePath,
            ];

            // Save to database
            $saved = $this->model->sendApplication($data);

            if ($saved) {
                echo json_encode([
                    "success" => true,
                    "message" => "Pendaftaran berhasil dikirim! Tim kami akan menghubungi Anda dalam 3-5 hari kerja.",
                ]);
            } else {
                // Rollback: Delete uploaded CV if database save fails
                if ($cvFilePath) {
                    $this->fileUploadService->deleteFile($cvFilePath);
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
                "message" => "Terjadi kesalahan pada server. Silakan coba lagi.",
            ]);
        }
    }

    /**
     * Helper function untuk mengekstrak username dari URL GitHub.
     * 
     * @param string $url URL GitHub.
     * @return string Username GitHub.
     */
    private function extractGithubUsername(string $url): string
    {
        // Hapus protokol (http/https)
        $url = preg_replace('#^https?://#', '', $url);
        // Hapus www.
        $url = preg_replace('#^www\.#', '', $url);
        // Ambil bagian path
        $parts = explode('/', $url);
        // Username adalah bagian pertama setelah domain (misal: github.com/username)
        return $parts[1] ?? '';
    }
}
