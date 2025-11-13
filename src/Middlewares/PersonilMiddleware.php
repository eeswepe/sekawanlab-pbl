<?php

namespace App\Middlewares;

use App\Helpers\SessionHelper;

class PersonilMiddleware implements Middleware
{
    public function handle(): bool
    {
        // Start session jika belum
        SessionHelper::start();

        // Check if user is logged in
        if (!SessionHelper::isLoggedIn()) {
            SessionHelper::setFlash('error', 'Silakan login terlebih dahulu.');
            header("Location: /login");
            exit();
        }

        // Check if user has personil role
        if (!SessionHelper::isPersonil()) {
            SessionHelper::setFlash('error', 'Anda tidak memiliki akses ke halaman ini.');
            
            // Redirect admin to admin dashboard
            if (SessionHelper::isAdmin()) {
                header("Location: /admin");
            } else {
                header("Location: /login");
            }
            exit();
        }

        return true;
    }
}
