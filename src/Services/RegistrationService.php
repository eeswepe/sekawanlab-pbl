<?php

namespace App\Services\Auth;

use App\Models\UserModel;
use App\Models\PersonilModel;
use App\Models\PersonilInvitationModel;
use App\Database;

/**
 * RegistrationService
 * 
 * Service untuk menangani logic registrasi
 * Tanggung jawab:
 * - Validasi data registrasi
 * - Create user account
 * - Validate secret key (invitation)
 * - Link user ke personil
 * - Mark invitation as used
 */
class RegistrationService
{
    private UserModel $userModel;
    private PersonilModel $personilModel;
    private PersonilInvitationModel $invitationModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->personilModel = new PersonilModel();
        $this->invitationModel = new PersonilInvitationModel();
    }

    /**
     * Validasi data registrasi
     * 
     * @param array $data Data dari form (username, password, confirm_password, secret_key)
     * @return array ['valid' => bool, 'errors' => array]
     */
    public function validateRegistrationData(array $data): array
    {
        $errors = [];

        // Check required fields
        if (empty($data['username']) || empty(trim($data['username']))) {
            $errors[] = 'Username harus diisi';
        }

        if (empty($data['password'])) {
            $errors[] = 'Password harus diisi';
        }

        if (empty($data['confirm_password'])) {
            $errors[] = 'Konfirmasi password harus diisi';
        }

        // Check password match
        if (!empty($data['password']) && !empty($data['confirm_password'])) {
            if ($data['password'] !== $data['confirm_password']) {
                $errors[] = 'Konfirmasi password tidak cocok';
            }
        }

        // Check password length (minimal 6 karakter)
        if (!empty($data['password']) && strlen($data['password']) < 6) {
            $errors[] = 'Password minimal 6 karakter';
        }

        // Check username exists
        if (!empty($data['username']) && $this->userModel->usernameExists(trim($data['username']))) {
            $errors[] = 'Username sudah terdaftar';
        }

        // Check secret key (required untuk invitation-based registration)
        if (empty($data['secret_key']) || empty(trim($data['secret_key']))) {
            $errors[] = 'Secret key harus diisi';
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }

    /**
     * Validate secret key dan get invitation data
     * 
     * @param string $secretKey
     * @return array ['valid' => bool, 'message' => string, 'invitation' => array|null]
     */
    public function validateSecretKey(string $secretKey): array
    {
        $secretKey = trim($secretKey);

        if (empty($secretKey)) {
            return [
                'valid' => false,
                'message' => 'Secret key tidak boleh kosong',
                'invitation' => null
            ];
        }

        // Get invitation by secret key
        $invitation = $this->invitationModel->getInvitationBySecretKey($secretKey);

        if (!$invitation) {
            return [
                'valid' => false,
                'message' => 'Secret key tidak valid',
                'invitation' => null
            ];
        }

        if ($invitation['is_used']) {
            return [
                'valid' => false,
                'message' => 'Secret key sudah digunakan',
                'invitation' => null
            ];
        }

        return [
            'valid' => true,
            'message' => 'Secret key valid',
            'invitation' => $invitation
        ];
    }

    /**
     * Register user dengan invitation (secret key)
     * 
     * @param array $data ['username', 'password', 'secret_key']
     * @return array ['success' => bool, 'message' => string, 'user_id' => int|null]
     */
    public function registerWithInvitation(array $data): array
    {
        try {
            // Validasi data
            $validation = $this->validateRegistrationData($data);
            if (!$validation['valid']) {
                return [
                    'success' => false,
                    'message' => implode(', ', $validation['errors']),
                    'user_id' => null
                ];
            }

            // Validasi secret key
            $secretKeyValidation = $this->validateSecretKey($data['secret_key']);
            if (!$secretKeyValidation['valid']) {
                return [
                    'success' => false,
                    'message' => $secretKeyValidation['message'],
                    'user_id' => null
                ];
            }

            $invitation = $secretKeyValidation['invitation'];

            // Create user account
            $userData = [
                'username' => trim($data['username']),
                'password' => $data['password'],
                'role' => 'personil'
            ];

            $userId = $this->userModel->createUser($userData);

            if (!$userId) {
                return [
                    'success' => false,
                    'message' => 'Gagal membuat user account',
                    'user_id' => null
                ];
            }

            // Link user to personil
            $linkResult = $this->linkUserToPersonil($userId, $invitation['personil_id']);
            
            if (!$linkResult) {
                // Rollback: delete user if link failed
                $this->userModel->deleteUser($userId);
                return [
                    'success' => false,
                    'message' => 'Gagal menghubungkan user ke personil',
                    'user_id' => null
                ];
            }

            // Mark invitation as used
            $this->markInvitationAsUsed($data['secret_key']);

            return [
                'success' => true,
                'message' => 'Pendaftaran berhasil! Silakan login.',
                'user_id' => $userId
            ];

        } catch (\Exception $e) {
            error_log('Registration Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.',
                'user_id' => null
            ];
        }
    }

    /**
     * Link user_id ke personil
     * 
     * @param int $userId
     * @param int $personilId
     * @return bool
     */
    public function linkUserToPersonil(int $userId, int $personilId): bool
    {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("UPDATE personil SET user_id = :user_id WHERE id = :personil_id");
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':personil_id', $personilId);
            
            return $stmt->execute();
        } catch (\Exception $e) {
            error_log('Link User to Personil Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Mark invitation sebagai sudah digunakan
     * 
     * @param string $secretKey
     * @return bool
     */
    public function markInvitationAsUsed(string $secretKey): bool
    {
        try {
            return $this->invitationModel->markAsUsed($secretKey);
        } catch (\Exception $e) {
            error_log('Mark Invitation as Used Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Check apakah username sudah ada
     * 
     * @param string $username
     * @return bool
     */
    public function usernameExists(string $username): bool
    {
        return $this->userModel->usernameExists(trim($username));
    }

    /**
     * Get personil by invitation
     * 
     * @param string $secretKey
     * @return array|null
     */
    public function getPersonilBySecretKey(string $secretKey): ?array
    {
        $invitation = $this->invitationModel->getInvitationBySecretKey($secretKey);
        
        if (!$invitation) {
            return null;
        }

        return $this->personilModel->getPersonilById($invitation['personil_id']);
    }
}
