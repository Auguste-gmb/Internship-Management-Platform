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
        int    $domainId = 0,
        int    $limit    = 10,
        int    $offset   = 0
    ): array {
        [$sql, $params] = $this->buildWhereClause($search,$duration,$remuMax,$domainId,$loc,false);
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
        [$sql, $params] = $this->buildWhereClause($search,$duration,$remuMax,0,'',true);
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
            // Requête SQL avec majuscule car PostgreSQL sensible à la casse
            $sql = 'SELECT id_domain, label FROM "Domain" ORDER BY label';
            
            // Exécution de la requête
            $stmt = $this->query($sql); // renvoie un PDOStatement
            
            // Récupération de tous les résultats sous forme de tableau associatif
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // En cas d'erreur, on peut loguer $e->getMessage() ou retourner un tableau vide
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
        int    $domainId = 0,
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
                    o.level, o.type, d.label AS domain, a.city AS location
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

        if ($domainId > 0) {
            $sql .= ' AND o.id_domain = ?';
            $params[] = $domainId;
        }

        if ($loc !== '') {
            $sql .= ' AND a.city ILIKE ?';
            $params[] = '%' . $loc . '%';
        }

        return [$sql, $params];
    }
}