<?php

namespace app\Controllers;

class Router
{
    private array $routes = [];

    public function addRoute($method, $path, $controller): void
    {
        $this->routes[] = ['method' => $method, 'path' => $path, 'controller' => $controller];
    }

    public function handleRequest(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['path'] === $requestPath) {
                $controllerFile = str_replace('\\', '/', $route['controller']) . '.php';
                $controllerPath = base_path("app/controllers/$controllerFile");

                if (file_exists($controllerPath)) {
                    require_once $controllerPath;
                } else {
                    echo "Controller not found.";
                    var_dump($controllerPath);
                }
                return;
            }
        }
        echo "Route not found.";
    }
}
