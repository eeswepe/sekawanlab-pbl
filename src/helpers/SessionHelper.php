<?php

namespace App\Helpers;

class SessionHelper
{
    /**
     * Memulai session jika belum dimulai
     */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Mendapatkan ID user yang sedang login
     * @return int|null
     */
    public static function getUserId(): ?int
    {
        self::start();
        return $_SESSION["user"]["id"] ?? null;
    }

    /**
     * Mendapatkan username user yang sedang login
     * @return string|null
     */
    public static function getUsername(): ?string
    {
        self::start();
        return $_SESSION["user"]["username"] ?? null;
    }

    /**
     * Mendapatkan role user yang sedang login
     * @return string|null
     */
    public static function getRole(): ?string
    {
        self::start();
        return $_SESSION["user"]["role"] ?? null;
    }

    /**
     * Mendapatkan semua data user yang sedang login
     * @return array|null
     */
    public static function getUser(): ?array
    {
        self::start();
        return $_SESSION["user"] ?? null;
    }

    /**
     * Cek apakah user sudah login
     * @return bool
     */
    public static function isLoggedIn(): bool
    {
        self::start();
        return isset($_SESSION["user"]["id"]);
    }

    /**
     * Cek apakah user adalah admin
     * @return bool
     */
    public static function isAdmin(): bool
    {
        return self::getRole() === "admin";
    }

    /**
     * Cek apakah user adalah personil
     * @return bool
     */
    public static function isPersonil(): bool
    {
        return self::getRole() === "personil";
    }

    /**
     * Set data user ke session
     * @param array $user Data user (id, username, role)
     */
    public static function setUser(array $user): void
    {
        self::start();
        
        $_SESSION["user"] = [
            "id" => $user["id"],
            "username" => $user["username"],
            "role" => $user["role"]
        ];
    }

    /**
     * Hapus semua data session (logout)
     */
    public static function destroy(): void
    {
        self::start();
        $_SESSION = [];
        session_destroy();
    }

    /**
     * Set flash message
     * @param string $type Type pesan (success, error, warning, info)
     * @param string $message Isi pesan
     */
    public static function setFlash(string $type, string $message): void
    {
        self::start();
        $_SESSION["flash"][$type] = $message;
    }

    /**
     * Get dan hapus flash message
     * @param string $type Type pesan
     * @return string|null
     */
    public static function getFlash(string $type): ?string
    {
        self::start();
        $message = $_SESSION["flash"][$type] ?? null;
        
        if ($message) {
            unset($_SESSION["flash"][$type]);
        }
        
        return $message;
    }
}
