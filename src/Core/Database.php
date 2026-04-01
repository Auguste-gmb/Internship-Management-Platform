<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;
    

    private function __construct()
    {
        $connectionString = $_ENV['DATABASE_URL'];

        $parts = parse_url($connectionString);

        $dsn = sprintf(
        'pgsql:host=%s;port=%s;dbname=%s',
            $parts['host'],
            $parts['port'],
            ltrim($parts['path'], '/')
        );

        try {
            $this->pdo = new PDO($dsn, $parts['user'], $parts['pass'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage() . "\n";
        }
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

    public function query(string $sql, array $params = []): \PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}