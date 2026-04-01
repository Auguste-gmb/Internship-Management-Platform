<?php
declare(strict_types=1);

namespace App\Model;

use App\Core\Model;

class Entreprise extends Model
{
    public function getAll(
        string $search     = '',
        int    $noteMin    = 0,
        string $offresRange = '',
        int    $limit      = 12,
        int    $offset     = 0
    ): array {
        [$sql, $params] = $this->buildWhereClause($search, $noteMin, $offresRange);
        $sql .= ' GROUP BY e.id_entreprise, e.name, e.description, e.email, a.city, a.region ORDER BY e.name LIMIT ? OFFSET ?';
        $params[] = $limit;
        $params[] = $offset;
        return $this->query($sql, $params)->fetchAll();
    }

    public function countFiltered(
        string $search      = '',
        int    $noteMin     = 0,
        string $offresRange = ''
    ): int {
        [$sql, $params] = $this->buildWhereClause($search, $noteMin, $offresRange, true);
        return (int) $this->query($sql, $params)->fetchColumn();
    }

    public function count(): int
    {
        return (int) $this->query('SELECT COUNT(*) FROM "Entreprise"')->fetchColumn();
    }

    public function getById(string $id): ?array
    {
        $row = $this->query('
            SELECT e.*, a.city AS ville, a.street_number, a.street_name, a.region,
                   ROUND(AVG(g.note), 1)      AS note_moyenne,
                   COUNT(DISTINCT g.id_user)  AS nb_avis,
                   COUNT(DISTINCT o.id_offer) AS nb_offres
            FROM "Entreprise" e
            JOIN "Adress" a     ON a.id_adress      = e.id_adress
            LEFT JOIN "grade" g ON g.id_entreprise  = e.id_entreprise
            LEFT JOIN "Offer" o ON o.id_entreprise  = e.id_entreprise
            WHERE e.id_entreprise = ?
            GROUP BY e.id_entreprise
            LIMIT 1
        ', [$id])->fetch();

        return $row ?: null;
    }

    private function buildWhereClause(
        string $search      = '',
        int    $noteMin     = 0,
        string $offresRange = '',
        bool   $count       = false
    ): array {
        $select = $count
            ? 'SELECT COUNT(DISTINCT e.id_entreprise) FROM "Entreprise" e'
            : 'SELECT e.id_entreprise, e.name, e.description, e.email,
                    a.city AS ville, a.region,
                    COUNT(DISTINCT o.id_offer) AS nb_offres,
                    ROUND(AVG(g.note), 1)      AS note_moyenne
            FROM "Entreprise" e';

        $sql = $select . '
            JOIN "Adress" a     ON a.id_adress      = e.id_adress
            LEFT JOIN "Offer" o ON o.id_entreprise  = e.id_entreprise
            LEFT JOIN "grade" g ON g.id_entreprise  = e.id_entreprise
            WHERE 1=1
        ';
        $params = [];

        if ($search !== '') {
            $sql .= ' AND (e.name LIKE ? OR e.description LIKE ?)';
            $p = '%' . $search . '%';
            $params[] = $p;
            $params[] = $p;
        }

        // Filtre note — utilise HAVING car c'est un agrégat
        $having = [];

        if ($noteMin > 0) {
            $having[] = 'ROUND(AVG(g.note), 1) >= ?';
            $params[]  = $noteMin;
        }

        if ($offresRange !== '') {
            switch ($offresRange) {
                case '1-5':
                    $having[] = 'COUNT(DISTINCT o.id_offer) BETWEEN 1 AND 5';
                    break;
                case '6-10':
                    $having[] = 'COUNT(DISTINCT o.id_offer) BETWEEN 6 AND 10';
                    break;
                case '10+':
                    $having[] = 'COUNT(DISTINCT o.id_offer) > 10';
                    break;
            }
        }

        if (!empty($having)) {
            $sql .= ' HAVING ' . implode(' AND ', $having);
        }

        return [$sql, $params];
    }
}