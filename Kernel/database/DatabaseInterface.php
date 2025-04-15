<?php

namespace App\Kernel\database;

interface DatabaseInterface
{
public function insert(string $table, array $data): int|false;
}