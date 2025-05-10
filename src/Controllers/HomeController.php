<?php

namespace Chidori\Foundation\Controllers;

class HomeController
{
    public function index() {
        return view('home', [
            'title' => 'Home',
            'content' => 'Welcome to the home page!'
        ]);
    }
}