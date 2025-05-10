<?php

// max error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
ini_set('error_reporting', E_ALL);
ini_set('log_errors', '1');

require __DIR__ . '/../vendor/autoload.php';

// todo: implement session and auth...
//session_start();
//ob_start();

$container = new \Chidori\Foundation\Core\Container();

$request = new \Chidori\Foundation\Core\Request();
$router = new \Chidori\Foundation\Core\Router();

require __DIR__ . '/../routes/web.php';

$response = $router->dispatch(
    uri: $request->url(),
    method: $request->method()
);

$response->send();