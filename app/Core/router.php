<?php
namespace App\Core;

class Router {
    private $routes = [];

    public function add($uri, $controller, $method, $params = []) {
        $this->routes[$uri] = [
            'controller' => $controller, 
            'method' => $method,
            'params' => $params
        ];
    }

    public function dispatch($uri, $requestMethod) {
        if (array_key_exists($uri, $this->routes)) {
            return $this->executeRoute($this->routes[$uri]);
        }

        foreach ($this->routes as $route => $details) {
            if (strpos($route, '{') !== false) {
                $pattern = preg_replace('/\{[a-z]+\}/', '([0-9]+)', $route);
                $pattern = str_replace('/', '\/', $pattern);
                
                if (preg_match('/^' . $pattern . '$/', $uri, $matches)) {
                    array_shift($matches);
                    $details['params'] = $matches;
                    return $this->executeRoute($details);
                }
            }
        }

        http_response_code(404);
        echo "Página não encontrada";
    }

    private function executeRoute($route) {
        $controller = $route['controller'];
        $method = $route['method'];
        $params = $route['params'] ?? [];
        
        $controllerInstance = new $controller();
        
        if (!empty($params)) {
            call_user_func_array([$controllerInstance, $method], $params);
        } else {
            $controllerInstance->$method();
        }
    }
}