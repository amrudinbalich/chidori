<?php

// max error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
ini_set('error_reporting', E_ALL);
ini_set('log_errors', '1');

require __DIR__ . '/../vendor/autoload.php';

session_start();
ob_start();

$request = new \Chidori\Foundation\Core\Request();
$router = new \Chidori\Foundation\Core\Router();
require __DIR__ . '/../routes/web.php';

$router->dispatch($request->url(), $request->method());

ob_end_flush();