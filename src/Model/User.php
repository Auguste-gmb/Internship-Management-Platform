<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->query(
            'SELECT u.*, p.first_name, p.name, r.role_name
             FROM User_ u
             JOIN Profil p ON p.id_profil = u.id_profil
             JOIN Role r   ON r.id_role   = u.id_role
             WHERE u.email = ? AND u.active = 1
             LIMIT 1',
            [$email]
        );
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->query(
            'SELECT u.*, p.first_name, p.name, r.role_name
             FROM User_ u
             JOIN Profil p ON p.id_profil = u.id_profil
             JOIN Role r   ON r.id_role   = u.id_role
             WHERE u.id_user = ?',
            [$id]
        );
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(array $data): int
    {
        // 1. Créer le profil
        $this->query(
            'INSERT INTO Profil (first_name, name, creation_date) VALUES (?, ?, NOW())',
            [$data['first_name'], $data['name']]
        );
        $idProfil = (int) $this->pdo->lastInsertId();

        // 2. Créer le user
        $this->query(
            'INSERT INTO User_ (email, password, active, id_tutor, id_role, id_profil)
             VALUES (?, ?, 1, ?, ?, ?)',
            [
                $data['email'],
                password_hash($data['password'], PASSWORD_BCRYPT),
                $data['id_tutor'] ?? null,
                $data['id_role'],
                $idProfil,
            ]
        );
        return (int) $this->pdo->lastInsertId();
    }
}