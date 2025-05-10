<?php

namespace Chidori\Foundation\Core;

class Router {
    protected array $routes = [];

    public function get(string $uri, $controller) {
        $this->routes['GET'][$uri] = $controller;
    }

    public function dispatch(string $uri, string $method): Response {
        $targetUrl = $this->routes[$method][$uri];

        if(!isset($targetUrl) && !is_array($targetUrl)) {
            return new Response('Not found', 404);
        }

        $result = container()->resolve($targetUrl);

        if (!$result instanceof Response) {
            $result = new Response($result);
        }

        return $result;
    }
}
