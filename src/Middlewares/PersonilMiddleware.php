<?php

namespace App\Middlewares;

class PersonilMiddleware implements Middleware
{
    public function handle(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Cek apakah user memiliki role personil atau admin
        if (!isset($_SESSION["user"]["role"]) || 
            ($_SESSION["user"]["role"] !== "personil" && $_SESSION["user"]["role"] !== "admin")) {
            header("Location: /");
            exit();
        }

        return true;
    }
}
