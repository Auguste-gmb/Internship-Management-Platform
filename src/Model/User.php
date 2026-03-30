<?php
declare(strict_types=1);

namespace App\Model;

use App\Core\Model;

class User extends Model
{
    public function findByEmail(string $email): ?array
    {
        $row = $this->query('
            SELECT u.id_user, u.email, u.password, u.active,
                   p.first_name, p.name,
                   r.role_name
            FROM User_ u
            JOIN Profil p ON p.id_profil = u.id_profil
            JOIN Role r   ON r.id_role   = u.id_role
            WHERE u.email = ? AND u.active = 1
            LIMIT 1
        ', [$email])->fetch();

        return $row ?: null;
    }

    public function findById(int $id): ?array
    {
        $row = $this->query('
            SELECT u.id_user, u.email, u.active,
                   p.first_name, p.name,
                   r.role_name
            FROM User_ u
            JOIN Profil p ON p.id_profil = u.id_profil
            JOIN Role r   ON r.id_role   = u.id_role
            WHERE u.id_user = ?
            LIMIT 1
        ', [$id])->fetch();

        return $row ?: null;
    }

   public function create(array $data): int
    {
        $pdo = $this->pdo;
        $pdo->beginTransaction();

        try {
            $this->query(
                'INSERT INTO Profil (first_name, name, creation_date) VALUES (?, ?, NOW())',
                [$data['first_name'], $data['name']]
            );
            $idProfil = (int) $pdo->lastInsertId();

            if ($idProfil === 0) {
                throw new \RuntimeException('Échec création profil');
            }

            $this->query(
                'INSERT INTO User_ (email, password, active, id_tutor, id_role, id_profil)
                VALUES (?, ?, 1, NULL, ?, ?)',
                [
                    $data['email'],
                    password_hash($data['password'], PASSWORD_BCRYPT),
                    $data['id_role'] ?? 1,
                    $idProfil,
                ]
            );

            $pdo->commit();
            return (int) $pdo->lastInsertId();

        } catch (\Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    
    public function count(): int
    {
        return (int) $this->query('SELECT COUNT(*) FROM User_')->fetchColumn();
    }
}