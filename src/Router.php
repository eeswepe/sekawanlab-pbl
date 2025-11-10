<?php

namespace App;

class Router
{
    protected $routes = [];

    private function addRoute($route, $controller, $action, $method)
    {
        $this->routes[$method][$route] = [
            "controller" => $controller,
            "action" => $action,
        ];
    }

    public function get($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, "GET");
    }

    public function post($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, "POST");
    }

    public function dispatch()
    {
        $uri = strtok($_SERVER["REQUEST_URI"], "?");
        $method = $_SERVER["REQUEST_METHOD"];

        $routes = $this->routes[$method] ?? [];

        foreach ($routes as $routePattern => $routeInfo) {
            // Convert route pattern to a regex
            $pattern = preg_replace(
                "/\{([a-zA-Z0-9_]+)\}/",
                '(?P<$1>[^/]+)',
                $routePattern,
            );
            $pattern = "#^$pattern$#";

            if (preg_match($pattern, $uri, $matches)) {
                $controller = $routeInfo["controller"];
                $action = $routeInfo["action"];

                // Extract named parameters
                $params = array_filter(
                    $matches,
                    "is_string",
                    ARRAY_FILTER_USE_KEY,
                );

                $controllerInstance = new $controller();
                call_user_func_array([$controllerInstance, $action], $params);
                return;
            }
        }
    }
}
