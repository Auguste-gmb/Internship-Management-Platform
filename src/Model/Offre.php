<?php
declare(strict_types=1);

namespace App\Model;

use App\Core\Model;

class Offre extends Model
{
    public function getAll(string $search = '', string $loc = ''): array
    {
        $sql = '
            SELECT o.id_offer, o.title, o.description, o.duration,
                o.remuneration, o.publication_date, o.skill,
                e.name AS entreprise, a.city AS ville
            FROM Offer o
            JOIN Entreprise e ON e.id_entreprise = o.id_entreprise
            JOIN Adress a     ON a.id_adress      = e.id_adress
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

        $sql .= ' ORDER BY o.publication_date DESC';

        return $this->query($sql, $params)->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $row = $this->query('
            SELECT o.*, e.name AS entreprise, e.email AS entreprise_email,
                a.city AS ville, a.street_name, a.region
            FROM Offer o
            JOIN Entreprise e ON e.id_entreprise = o.id_entreprise
            JOIN Adress a     ON a.id_adress      = e.id_adress
            WHERE o.id_offer = ?
            LIMIT 1
        ', [$id])->fetch();
        return $row ?: null;
    }

    public function count(): int
    {
        return (int) $this->query('SELECT COUNT(*) FROM Offer')->fetchColumn();
    }

    public function topWishlist(int $limit = 5): array
    {
        return $this->query('
            SELECT o.id_offer, o.title, e.name AS entreprise,
                COUNT(w.id_user) AS nb_wishlist
            FROM Offer o
            JOIN Entreprise e ON e.id_entreprise = o.id_entreprise
            LEFT JOIN whishlist w ON w.id_offer  = o.id_offer
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
}