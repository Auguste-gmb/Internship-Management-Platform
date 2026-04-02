<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use App\Core\Database;

abstract class Model
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getPdo();
    }

    protected function query(string $sql, array $params = []): \PDOStatement
    {
        return Database::getInstance()->query($sql, $params);
    }
}