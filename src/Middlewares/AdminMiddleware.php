<?php

namespace App\Middlewares;
class AdminMiddleware implements Middleware
{
    public function handle(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user has admin role
        if (!isset($_SESSION["user"]["role"]) || $_SESSION["user"]["role"] !== "admin") {
            header("Location: /");
            exit();
        }

        return true;
    }
}
