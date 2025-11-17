<?php

namespace App;

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
        extract($data);
        include "Views/$view.php";
    }

    /**
     * Send JSON response
     * 
     * @param array $data
     * @param int $statusCode
     */
    protected function jsonResponse($data, $statusCode = 200)
    {
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

