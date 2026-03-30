<?php
declare(strict_types=1);

namespace App\Model;

use App\Core\Model;

class Entreprise extends Model
{
    public function getAll(string $search = ''): array
    {
        $sql = '
            SELECT e.id_entreprise, e.name, e.description, e.email,
                a.city AS ville, a.region,
                COUNT(DISTINCT o.id_offer) AS nb_offres,
                ROUND(AVG(g.note), 1)      AS note_moyenne
            FROM Entreprise e
            JOIN Adress a      ON a.id_adress     = e.id_adress
            LEFT JOIN Offer o  ON o.id_entreprise = e.id_entreprise
            LEFT JOIN grade g  ON g.id_entreprise = e.id_entreprise
            WHERE 1=1
        ';
        $params = [];

        if ($search !== '') {
            $sql .= ' AND (e.name LIKE ? OR e.description LIKE ?)';
            $p = '%' . $search . '%';
            $params = [$p, $p];
        }

        $sql .= ' GROUP BY e.id_entreprise ORDER BY e.name';

        return $this->query($sql, $params)->fetchAll();
    }

    public function getById(string $id): ?array
    {
        $row = $this->query('
            SELECT e.*, a.city AS ville, a.street_number, a.street_name, a.region,
                   ROUND(AVG(g.note), 1) AS note_moyenne,
                   COUNT(DISTINCT g.id_user) AS nb_avis
            FROM Entreprise e
            JOIN Adress a    ON a.id_adress      = e.id_adress
            LEFT JOIN grade g ON g.id_entreprise = e.id_entreprise
            WHERE e.id_entreprise = ?
            GROUP BY e.id_entreprise
            LIMIT 1
        ', [$id])->fetch();

        return $row ?: null;
    }

    public function count(): int
    {
        return (int) $this->query('SELECT COUNT(*) FROM Entreprise')->fetchColumn();
    }
}