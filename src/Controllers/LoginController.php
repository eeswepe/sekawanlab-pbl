<?php

namespace App\Controllers;

use App\Controller;
use App\Models\UserModel;
use App\Helpers\SessionHelper;

class LoginController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $error = isset($_GET["error"]) ? $_GET["error"] : null;

        $data = [
            "error" => $error,
        ];

        $this->render("login", $data);
    }

    public function authenticate()
    {
        $username = isset($_POST["username"]) ? trim($_POST["username"]) : null;
        $password = isset($_POST["password"]) ? $_POST["password"] : null;
        
        $user = $this->userModel->validateCredentials($username, $password);
        
        if ($user) {
            // Start session if not started
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            // Store user data in session
            $_SESSION["user"] = [
                "id" => $user["id"],
                "username" => $user["username"],
                "role" => $user["role"]
            ];
            
            header("Location: /dashboard");
            // var_dump($_SESSION);
            // exit();
        }

        header("Location: /login?error=invalid_credentials");
        exit();
    }

    public function logout(){
        // Start session if not started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        SessionHelper::destroy();

        header("Location: /login");
        exit();
    }
}
