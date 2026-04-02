<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOStatement;



abstract class Model
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getPdo();
    }

    protected function query(string $sql, array $params = []): PDOStatement
    {
        return Database::getInstance()->query($sql, $params);
    }

    protected function fetchOne(string $sql, array $params = []): ?array
    {
        $row = $this->query($sql, $params)->fetch();
        return $row ?: null;
    }

    protected function fetchAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    protected function fetchColumn(string $sql, array $params = []): mixed
    {
        return $this->query($sql, $params)->fetchColumn();
    }

    protected function placeholders(array $items): string
    {
        return implode(',', array_fill(0, count($items), '?'));
    }
}