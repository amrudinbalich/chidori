<?php

// max error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
ini_set('error_reporting', E_ALL);
ini_set('log_errors', '1');

require __DIR__ . '/../vendor/autoload.php';


$container = new \Chidori\Foundation\Core\Container();
require_once __DIR__ . '/../config/services.php';

$request = new \Chidori\Foundation\Core\Request();
$router = new \Chidori\Foundation\Core\Router();

require_once __DIR__ . '/../routes/web.php';

$response = $router->dispatch(
    uri: $request->url(),
    method: $request->method()
);

$response->send();