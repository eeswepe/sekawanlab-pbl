<?php

namespace App;

class Router
{
    protected $routes = [];
    protected $lastRoute = null;

    private function addRoute($route, $controller, $action, $method)
    {
        $this->routes[$method][$route] = [
            "controller" => $controller,
            "action" => $action,
            "middlewares" => [],
        ];
        $this->lastRoute = &$this->routes[$method][$route];
    }

    public function get($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, "GET");
        return $this;
    }

    public function post($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, "POST");
        return $this;
    }

    public function middleware($middlewareClass)
    {
        if ($this->lastRoute !== null) {
            $this->lastRoute["middlewares"][] = $middlewareClass;
        }
        return $this;
    }

    public function dispatch()
    {
        $uri = strtok($_SERVER["REQUEST_URI"], "?");
        $method = $_SERVER["REQUEST_METHOD"];
        $routes = $this->routes[$method] ?? [];

        foreach ($routes as $routePattern => $routeInfo) {
            $pattern = preg_replace(
                "/\{([a-zA-Z0-9_]+)\}/",
                '(?P<$1>[^/]+)',
                $routePattern,
            );
            $pattern = "#^$pattern$#";

            if (preg_match($pattern, $uri, $matches)) {
                $controller = $routeInfo["controller"];
                $action = $routeInfo["action"];
                $middlewares = $routeInfo["middlewares"];

                $params = array_filter(
                    $matches,
                    "is_string",
                    ARRAY_FILTER_USE_KEY,
                );

                // Jalankan middleware
                foreach ($middlewares as $middlewareClass) {
                    $middleware = new $middlewareClass();
                    $result = $middleware->handle();
                    if ($result === false) {
                        return;
                    }
                }

                // Jalankan controller
                $controllerInstance = new $controller();
                call_user_func_array([$controllerInstance, $action], $params);
                return;
            }
        }

        http_response_code(404);
        echo "404 - Page Not Found";
    }
}
