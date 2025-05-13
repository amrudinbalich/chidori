<?php

namespace Chidori\Foundation\Controllers;

class HomeController
{
    public function index(): string {
        return twig()->render('home.html.twig');
    }
}