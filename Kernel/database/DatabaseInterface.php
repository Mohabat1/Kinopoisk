<?php

namespace App\Kernel\database;

interface DatabaseInterface
{
public function insert(string $table, array $data): int|false;
public function first(string $table, array $conditions = []): ?array;
}