<?php
declare(strict_types=1);

namespace App\Model;

use App\Core\Model;


class User extends Model
{

    public function findByEmail(string $email): ?array
    {
        return $this->fetchOne('
            SELECT u.id_user, u.email, u.password, u.isactive,
                   p.first_name, p.name,
                   r.role_name
            FROM "User_" u
            JOIN "Profil" p ON p.id_profil = u.id_profil
            JOIN "Role"   r ON r.id_role   = u.id_role
            WHERE u.email = ? AND u.isactive = true
            LIMIT 1
        ', [$email]);
    }

    public function findById(int $id): ?array
    {
        return $this->fetchOne('
            SELECT u.id_user, u.email, u.password, u.isactive,
                   p.first_name, p.name,
                   r.role_name
            FROM "User_" u
            JOIN "Profil" p ON p.id_profil = u.id_profil
            JOIN "Role"   r ON r.id_role   = u.id_role
            WHERE u.id_user = ?
            LIMIT 1
        ', [$id]);
    }


    public function create(array $data): int
    {
        $pdo = $this->pdo;
        $pdo->beginTransaction();

        try {
            $this->query(
                'INSERT INTO "Profil" (first_name, name, creation_date) VALUES (?, ?, NOW())',
                [$data['first_name'], $data['name']]
            );
            $idProfil = (int) $pdo->lastInsertId('profil_id_profil_seq');

            if ($idProfil === 0) {
                throw new \RuntimeException('Échec création profil');
            }

            $this->query(
                'INSERT INTO "User_" (email, password, isactive, id_tutor, id_role, id_profil)
                 VALUES (?, ?, true, NULL, ?, ?)',
                [
                    $data['email'],
                    password_hash($data['password'], PASSWORD_BCRYPT),
                    $data['id_role'] ?? 1,
                    $idProfil,
                ]
            );

            $idUser = (int) $pdo->lastInsertId('user__id_user_seq');
            $pdo->commit();

            return $idUser;

        } catch (\Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }


    public function updateProfil(int $userId, array $data): void
    {
        $this->query('
            UPDATE "Profil" p
            SET first_name = ?, name = ?
            FROM "User_" u
            WHERE u.id_profil = p.id_profil
              AND u.id_user = ?
        ', [$data['prenom'], $data['nom'], $userId]);

        $this->query(
            'UPDATE "User_" SET email = ? WHERE id_user = ?',
            [$data['email'], $userId]
        );
    }

    public function updatePassword(int $userId, string $newPassword): void
    {
        $this->query(
            'UPDATE "User_" SET password = ? WHERE id_user = ?',
            [password_hash($newPassword, PASSWORD_BCRYPT), $userId]
        );
    }

    public function count(): int
    {
        return (int) $this->fetchColumn('SELECT COUNT(*) FROM "User_"');
    }

    public function countCandidatures(int $userId): int
    {
        return (int) $this->fetchColumn(
            'SELECT COUNT(*) FROM apply WHERE id_user = ?',
            [$userId]
        );
    }

    public function countWishlist(int $userId): int
    {
        return (int) $this->fetchColumn(
            'SELECT COUNT(*) FROM "wishlist" WHERE id_user = ?',
            [$userId]
        );
    }
}