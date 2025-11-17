<?php

namespace App\Services\Auth;

use App\Models\UserModel;
use App\Models\PersonilModel;
use App\Helpers\SessionHelper;

/**
 * AuthService
 * 
 * Service untuk menangani logic autentikasi
 * Tanggung jawab:
 * - Validasi credentials
 * - Login (set session)
 * - Logout (destroy session)
 * - Get data personil untuk role personil
 */
class AuthService
{
    private UserModel $userModel;
    private PersonilModel $personilModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->personilModel = new PersonilModel();
    }

    /**
     * Validasi username dan password
     * 
     * @param string $username
     * @param string $password
     * @return array|false User data jika valid, false jika tidak
     */
    public function validateCredentials(string $username, string $password): array|false
    {
        // Trim username
        $username = trim($username);

        // Validasi input kosong
        if (empty($username) || empty($password)) {
            return false;
        }

        // Validasi credentials menggunakan UserModel
        $user = $this->userModel->validateCredentials($username, $password);

        return $user;
    }

    /**
     * Login user dan set session
     * 
     * @param array $user User data dari database
     * @return bool
     */
    public function login(array $user): bool
    {
        try {
            // Get personil_id jika user adalah personil
            $personil_id = null;
            if ($user['role'] === 'personil') {
                $personil = $this->personilModel->getPersonilByUserId($user['id']);
                if ($personil) {
                    $personil_id = $personil['id'];
                }
            }

            // Set session data menggunakan SessionHelper
            SessionHelper::setUser([
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'personil_id' => $personil_id
            ]);

            // Set flash message
            SessionHelper::setFlash('success', 'Login berhasil! Selamat datang, ' . $user['username'] . '.');

            return true;
        } catch (\Exception $e) {
            error_log('Login Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Logout user (destroy session)
     * 
     * @return void
     */
    public function logout(): void
    {
        SessionHelper::setFlash('success', 'Anda telah berhasil logout.');
        SessionHelper::destroy();
    }

    /**
     * Get redirect URL berdasarkan role user
     * 
     * @param string $role
     * @return string
     */
    public function getRedirectUrlByRole(string $role): string
    {
        return match ($role) {
            'admin' => '/admin',
            'personil' => '/personil/dashboard',
            default => '/'
        };
    }

    /**
     * Get personil data by user_id
     * 
     * @param int $userId
     * @return array|null
     */
    public function getPersonilDataByUserId(int $userId): ?array
    {
        return $this->personilModel->getPersonilByUserId($userId);
    }

    /**
     * Check apakah user sudah login
     * 
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return SessionHelper::isLoggedIn();
    }

    /**
     * Get current logged in user
     * 
     * @return array|null
     */
    public function getCurrentUser(): ?array
    {
        return SessionHelper::getUser();
    }

    /**
     * Check apakah user adalah admin
     * 
     * @return bool
     */
    public function isAdmin(): bool
    {
        $user = $this->getCurrentUser();
        return $user && $user['role'] === 'admin';
    }

    /**
     * Check apakah user adalah personil
     * 
     * @return bool
     */
    public function isPersonil(): bool
    {
        $user = $this->getCurrentUser();
        return $user && $user['role'] === 'personil';
    }
}
