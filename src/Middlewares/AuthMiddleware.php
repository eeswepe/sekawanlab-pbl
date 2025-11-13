<?php
namespace App\Middlewares;
class AuthMiddleware implements Middleware
{
    public function handle(): bool
    {
        // Start session jika belum
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is logged in
        if (!isset($_SESSION["user"]["id"])) {
            header("Location: /login");
            exit();
        }

        return true;
    }
}
