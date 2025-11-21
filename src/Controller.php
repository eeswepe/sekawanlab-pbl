<?php

namespace App;

use App\Helpers\GlobalDataProvider;

/**
 * Base Controller
 * 
 * Controller dasar tanpa ketergantungan model
 * Mengikuti Single Responsibility Principle (SRP)
 */
class Controller
{
    /**
     * Render view dengan data
     * 
     * @param string $view Path ke view file
     * @param array $data Data yang akan dikirim ke view
     */
    protected function render($view, $data = [])
    {
        // Inject global navigation/profile data
        $globalData = GlobalDataProvider::getNavigationData();
        extract($data);
        // $globalData now available to all views (header/footer)
        include "Views/$view.php";
    }

    /**
     * Send JSON response
     * 
     * @param mixed $data
     * @param int $statusCode
     */
    protected function jsonResponse($data, $statusCode = 200)
    {
        // Clear any output that might have been sent
        if (ob_get_length()) {
            ob_clean();
        }
        
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Redirect to URL
     * 
     * @param string $url
     */
    protected function redirect($url)
    {
        header("Location: $url");
        exit;
    }
}

