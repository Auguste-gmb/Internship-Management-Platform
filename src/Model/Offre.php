<?php
declare(strict_types=1);
namespace App\Model;

use App\Core\Model;

use App\Core\Database;
use PDO;
use PDOException;

class Offre extends Model
{

    public function getAll(
        string $search   = '',
        string $loc      = '',
        string $duration = '',
        int    $remuMax  = 0,
        array  $domainIds = [],
        int    $limit    = 12,
        int    $offset   = 0
    ): array {
        [$sql, $params] = $this->buildWhereClause($search, $duration, $remuMax, $domainIds, $loc);

        // Pagination
        $sql .= ' ORDER BY o.publication_date DESC LIMIT ? OFFSET ?';
        $params[] = $limit;
        $params[] = $offset;

        return Database::getInstance()->query($sql, $params)->fetchAll();
    }


    public function countFiltered(
        string $search   = '',
        string $loc      = '',
        string $duration = '',
        int    $remuMax  = 0,
        array  $domainIds = []  // <- changer en tableau
    ): int {
        [$sql, $params] = $this->buildWhereClause($search, $duration, $remuMax, $domainIds, $loc, true);
        return (int) $this->query($sql, $params)->fetchColumn();
    }


    public function count(): int
    {
        return (int) $this->query('SELECT COUNT(*) FROM "Offer"')->fetchColumn();
    }


    public function getById(int $id): ?array
    {
        $row = $this->query('
            SELECT o.*
            FROM "Offer" o
            WHERE o.id_offer = ?
            LIMIT 1
        ', [$id])->fetch();
        return $row ?: null;
    }




    public function getDomaines(): array
    {
        try {
            // Requête SQL pour récupérer les domaines + nombre d'offres dans chaque domaine
            $sql = '
                SELECT d.id_domain,
                    d.name,
                    COUNT(o.id_offer) AS count
                FROM "Domain" d
                LEFT JOIN "Offer" o ON o.id_domain = d.id_domain
                GROUP BY d.id_domain, d.name
                ORDER BY d.name
            ';

            $stmt = $this->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }



    public function topWishlist(int $limit = 5): array
    {
        return $this->query('
            SELECT o.id_offer, o.title,
                   COUNT(w.id_user) AS nb_wishlist
            FROM "Offer" o
            LEFT JOIN "wishlist" w ON w.id_offer = o.id_offer
            GROUP BY o.id_offer, o.title
            ORDER BY nb_wishlist DESC
            LIMIT ?
        ', [$limit])->fetchAll();
    }



    public function avgCandidatures(): float
    {
        $val = $this->query('
            SELECT AVG(nb) FROM (
                SELECT COUNT(*) AS nb FROM "apply" GROUP BY id_offer
            ) AS sub
        ')->fetchColumn();
        return round((float)($val ?? 0), 1);
    }



    private function buildWhereClause(
        string $search,
        string $duration = '',
        int    $remuMax  = 0,
        array  $domainIds = [], // <- accepter tableau
        string $loc      = '',
        bool   $count    = false
    ): array {
        $select = $count
            ? 'SELECT COUNT(*) FROM "Offer" o
            LEFT JOIN "Domain" d ON o.id_domain = d.id_domain
            LEFT JOIN "Entreprise" e ON o.id_entreprise = e.id_entreprise
            LEFT JOIN "Adress" a ON e.id_adress = a.id_adress'
            : 'SELECT o.id_offer, o.title, o.description, o.duration,
            o.remuneration, o.publication_date, o.skill,
            o.level, o.type, d.name AS domain, a.city AS location
            FROM "Offer" o
            LEFT JOIN "Domain" d ON o.id_domain = d.id_domain
            LEFT JOIN "Entreprise" e ON o.id_entreprise = e.id_entreprise
            LEFT JOIN "Adress" a ON e.id_adress = a.id_adress';

        $sql = $select . ' WHERE 1=1 ';
        $params = [];

        if ($search !== '') {
            $sql .= ' AND (o.title ILIKE ? OR o.skill ILIKE ?)';
            $p = '%' . $search . '%';
            $params = array_merge($params, [$p, $p]);
        }

        if ($duration !== '') {
            $sql .= ' AND o.duration = ?';
            $params[] = $duration;
        }

        if ($remuMax > 0) {
            $sql .= " AND CAST(REGEXP_REPLACE(o.remuneration, '[^0-9]', '', 'g') AS INTEGER) <= ?";
            $params[] = $remuMax;
        }

        if (!empty($domainIds)) {
            $placeholders = implode(',', array_fill(0, count($domainIds), '?'));
            $sql .= " AND o.id_domain IN ($placeholders)";
            $params = array_merge($params, $domainIds);
        }

        if ($loc !== '') {
            $sql .= ' AND a.city ILIKE ?';
            $params[] = '%' . $loc . '%';
        }

        return [$sql, $params];
    }


    public function topOffres(int $limit = 5): array
    {
        $db = \App\Core\Database::getInstance();

        return $db->query('
            SELECT o.title AS titre,
                e.name AS entreprise,
                d.name AS domaine,
                o.remuneration,
                COUNT(ap.id_offer) AS candidatures
            FROM "Offer" o
            JOIN "Entreprise" e ON e.id_entreprise = o.id_entreprise
            LEFT JOIN "Domain" d ON o.id_domain = d.id_domain
            LEFT JOIN apply ap ON ap.id_offer = o.id_offer
            GROUP BY o.id_offer, e.name, d.name, o.remuneration
            ORDER BY candidatures DESC
            LIMIT ?
        ', [$limit])->fetchAll();
    }

public function create(array $data): int
{
    $db  = Database::getInstance();
    $pdo = $db->getPdo();

    $pdo->beginTransaction();
    try {
        $db->query('
            INSERT INTO "Offer" (title, description, skill, duration, remuneration, level, type, id_domain, id_entreprise)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ', [
            $data['title'],
            $data['description'] ?: null,
            $data['skill']       ?: null,
            $data['duration']    ?: null,
            $data['remuneration'] ?: null,
            $data['level']       ?: null,
            $data['type']        ?: null,
            $data['id_domain']   ?: null,
            $data['id_entreprise'] ?: null,
        ]);
        $id = (int) $pdo->lastInsertId('offer_id_offer_seq');
        $pdo->commit();
        return $id;
    } catch (\Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}

public function update(int $id, array $data): void
{
    Database::getInstance()->query('
        UPDATE "Offer"
        SET title = ?, description = ?, skill = ?, duration = ?,
            remuneration = ?, level = ?, type = ?, id_domain = ?, id_entreprise = ?
        WHERE id_offer = ?
    ', [
        $data['title'],
        $data['description']   ?: null,
        $data['skill']         ?: null,
        $data['duration']      ?: null,
        $data['remuneration']  ?: null,
        $data['level']         ?: null,
        $data['type']          ?: null,
        $data['id_domain']     ?: null,
        $data['id_entreprise'] ?: null,
        $id,
    ]);
}

public function delete(int $id): void
{
    $db  = Database::getInstance();
    $pdo = $db->getPdo();
    $pdo->beginTransaction();
    try {
        $db->query('DELETE FROM "apply"    WHERE id_offer = ?', [$id]);
        $db->query('DELETE FROM "wishlist" WHERE id_offer = ?', [$id]);
        $db->query('DELETE FROM "Offer"    WHERE id_offer = ?', [$id]);
        $pdo->commit();
    } catch (\Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}

public function getAllEntreprises(): array
{
    return $this->query('SELECT id_entreprise, name FROM "Entreprise" ORDER BY name')->fetchAll();
}
}