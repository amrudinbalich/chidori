<?php

namespace Chidori\Foundation\Controllers;

class HomeController
{
    public function index() {
        view('home', [
            'title' => 'Home',
            'content' => 'Welcome to the home page!'
        ]);
    }
}