<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use PDOStatement;

final class Database
{
    private static ?self $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        $url   = $_ENV['DATABASE_URL'] ?? throw new \RuntimeException('DATABASE_URL non définie.');
        $parts = parse_url($url);

        $dsn = sprintf(
            'pgsql:host=%s;port=%s;dbname=%s',
            $parts['host'],
            $parts['port'] ?? 5432,
            ltrim($parts['path'], '/')
        );

        $this->pdo = new PDO($dsn, $parts['user'], $parts['pass'], [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    public function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}