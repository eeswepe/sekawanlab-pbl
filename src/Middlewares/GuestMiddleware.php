<?php

namespace App\Middlewares;

class GuestMiddleware implements Middleware
{
    public function handle(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Cek apakah user sudah login
        if (isset($_SESSION["user"]["id"])) {
            // Sudah login, redirect ke dashboard sesuai role
            $role = $_SESSION["user"]["role"] ?? "user";

            if ($role === "admin") {
                header("Location: /admin");
            } elseif ($role === "personil") {
                header("Location: /personil/dashboard");
            } else {
                header("Location: /");
            }
            exit();
        }

        // User belum login (guest), lanjutkan
        return true;
    }
}
