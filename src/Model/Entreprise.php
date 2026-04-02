<?php
declare(strict_types=1);

namespace App\Model;

use App\Core\Database;
use App\Core\Model;


class Entreprise extends Model
{

    public function getAll(
        string $search      = '',
        int    $noteMin     = 0,
        string $offresRange = '',
        array  $domainIds   = [],
        int    $limit       = 12,
        int    $offset      = 0
    ): array {
        [$sql, $params] = $this->buildQuery($search, $noteMin, $offresRange, $domainIds);
        $sql     .= ' ORDER BY e.name LIMIT ? OFFSET ?';
        $params[] = $limit;
        $params[] = $offset;

        return $this->fetchAll($sql, $params);
    }

    public function countFiltered(
        string $search      = '',
        int    $noteMin     = 0,
        string $offresRange = '',
        array  $domainIds   = []
    ): int {
        [$sql, $params] = $this->buildQuery($search, $noteMin, $offresRange, $domainIds, true);
        return (int) $this->fetchColumn($sql, $params);
    }

    public function count(): int
    {
        return $this->countFiltered();
    }

    public function getById(string $id): ?array
    {
        return $this->fetchOne('
            SELECT e.*, a.city AS ville, a.street_number, a.street_name, a.region,
                   ROUND(AVG(g.note), 1)       AS note_moyenne,
                   COUNT(DISTINCT g.id_user)   AS nb_avis,
                   COUNT(DISTINCT o.id_offer)  AS nb_offres
            FROM "Entreprise" e
            JOIN "Adress"  a ON a.id_adress     = e.id_adress
            LEFT JOIN "grade" g ON g.id_entreprise = e.id_entreprise
            LEFT JOIN "Offer" o ON o.id_entreprise = e.id_entreprise
            WHERE e.id_entreprise = ?
            GROUP BY e.id_entreprise, a.city, a.street_number, a.street_name, a.region
            LIMIT 1
        ', [$id]);
    }

    public function getAllDomains(): array
    {
        return $this->fetchAll('SELECT id_domain, name FROM "Domain" ORDER BY name');
    }


    public function create(array $data): int
    {
        $db  = Database::getInstance();
        $pdo = $db->getPdo();

        $pdo->beginTransaction();
        try {
            $db->query('
                INSERT INTO "Adress" (city, street_number, street_name, region)
                VALUES (?, ?, ?, ?)
            ', [
                $data['city'],
                $data['street_number'] ?: null,
                $data['street_name']   ?: null,
                $data['region']        ?: null,
            ]);
            $idAdress = (int) $pdo->lastInsertId('adress_id_adress_seq');

            $db->query('
                INSERT INTO "Entreprise" (name, description, email, id_adress, id_domain)
                VALUES (?, ?, ?, ?, ?)
            ', [
                $data['name'],
                $data['description'] ?: null,
                $data['email']       ?: null,
                $idAdress,
                $data['id_domain']   ?: null,
            ]);
            $idEntreprise = (int) $pdo->lastInsertId('entreprise_id_entreprise_seq');

            $pdo->commit();
            return $idEntreprise;

        } catch (\Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public function update(int $id, array $data): void
    {
        $db  = Database::getInstance();
        $row = $this->fetchOne('SELECT id_adress FROM "Entreprise" WHERE id_entreprise = ?', [$id]);

        if (!$row) {
            return;
        }

        $db->query('
            UPDATE "Adress"
            SET city = ?, street_number = ?, street_name = ?, region = ?
            WHERE id_adress = ?
        ', [
            $data['city'],
            $data['street_number'] ?: null,
            $data['street_name']   ?: null,
            $data['region']        ?: null,
            $row['id_adress'],
        ]);

        $db->query('
            UPDATE "Entreprise"
            SET name = ?, description = ?, email = ?, id_domain = ?
            WHERE id_entreprise = ?
        ', [
            $data['name'],
            $data['description'] ?: null,
            $data['email']       ?: null,
            $data['id_domain']   ?: null,
            $id,
        ]);
    }

    public function delete(int $id): void
    {
        $db  = Database::getInstance();
        $pdo = $db->getPdo();

        $row = $this->fetchOne('SELECT id_adress FROM "Entreprise" WHERE id_entreprise = ?', [$id]);

        $pdo->beginTransaction();
        try {
            $db->query('DELETE FROM "grade"    WHERE id_entreprise = ?', [$id]);
            $db->query('DELETE FROM "apply"    WHERE id_offer IN (
                SELECT id_offer FROM "Offer" WHERE id_entreprise = ?
            )', [$id]);
            $db->query('DELETE FROM "wishlist" WHERE id_offer IN (
                SELECT id_offer FROM "Offer" WHERE id_entreprise = ?
            )', [$id]);
            $db->query('DELETE FROM "Offer"      WHERE id_entreprise = ?', [$id]);
            $db->query('DELETE FROM "Entreprise" WHERE id_entreprise = ?', [$id]);

            if ($row) {
                $db->query('DELETE FROM "Adress" WHERE id_adress = ?', [$row['id_adress']]);
            }

            $pdo->commit();
        } catch (\Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }


    private function buildQuery(
        string $search      = '',
        int    $noteMin     = 0,
        string $offresRange = '',
        array  $domainIds   = [],
        bool   $count       = false
    ): array {
        if ($count) {
            $sql = 'SELECT COUNT(DISTINCT e.id_entreprise) FROM "Entreprise" e';
        } else {
            $sql = '
                SELECT e.id_entreprise, e.name, e.description,
                       a.city AS ville, a.region,
                       COUNT(DISTINCT o.id_offer) AS nb_offres,
                       ROUND(AVG(g.note), 1)      AS note_moyenne,
                       d.name                     AS domain
                FROM "Entreprise" e
                LEFT JOIN "Domain" d ON d.id_domain = e.id_domain
            ';
        }

        $sql .= '
            JOIN "Adress"  a ON a.id_adress     = e.id_adress
            LEFT JOIN "Offer" o ON o.id_entreprise = e.id_entreprise
            LEFT JOIN "grade" g ON g.id_entreprise = e.id_entreprise
            WHERE 1=1
        ';

        $params = [];

        if ($search !== '') {
            $sql     .= ' AND (e.name LIKE ? OR e.description LIKE ?)';
            $p        = '%' . $search . '%';
            $params[] = $p;
            $params[] = $p;
        }

        if (!empty($domainIds)) {
            $sql    .= ' AND e.id_domain IN (' . $this->placeholders($domainIds) . ')';
            $params  = array_merge($params, $domainIds);
        }

        if (!$count) {
            $sql .= ' GROUP BY e.id_entreprise, e.name, e.description, a.city, a.region, d.name';
        }

        $having = [];
        if ($noteMin > 0) {
            $having[] = 'ROUND(AVG(g.note), 1) >= ?';
            $params[] = $noteMin;
        }

        if ($offresRange !== '') {
            $having[] = match ($offresRange) {
                '1-5'  => 'COUNT(DISTINCT o.id_offer) BETWEEN 1 AND 5',
                '6-10' => 'COUNT(DISTINCT o.id_offer) BETWEEN 6 AND 10',
                '10+'  => 'COUNT(DISTINCT o.id_offer) > 10',
                default => null,
            };
            $having = array_filter($having);
        }

        if (!$count && !empty($having)) {
            $sql .= ' HAVING ' . implode(' AND ', $having);
        }

        return [$sql, $params];
    }
}