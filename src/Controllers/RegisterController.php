<?php

namespace App\Controllers;

use App\Controller;
use App\Services\Auth\RegistrationService;
use App\Helpers\SessionHelper;

/**
 * RegisterController (REFACTORED)
 * 
 * Controller yang sudah di-refactor untuk menggunakan RegistrationService
 * Tanggung jawab:
 * - Handle HTTP request/response
 * - Render views
 * - Call RegistrationService untuk business logic
 */
class RegisterController extends Controller
{
    private RegistrationService $registrationService;

    public function __construct()
    {
        $this->registrationService = new RegistrationService();
    }

    /**
     * Render registration page
     * 
     * GET /register
     */
    public function index()
    {
        $error = $_GET['error'] ?? null;
        $success = $_GET['success'] ?? null;

        $data = [
            'error' => $error,
            'success' => $success,
        ];

        $this->render('auth/register', $data);
    }

    /**
     * Handle user registration
     * 
     * POST /register
     */
    public function register()
    {
        // Get input dari POST
        $data = [
            'username' => $_POST['username'] ?? '',
            'password' => $_POST['password'] ?? '',
            'confirm_password' => $_POST['confirm_password'] ?? '',
            'secret_key' => $_POST['secret_key'] ?? ''
        ];

        // Register dengan invitation menggunakan RegistrationService
        $result = $this->registrationService->registerWithInvitation($data);

        if (!$result['success']) {
            // Set flash error message
            SessionHelper::setFlash('error', $result['message']);
            header('Location: /register');
            exit();
        }

        // Set flash success message
        SessionHelper::setFlash('success', $result['message']);
        
        // Redirect ke login page
        header('Location: /login');
        exit();
    }
}
