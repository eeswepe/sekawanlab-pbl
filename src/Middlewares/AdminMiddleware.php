<?php

namespace App\Middlewares;

use App\Helpers\SessionHelper;

class AdminMiddleware implements Middleware
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

        // Check if user has admin role
        if (!SessionHelper::isAdmin()) {
            SessionHelper::setFlash('error', 'Anda tidak memiliki akses ke halaman ini.');
            
            // Redirect personil to personil dashboard
            if (SessionHelper::isPersonil()) {
                header("Location: /personil");
            } else {
                header("Location: /login");
            }
            exit();
        }

        return true;
    }
}
