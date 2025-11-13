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

        // Temporary registration: default role to 'personil' as seen in other controllers
        $data = [
            "username" => $username,
            "password" => $password,
            "role" => "personil", 
        ];

        if ($this->userModel->createUser($data)) {
            SessionHelper::setFlash("success", "Pendaftaran berhasil! Silakan masuk.");
            header("Location: /login");
            exit();
        } else {
            SessionHelper::setFlash("error", "Pendaftaran gagal. Silakan coba lagi.");
            header("Location: /register");
            exit();
        }
    }
}
