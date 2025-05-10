<?php

function view(string $view, array $params = []): string {
    $viewPath = __DIR__ . '/../../views/' . $view . '.php';

    if (file_exists($viewPath)) {
        extract($params);

        ob_start();

        require $viewPath;

        return ob_get_clean();
    } else {
        http_response_code(404);
        throw new \Exception('View does not exist');
    }
}

function config($config) {
    $configPath = __DIR__ . '/../../config/' . $config . '.php';

    if (file_exists($configPath)) {
        return require $configPath;
    } else {
        http_response_code(404);
        throw new \Exception('Config does not exist');
    }
}

function container() {
    global $container;

    if(!isset($container)) {
        $container = new \Chidori\Foundation\Core\Container();
    }

    return $container;
}