<?php
namespace App\Core;

class Request {
    public static function uri() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = str_replace('/index.php', '', $uri);
        return $uri ?: '/';
    }

    public static function method() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function get($key, $default = null) {
        return $_GET[$key] ?? $default;
    }

    public static function post($key, $default = null) {
        return $_POST[$key] ?? $default;
    }
}