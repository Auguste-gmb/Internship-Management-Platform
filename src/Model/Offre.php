<?php
declare(strict_types=1);

namespace App\Model;

use App\Core\Model;
use PDO;


class Offre extends Model
{

    public function getAll(
        string $search    = '',
        string $loc       = '',
        string $duration  = '',
        int    $remuMax   = 0,
        array  $domainIds = [],
        int    $limit     = 12,
        int    $offset    = 0
    ): array {
        [$sql, $params] = $this->buildQuery($search, $loc, $duration, $remuMax, $domainIds);
        $sql      .= ' ORDER BY o.publication_date DESC LIMIT ? OFFSET ?';
        $params[]  = $limit;
        $params[]  = $offset;

        return $this->fetchAll($sql, $params);
    }

    public function countFiltered(
        string $search    = '',
        string $loc       = '',
        string $duration  = '',
        int    $remuMax   = 0,
        array  $domainIds = []
    ): int {
        [$sql, $params] = $this->buildQuery($search, $loc, $duration, $remuMax, $domainIds, true);
        return (int) $this->fetchColumn($sql, $params);
    }

    public function count(): int
    {
        return (int) $this->fetchColumn('SELECT COUNT(*) FROM "Offer"');
    }

    public function getById(int $id): ?array
    {
        return $this->fetchOne('
            SELECT o.*, d.name AS domain, e.name AS entreprise_name,
                   a.city AS location
            FROM "Offer"      o
            LEFT JOIN "Domain"     d ON d.id_domain     = o.id_domain
            LEFT JOIN "Entreprise" e ON e.id_entreprise = o.id_entreprise
            LEFT JOIN "Adress"     a ON a.id_adress     = e.id_adress
            WHERE o.id_offer = ?
            LIMIT 1
        ', [$id]);
    }


    public function getDomaines(): array
    {
        try {
            return $this->fetchAll('
                SELECT d.id_domain, d.name, COUNT(o.id_offer) AS count
                FROM "Domain" d
                LEFT JOIN "Offer" o ON o.id_domain = d.id_domain
                GROUP BY d.id_domain, d.name
                ORDER BY d.name
            ');
        } catch (\PDOException) {
            return [];
        }
    }

    public function topWishlist(int $limit = 5): array
    {
        return $this->fetchAll('
            SELECT o.id_offer, o.title, COUNT(w.id_user) AS nb_wishlist
            FROM "Offer" o
            LEFT JOIN "wishlist" w ON w.id_offer = o.id_offer
            GROUP BY o.id_offer, o.title
            ORDER BY nb_wishlist DESC
            LIMIT ?
        ', [$limit]);
    }

    public function topOffres(int $limit = 5): array
    {
        return $this->fetchAll('
            SELECT o.title        AS titre,
                   e.name         AS entreprise,
                   d.name         AS domaine,
                   o.remuneration,
                   COUNT(ap.id_offer) AS candidatures
            FROM "Offer"      o
            JOIN "Entreprise" e  ON e.id_entreprise = o.id_entreprise
            LEFT JOIN "Domain"   d  ON d.id_domain     = o.id_domain
            LEFT JOIN apply      ap ON ap.id_offer      = o.id_offer
            GROUP BY o.id_offer, e.name, d.name, o.remuneration
            ORDER BY candidatures DESC
            LIMIT ?
        ', [$limit]);
    }

    public function avgCandidatures(): float
    {
        $val = $this->fetchColumn('
            SELECT AVG(nb) FROM (
                SELECT COUNT(*) AS nb FROM "apply" GROUP BY id_offer
            ) AS sub
        ');
        return round((float) ($val ?? 0), 1);
    }


    private function buildQuery(
        string $search    = '',
        string $loc       = '',
        string $duration  = '',
        int    $remuMax   = 0,
        array  $domainIds = [],
        bool   $count     = false
    ): array {
        if ($count) {
            $sql = '
                SELECT COUNT(*)
                FROM "Offer" o
                LEFT JOIN "Domain"     d ON d.id_domain     = o.id_domain
                LEFT JOIN "Entreprise" e ON e.id_entreprise = o.id_entreprise
                LEFT JOIN "Adress"     a ON a.id_adress     = e.id_adress
            ';
        } else {
            $sql = '
                SELECT o.id_offer, o.title, o.description, o.duration,
                       o.remuneration, o.publication_date, o.skill,
                       o.level, o.type,
                       d.name AS domain,
                       a.city AS location
                FROM "Offer" o
                LEFT JOIN "Domain"     d ON d.id_domain     = o.id_domain
                LEFT JOIN "Entreprise" e ON e.id_entreprise = o.id_entreprise
                LEFT JOIN "Adress"     a ON a.id_adress     = e.id_adress
            ';
        }

        $sql    .= ' WHERE 1=1';
        $params  = [];

        if ($search !== '') {
            $sql     .= ' AND (o.title ILIKE ? OR o.skill ILIKE ?)';
            $p        = '%' . $search . '%';
            $params[] = $p;
            $params[] = $p;
        }

        if ($duration !== '') {
            $sql     .= ' AND o.duration = ?';
            $params[] = $duration;
        }

        if ($remuMax > 0) {
            $sql     .= " AND CAST(REGEXP_REPLACE(o.remuneration, '[^0-9]', '', 'g') AS INTEGER) <= ?";
            $params[] = $remuMax;
        }

        if (!empty($domainIds)) {
            $sql     .= ' AND o.id_domain IN (' . $this->placeholders($domainIds) . ')';
            $params   = array_merge($params, $domainIds);
        }

        if ($loc !== '') {
            $sql     .= ' AND a.city ILIKE ?';
            $params[] = '%' . $loc . '%';
        }

        return [$sql, $params];
    }
}