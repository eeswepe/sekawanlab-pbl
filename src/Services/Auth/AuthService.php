<?php

namespace App\Services\Auth;

use App\Models\PersonilModel;
use App\Helpers\SessionHelper;

/**
 * AuthService
 * 
 * Service untuk menangani logic autentikasi
 * Updated: Menggunakan PersonilModel langsung (tanpa UserModel)
 * 
 * Tanggung jawab:
 * - Validasi credentials (nim_nip dan password)
 * - Login (set session)
 * - Logout (destroy session)
 * - Get data personil
 * - Check role & privilege
 */
class AuthService
{
    private PersonilModel $personilModel;

    public function __construct()
    {
        $this->personilModel = new PersonilModel();
    }

    /**
     * Validasi nim_nip dan password
     * 
     * @param string $nimNip NIM/NIP untuk login
     * @param string $password Password
     * @return array|false Personil data jika valid, false jika tidak
     */
    public function validateCredentials(string $nimNip, string $password): array|false
    {
        // Trim nim_nip
        $nimNip = trim($nimNip);

        // Validasi input kosong
        if (empty($nimNip) || empty($password)) {
            return false;
        }

        // Validasi credentials menggunakan PersonilModel
        $personil = $this->personilModel->validateCredentials($nimNip, $password);

        return $personil;
    }

    public function unveriviedNimNip(string $nimNip, string $password): bool
    {
        $user = $this->personilModel->getPersonilByNimNip($nimNip);
        if(!$this->personilModel->passwordExist($nimNip)) {
            $this->personilModel->changePassword($user['id'], $password);
            return true;
        }
        return false;
    }

    /**
     * Login personil dan set session
     * 
     * @param array $personil Personil data dari database
     * @return bool
     */
    public function login(array $personil): bool
    {
        try {
            // Set session data menggunakan SessionHelper
            SessionHelper::setUser([
                'id' => $personil['id'],
                'nim_nip' => $personil['nim_nip'],
                'nama_lengkap' => $personil['nama_lengkap'],
                'role' => $personil['role'],  // admin / dosen / talent
                'email' => $personil['email'] ?? null,
                'foto_url' => $personil['foto_url'] ?? null
            ]);

            // Set flash message
            SessionHelper::setFlash('success', 'Login berhasil! Selamat datang, ' . $personil['nama_lengkap'] . '.');

            return true;
        } catch (\Exception $e) {
            error_log('Login Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Logout personil (destroy session)
     * 
     * @return void
     */
    public function logout(): void
    {
        SessionHelper::setFlash('success', 'Anda telah berhasil logout.');
        SessionHelper::destroy();
    }

    /**
     * Get redirect URL berdasarkan role
     * 
     * @param string $role
     * @return string
     */
    public function getRedirectUrlByRole(string $role): string
    {
        return match ($role) {
            'admin', 'dosen' => '/admin',  // admin dan dosen ke admin dashboard
            'talent' => '/personil/dashboard',
            default => '/'
        };
    }

    /**
     * Get personil data by id
     * 
     * @param int $personilId
     * @return array|null
     */
    public function getPersonilDataById(int $personilId): ?array
    {
        return $this->personilModel->getPersonilById($personilId);
    }

    /**
     * Check apakah personil sudah login
     * 
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return SessionHelper::isLoggedIn();
    }

    /**
     * Get current logged in personil
     * 
     * @return array|null
     */
    public function getCurrentUser(): ?array
    {
        return SessionHelper::getUser();
    }

    /**
     * Check apakah personil adalah admin murni (bukan dosen)
     * 
     * @return bool
     */
    public function isAdmin(): bool
    {
        $user = $this->getCurrentUser();
        return $user && $user['role'] === 'admin';
    }

    /**
     * Check apakah personil adalah dosen
     * 
     * @return bool
     */
    public function isDosen(): bool
    {
        $user = $this->getCurrentUser();
        return $user && $user['role'] === 'dosen';
    }

    /**
     * Get personil model instance
     * 
     * @return PersonilModel
     */
    public function getPersonilModel(): PersonilModel
    {
        return $this->personilModel;
    }
}
