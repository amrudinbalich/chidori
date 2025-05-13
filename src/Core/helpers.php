<?php

use Twig\Environment;

/**
 * Get the Twig.
 *
 * @return Environment
 */
function twig(): Environment {
    return resolve(Environment::class);
}

/**
 * Resolve/get a specific service from the container.
 *
 * @param string $abstract
 * @return mixed
 */
function resolve(string $abstract)
{
    global $container;
    return $container->get($abstract);
}

/**
 * Returns a path to desired asset from public/assets folder.
 * If your asset is nested, specify your nested path like: 'images/my_img.png'
 * Otherwise the service is automatically set for the `assets` folder.
 *
 * @param string $path Name or nested path of your asset with file-extension.
 * @return string
 */
function asset(string $path): string {
    return 'public/assets/' . $path;
}

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