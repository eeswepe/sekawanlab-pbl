<?php

namespace App\Controllers;

use App\Controller;
use App\Models\UserModel;
use App\Models\PersonilModel;
use App\Helpers\SessionHelper;

class LoginController extends Controller
{
    private $userModel;
    private $personilModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->personilModel = new PersonilModel();
    }

    public function index()
    {
        $error = isset($_GET["error"]) ? $_GET["error"] : null;

        $data = [
            "error" => $error,
        ];

        $this->render("auth/login", $data);
    }

    public function authenticate()
    {
        $username = isset($_POST["username"]) ? trim($_POST["username"]) : null;
        $password = isset($_POST["password"]) ? $_POST["password"] : null;
        
        $user = $this->userModel->validateCredentials($username, $password);
        
        if ($user) {
            // Get personil_id if user is personil
            $personil_id = null;
            if ($user["role"] === "personil") {
                $personil = $this->personilModel->getPersonilByUserId($user["id"]);
                if ($personil) {
                    $personil_id = $personil["id"];
                }
            }
            
            // Store user data in session using SessionHelper
            SessionHelper::setUser([
                "id" => $user["id"],
                "username" => $user["username"],
                "role" => $user["role"],
                "personil_id" => $personil_id
            ]);
            
            SessionHelper::setFlash("success", "Login berhasil! Selamat datang, " . $user["username"] . ".");
            
            // Redirect based on role
            if ($user["role"] === "admin") {
                header("Location: /admin");
            } else {
                header("Location: /personil/dashboard");
            }
            exit();
        }

        header("Location: /login?error=invalid_credentials");
        exit();
    }

    public function logout()
    {
        SessionHelper::setFlash("success", "Anda telah berhasil logout.");
        SessionHelper::destroy();

        header("Location: /login");
        exit();
    }
}
