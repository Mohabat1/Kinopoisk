<?php

namespace App\Kernel\database;

use App\Kernel\Config\ConfigInterface;
use App\Kernel\database\DatabaseInterface;
use PDO;
use PDOException;

class Database implements DatabaseInterface
{
    private PDO $pdo;

    public function __construct(
        private ConfigInterface $config
    ) {
        $this->connect();
    }

    public function insert(string $table, array $data): int|false
    {
        // Тут можно позже дописать логику вставки данных
        return false;
    }

    private function connect(): void
    {
        $driver = $this->config->get('database.driver');
        $host = $this->config->get('database.host');
        $port = $this->config->get('database.port');
        $dbname = $this->config->get('database.dbname');
        $charset = $this->config->get('database.charset');
        $username = $this->config->get('database.username');
        $password = $this->config->get('database.password');

        $dsn = "$driver:host=$host;port=$port;dbname=$dbname;charset=$charset";

        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Ошибка подключения к базе данных: " . $e->getMessage());
        }
    }
}
