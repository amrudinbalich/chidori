<?php

function view(string $view, array $params = []) {
    $viewPath = __DIR__ . '/../../views/' . $view . '.php';

    if (file_exists($viewPath)) {
        extract($params);
        require $viewPath;
    } else {
        http_response_code(404);
        throw new \Exception('View does not exist');
    }
}