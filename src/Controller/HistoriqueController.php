<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Database;

class HistoriqueController extends BaseController
{
    public function index(): void
    {
        $this->requireAuth();
        
        $userId = $_SESSION['user']['id'];
        $db = Database::getInstance();
        
        $candidatures = $db->query('
            SELECT ap.id_apply, o.id_offer, o.title AS titre, 
                   e.name AS entreprise, a.city AS ville,
                   o.remuneration, ap.apply_date AS date,
                   "pending" AS status
            FROM apply ap
            JOIN Offer o      ON o.id_offer      = ap.id_offer
            JOIN Entreprise e ON e.id_entreprise = o.id_entreprise
            JOIN Adress a     ON a.id_adress     = e.id_adress
            WHERE ap.id_user = ?
            ORDER BY ap.apply_date DESC
        ', [$userId])->fetchAll();
        
        $stats = [
            'total'    => count($candidatures),
            'pending'  => count(array_filter($candidatures, fn($c) => $c['status'] === 'pending')),
            'accepted' => 0,
            'refused'  => 0,
        ];
        
        $this->render('dashboard/historique.html.twig', [
            'title'        => 'Mes candidatures — StageHub',
            'candidatures' => $candidatures,
            'stats'        => $stats,
        ]);
    }
}