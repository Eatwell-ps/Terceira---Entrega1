<?php
namespace App\Core;

class Controller {
    protected function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . "/../Views/{$view}.php";
    }

    protected function redirect($url) {
        header("Location: {$url}");
        exit();
    }

    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function sanitizeInput($input) {
        return htmlspecialchars(strip_tags(trim($input)));
    }

    protected function jsonResponse($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}