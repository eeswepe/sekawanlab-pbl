<?php

namespace App\Controllers;

use App\Controller;
use App\Services\Auth\AuthService;
use App\Helpers\SessionHelper;

/**
 * LoginController (REFACTORED)
 * 
 * Controller yang sudah di-refactor untuk menggunakan AuthService
 * Tanggung jawab:
 * - Handle HTTP request/response
 * - Render views
 * - Call AuthService untuk business logic
 */
class LoginController extends Controller
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    /**
     * Render login page
     * 
     * GET /login
     */
    public function index()
    {
        $error = $_GET['error'] ?? null;

        $data = [
            'error' => $error,
        ];

        $this->render('auth/login', $data);
    }

    /**
     * Handle login authentication
     * 
     * POST /login
     */
    public function authenticate()
    {
        // Get input from POST
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validate credentials menggunakan AuthService
        $user = $this->authService->validateCredentials($username, $password);

        if (!$user) {
            // Redirect ke login dengan error
            header('Location: /login?error=invalid_credentials');
            exit();
        }

        // Login user (set session) menggunakan AuthService
        $loginSuccess = $this->authService->login($user);

        if (!$loginSuccess) {
            header('Location: /login?error=login_failed');
            exit();
        }

        // Get redirect URL berdasarkan role
        $redirectUrl = $this->authService->getRedirectUrlByRole($user['role']);

        // Redirect to dashboard
        header('Location: ' . $redirectUrl);
        exit();
    }

    /**
     * Handle logout
     * 
     * GET/POST /logout
     */
    public function logout()
    {
        // Logout menggunakan AuthService
        $this->authService->logout();

        // Redirect to login page
        header('Location: /login');
        exit();
    }
}
