<?php

namespace Chidori\Foundation\Core;

class Request
{
    public function url() {
        $uri = $_SERVER['REQUEST_URI'];

        if(str_contains($uri, '/my_proj/')) { // sanitize for my local environment
            $uri = str_replace('/my_proj/', '/', $uri);
        }

        return $uri;
    }

    public function method() {
        return $_SERVER['REQUEST_METHOD'];
    }
}