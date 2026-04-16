<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

/**
 * Motor de ruteo simple para manejar peticiones HTTP.
 * Permite registrar rutas y despacharlas a sus respectivos controladores.
 */
class Router
{
    private array $routes = [];

    public function add(string $method, string $path, callable $handler): void
    {
        // Convertir parámetros de ruta {id} a regex
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_-]+)', $path);
        $pattern = '#^' . $pattern . '$#';
        
        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'handler' => $handler
        ];
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                call_user_func_array($route['handler'], array_values($params));
                return;
            }
        }

        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
    }
}
