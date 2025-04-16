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
       $fileds = array_keys($data);

       $columns = implode(', ', $fileds);
       $binds = implode(', ', array_map(fn($field) => ":$field", $fileds));

       $sql = "INSERT INTO $table ($columns) VALUES ($binds)";


       $stmt = $this ->pdo->prepare($sql);
       $stmt->execute($data);

       try{
              $stmt->execute($data);
         }catch (PDOException $exception){
           return false;
       }
       return $this->pdo->lastInsertId();

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

        $dsn = "mysql:host=database;port=3306;dbname=kinopoisk;charset=utf8";
        $username = 'root';
        $password = '123456';
        $pdo = new PDO($dsn, $username, $password);


        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Ошибка подключения к базе данных: " . $e->getMessage());
        }
    }
}
