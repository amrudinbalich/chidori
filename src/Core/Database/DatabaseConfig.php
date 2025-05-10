<?php

namespace Chidori\Foundation\Core\Database;

class DatabaseConfig
{
    public function __construct(
        public string $host = 'localhost',
        public int $port = 83,
        public string $database = 'my_proj',
        public string $username = 'root',
        public string $password = ''
    ) {}
}