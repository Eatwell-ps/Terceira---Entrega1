<?php
require_once '../app/Core/Database.php';
require_once '../app/Core/Router.php';
require_once '../app/Core/Controller.php';
require_once '../app/Core/Model.php';
require_once '../app/Core/Repository.php';
require_once '../app/Core/Request.php';

// Autoload para controllers, models e repositories
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

session_start();

$router = new App\Core\Router();

// Rotas
require_once '../app/routes.php';

$uri = App\Core\Request::uri();
$method = App\Core\Request::method();

$router->dispatch($uri, $method);