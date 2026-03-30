<?php
declare(strict_types=1);

namespace App\Model;

use App\Core\Model;

class Offre extends Model
{
    public function getAll(
        string $search   = '',
        string $loc      = '',
        string $duration = '',
        int    $remuMax  = 0,
        int    $domainId = 0,
        int    $limit    = 10,
        int    $offset   = 0
    ): array {
        [$sql, $params] = $this->buildWhereClause($search, $loc, $duration, $remuMax, $domainId);
        $sql .= ' ORDER BY o.publication_date DESC LIMIT ? OFFSET ?';
        $params[] = $limit;
        $params[] = $offset;
        return $this->query($sql, $params)->fetchAll();
    }

    public function countFiltered(
        string $search   = '',
        string $loc      = '',
        string $duration = '',
        int    $remuMax  = 0,
        int    $domainId = 0
    ): int {
        [$sql, $params] = $this->buildWhereClause($search, $loc, $duration, $remuMax, $domainId, true);
        return (int) $this->query($sql, $params)->fetchColumn();
    }

    public function count(): int
    {
        return (int) $this->query('SELECT COUNT(*) FROM Offer')->fetchColumn();
    }

    public function getById(int $id): ?array
    {
        $row = $this->query('
            SELECT o.*, e.name AS entreprise, e.email AS entreprise_email,
                   a.city AS ville, a.street_name, a.region,
                   d.label AS domaine
            FROM Offer o
            JOIN Entreprise e  ON e.id_entreprise = o.id_entreprise
            JOIN Adress a      ON a.id_adress      = e.id_adress
            LEFT JOIN Domain d ON d.id_domain      = o.id_domain
            WHERE o.id_offer = ?
            LIMIT 1
        ', [$id])->fetch();

        return $row ?: null;
    }

    public function getDomaines(): array
    {
        return $this->query('
            SELECT d.id_domain, d.label,
                   COUNT(o.id_offer) AS count
            FROM Domain d
            LEFT JOIN Offer o ON o.id_domain = d.id_domain
            GROUP BY d.id_domain
            ORDER BY d.label
        ')->fetchAll();
    }

    public function topWishlist(int $limit = 5): array
    {
        return $this->query('
            SELECT o.id_offer, o.title, e.name AS entreprise,
                   COUNT(w.id_user) AS nb_wishlist
            FROM Offer o
            JOIN Entreprise e     ON e.id_entreprise = o.id_entreprise
            LEFT JOIN whishlist w ON w.id_offer      = o.id_offer
            GROUP BY o.id_offer, o.title, e.name
            ORDER BY nb_wishlist DESC
            LIMIT ?
        ', [$limit])->fetchAll();
    }

    public function avgCandidatures(): float
    {
        $val = $this->query('
            SELECT AVG(nb) FROM (
                SELECT COUNT(*) AS nb FROM apply GROUP BY id_offer
            ) AS sub
        ')->fetchColumn();

        return round((float)($val ?? 0), 1);
    }

    private function buildWhereClause(
        string $search,
        string $loc,
        string $duration = '',
        int    $remuMax  = 0,
        int    $domainId = 0,
        bool   $count    = false
    ): array {
        $select = $count
            ? 'SELECT COUNT(*) FROM Offer o'
            : 'SELECT o.id_offer, o.title, o.description, o.duration,
                      o.remuneration, o.publication_date, o.skill,
                      e.name AS entreprise, a.city AS ville,
                      d.label AS domaine
               FROM Offer o';

        $sql = $select . '
            JOIN Entreprise e  ON e.id_entreprise = o.id_entreprise
            JOIN Adress a      ON a.id_adress      = e.id_adress
            LEFT JOIN Domain d ON d.id_domain      = o.id_domain
            WHERE 1=1
        ';
        $params = [];

        if ($search !== '') {
            $sql .= ' AND (o.title LIKE ? OR o.skill LIKE ? OR e.name LIKE ?)';
            $p = '%' . $search . '%';
            $params = array_merge($params, [$p, $p, $p]);
        }
        if ($loc !== '') {
            $sql .= ' AND a.city LIKE ?';
            $params[] = '%' . $loc . '%';
        }
        if ($duration !== '') {
            $sql .= ' AND o.duration = ?';
            $params[] = $duration;
        }
        if ($remuMax > 0) {
            $sql .= ' AND CAST(REPLACE(REPLACE(o.remuneration, "€", ""), " ", "") AS UNSIGNED) <= ?';
            $params[] = $remuMax;
        }
        if ($domainId > 0) {
            $sql .= ' AND o.id_domain = ?';
            $params[] = $domainId;
        }

        return [$sql, $params];
    }
}