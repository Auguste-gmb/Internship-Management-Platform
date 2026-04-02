<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Database;
use App\Model\Offre;

class DashboardController extends BaseController
{
    public function index(): void
    {
        $this->requireAuth();
        $userId = $_SESSION['user']['id'];
        $db     = Database::getInstance();

        // Candidatures avec statut
        $candidatures = $db->query('
            SELECT o.title AS titre, e.name AS entreprise,
                   a.city AS ville, ap.motivation_letter,
                   ap.statut,
                   o.publication_date AS date
            FROM apply ap
            JOIN "Offer" o       ON o.id_offer      = ap.id_offer
            JOIN "Entreprise" e  ON e.id_entreprise = o.id_entreprise
            JOIN "Adress" a      ON a.id_adress     = e.id_adress
            WHERE ap.id_user = ?
            ORDER BY o.publication_date DESC
        ', [$userId])->fetchAll();

        // Wishlist
        $wishlist = $db->query('
            SELECT o.id_offer, o.title AS titre, e.name AS entreprise,
                   o.remuneration AS salaire, a.city AS ville
            FROM wishlist w
            JOIN "Offer" o       ON o.id_offer      = w.id_offer
            JOIN "Entreprise" e  ON e.id_entreprise = o.id_entreprise
            JOIN "Adress" a      ON a.id_adress     = e.id_adress
            WHERE w.id_user = ?
        ', [$userId])->fetchAll();

        // Stats offres
        $offreModel = new Offre();
        $statsStatus = $db->query("
            SELECT
                COUNT(*) FILTER (WHERE ap.statut = 'accepted') AS acceptes,
                COUNT(*) FILTER (WHERE ap.statut = 'pending')  AS en_attente,
                COUNT(*) FILTER (WHERE ap.statut = 'refused')  AS refuses
            FROM apply ap
            WHERE ap.id_user = ?
        ", [$userId])->fetch();

        $stats = array_merge([
            'total_offres'     => $offreModel->count(),
            'avg_candidatures' => $offreModel->avgCandidatures(),
            'top_wishlist'     => $offreModel->topWishlist(3),
        ], $statsStatus);

        $this->render('dashboard/index.html.twig', [
            'title'        => 'Dashboard — StageHub',
            'user'         => $_SESSION['user'],
            'stats'        => $stats,
            'candidatures' => $candidatures,
            'wishlist'     => $wishlist,
        ]);
    }

    // Fonction générique pour les pages admin pour éviter répétition
    private function adminView(string $template): void
    {
        $this->requireAuth();
        $userId = $_SESSION['user']['id'];
        $db     = Database::getInstance();
        $offreModel = new Offre();

        $candidatures = $db->query('
            SELECT o.title AS titre, e.name AS entreprise,
                   a.city AS ville, ap.motivation_letter,
                   ap.statut,
                   o.publication_date AS date
            FROM apply ap
            JOIN "Offer" o       ON o.id_offer      = ap.id_offer
            JOIN "Entreprise" e  ON e.id_entreprise = o.id_entreprise
            JOIN "Adress" a      ON a.id_adress     = e.id_adress
            WHERE ap.id_user = ?
            ORDER BY o.publication_date DESC
        ', [$userId])->fetchAll();

        $wishlist = $db->query('
            SELECT o.id_offer, o.title AS titre, e.name AS entreprise,
                   o.remuneration AS salaire, a.city AS ville
            FROM wishlist w
            JOIN "Offer" o       ON o.id_offer      = w.id_offer
            JOIN "Entreprise" e  ON e.id_entreprise = o.id_entreprise
            JOIN "Adress" a      ON a.id_adress     = e.id_adress
            WHERE w.id_user = ?
        ', [$userId])->fetchAll();

        $this->render($template, [
            'title'        => 'Dashboard — StageHub',
            'user'         => $_SESSION['user'],
            'stats'        => [
                'total_offres'     => $offreModel->count(),
                'avg_candidatures' => $offreModel->avgCandidatures(),
                'top_wishlist'     => $offreModel->topWishlist(3),
            ],
            'candidatures' => $candidatures,
            'wishlist'     => $wishlist,
        ]);
    }

    public function admin(): void { $this->adminView('dashboard/admin-stats.html.twig'); }
    public function admin_users(): void { $this->adminView('dashboard/admin-users.html.twig'); }
    public function admin_entreprises(): void { $this->adminView('dashboard/admin-entreprises.html.twig'); }
    public function admin_offres(): void { $this->adminView('dashboard/admin-offres.html.twig'); }
}