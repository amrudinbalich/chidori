<?php

namespace Chidori\Foundation\Core;

class Router {
    protected array $routes = [];

    public function get(string $uri, $controller) {
        $this->routes['GET'][$uri] = $controller;
    }

    public function dispatch(string $uri, string $method) {
        if (isset($this->routes[$method][$uri]) && is_array($this->routes[$method][$uri])) {
            [$controller, $method] = $this->routes[$method][$uri];

            (new $controller)->$method();
        } else {
            http_response_code(404);
            echo "404 - Page Not Found";
        }
    }
}
