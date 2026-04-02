<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Auth;
use App\Core\Database;


class HistoriqueController extends BaseController
{
    public function index(): void
    {
        $this->requirePermission('historique.view');

        $userId = Auth::id();
        $db     = Database::getInstance();

        $candidatures = $db->query('
            SELECT o.id_offer,
                   o.title          AS titre,
                   e.name           AS entreprise,
                   a.city           AS ville,
                   o.remuneration,
                   ap.statut        AS status,
                   o.publication_date AS date
            FROM apply ap
            JOIN "Offer"      o ON o.id_offer      = ap.id_offer
            JOIN "Entreprise" e ON e.id_entreprise = o.id_entreprise
            JOIN "Adress"     a ON a.id_adress     = e.id_adress
            WHERE ap.id_user = ?
            ORDER BY o.publication_date DESC
        ', [$userId])->fetchAll();

        $stats = [
            'total'    => count($candidatures),
            'pending'  => count(array_filter($candidatures, fn($c) => $c['status'] === 'pending')),
            'accepted' => count(array_filter($candidatures, fn($c) => $c['status'] === 'accepted')),
            'refused'  => count(array_filter($candidatures, fn($c) => $c['status'] === 'refused')),
        ];

        $this->render('dashboard/historique.html.twig', [
            'title'        => 'Mes candidatures — StageHub',
            'user'         => Auth::user(),
            'candidatures' => $candidatures,
            'stats'        => $stats,
        ]);
    }
}