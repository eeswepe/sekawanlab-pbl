<?php

namespace App\Middlewares;

class CsrfMiddleware implements Middleware
{
    public function handle(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $method = $_SERVER["REQUEST_METHOD"];
        if (!in_array($method, ["POST", "PUT", "DELETE"])) {
            return true;
        }

        $token = $_POST["csrf_token"] ?? "";
        $sessionToken = $_SESSION["csrf_token"] ?? "";

        if (
            empty($token) ||
            empty($sessionToken) ||
            !hash_equals($sessionToken, $token)
        ) {
            http_response_code(403);
            die(
                "CSRF token validation failed. Silakan refresh halaman dan coba lagi."
            );
        }

        return true;
    }

    public static function generateToken(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["csrf_token"])) {
            $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
        }

        return $_SESSION["csrf_token"];
    }
}

function csrf_field(): string
{
    $token = \App\Middlewares\CsrfMiddleware::generateToken();
    return '<input type="hidden" name="csrf_token" value="' .
        htmlspecialchars($token) .
        '">';
}

function csrf_token(): string
{
    return \App\Middlewares\CsrfMiddleware::generateToken();
}
