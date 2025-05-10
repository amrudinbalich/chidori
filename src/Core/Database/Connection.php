<?php

namespace Chidori\Foundation\Core\Database;

use PDO;

class Connection
{
    private PDO $connection;
    private DatabaseConfig $config;

    public function __construct(DatabaseConfig $config)
    {
        $this->config = $config;
    }

    public function connect(): PDO {
        if (!isset($this->connection)) {
            $dsn = "mysql:host={$this->config->host};port={$this->config->port};dbname={$this->config->database}";
            $this->connection = new PDO($dsn, $this->config->username, $this->config->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }

        return $this->connection;
    }

    public function getPDO(): PDO {
        return $this->connection ?? $this->connect();
    }
}