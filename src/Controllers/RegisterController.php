<?php

namespace App\Controllers;

use App\Controller;
use App\Models\UserModel;
use App\Helpers\SessionHelper;

class RegisterController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $error = isset($_GET["error"]) ? $_GET["error"] : null;
        $success = isset($_GET["success"]) ? $_GET["success"] : null;

        $data = [
            "error" => $error,
            "success" => $success,
        ];

        $this->render("register", $data);
    }

    public function register()
    {
        $username = isset($_POST["username"]) ? trim($_POST["username"]) : null;
        $password = isset($_POST["password"]) ? $_POST["password"] : null;
        $confirm_password = isset($_POST["confirm_password"]) ? $_POST["confirm_password"] : null;
        $secret_key = isset($_POST["secret_key"]) ? trim($_POST["secret_key"]) : null;

        if (empty($username) || empty($password) || empty($confirm_password)) {
            SessionHelper::setFlash("error", "Semua kolom harus diisi.");
            header("Location: /register");
            exit();
        }

        if ($password !== $confirm_password) {
            SessionHelper::setFlash("error", "Konfirmasi kata sandi tidak cocok.");
            header("Location: /register");
            exit();
        }

        if ($this->userModel->usernameExists($username)) {
            SessionHelper::setFlash("error", "Nama pengguna sudah terdaftar.");
            header("Location: /register");
            exit();
        }

        // Check if secret_key is provided (invitation-based registration)
        if (!empty($secret_key)) {
            $invitationModel = new \App\Models\PersonilInvitationModel();
            $invitation = $invitationModel->getInvitationBySecretKey($secret_key);
            
            if (!$invitation) {
                SessionHelper::setFlash("error", "Secret key tidak valid.");
                header("Location: /register");
                exit();
            }
            
            if ($invitation['is_used']) {
                SessionHelper::setFlash("error", "Secret key sudah digunakan.");
                header("Location: /register");
                exit();
            }
            
            // Create user account
            $data = [
                "username" => $username,
                "password" => $password,
                "role" => "personil", 
            ];
            
            $userId = $this->userModel->createUser($data);
            
            if ($userId) {
                // Link user to personil
                $personilModel = new \App\Models\PersonilModel();
                $db = \App\Database::getConnection();
                $stmt = $db->prepare("UPDATE personil SET user_id = :user_id WHERE id = :personil_id");
                $stmt->bindParam(':user_id', $userId);
                $stmt->bindParam(':personil_id', $invitation['personil_id']);
                $stmt->execute();
                
                // Mark invitation as used
                $invitationModel->markAsUsed($secret_key);
                
                SessionHelper::setFlash("success", "Pendaftaran berhasil! Silakan masuk.");
                header("Location: /login");
                exit();
            } else {
                SessionHelper::setFlash("error", "Pendaftaran gagal. Silakan coba lagi.");
                header("Location: /register");
                exit();
            }
        } else {
            // Regular registration (if you want to allow it)
            SessionHelper::setFlash("error", "Registrasi memerlukan secret key dari admin.");
            header("Location: /register");
            exit();
        }
    }
}
