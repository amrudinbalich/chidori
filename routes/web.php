<?php

// Define your routes here

use Chidori\Foundation\Controllers\AboutController;
use Chidori\Foundation\Controllers\HomeController;

$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [AboutController::class, 'index']);
