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

        // Candidatures de l'étudiant
        $candidatures = $db->query('
            SELECT o.title AS titre, e.name AS entreprise,
                a.city AS ville, ap.motivation_letter,
                o.publication_date AS date
            FROM apply ap
            JOIN "Offer" o       ON o.id_offer      = ap.id_offer
            JOIN "Entreprise" e  ON e.id_entreprise = o.id_entreprise
            JOIN "Adress" a      ON a.id_adress     = e.id_adress
            WHERE ap.id_user = ?
            ORDER BY o.publication_date DESC
        ', [$userId])->fetchAll();

        // Wishlist de l'étudiant
        $wishlist = $db->query('
            SELECT o.id_offer, o.title AS titre, e.name AS entreprise,
                o.remuneration AS salaire, a.city AS ville
            FROM "wishlist" w
            JOIN "Offer" o       ON o.id_offer      = w.id_offer
            JOIN "Entreprise" e  ON e.id_entreprise = o.id_entreprise
            JOIN "Adress" a      ON a.id_adress     = e.id_adress
            WHERE w.id_user = ?
        ', [$userId])->fetchAll();
        // Stats offres (pour les tueurs/admins)
        $offreModel = new Offre();

        $this->render('dashboard/index.html.twig', [
            'title'        => 'Dashboard — StageHub',
            'user'         => $_SESSION['user'],
            'stats'        => [
                'total_offres'    => $offreModel->count(),
                'avg_candidatures'=> $offreModel->avgCandidatures(),
                'top_wishlist'    => $offreModel->topWishlist(3),
            ],
            'candidatures' => $candidatures,
            'wishlist'     => $wishlist,
        ]);
    }


    public function admin(): void
    {
        $this->requireAuth();

        $userId = $_SESSION['user']['id'];
        $db     = Database::getInstance();

        // Candidatures de l'étudiant
        $candidatures = $db->query('
            SELECT o.title AS titre, e.name AS entreprise,
                a.city AS ville, ap.motivation_letter,
                o.publication_date AS date
            FROM apply ap
            JOIN Offer o      ON o.id_offer      = ap.id_offer
            JOIN Entreprise e ON e.id_entreprise = o.id_entreprise
            JOIN Adress a     ON a.id_adress     = e.id_adress
            WHERE ap.id_user = ?
            ORDER BY o.publication_date DESC
        ', [$userId])->fetchAll();

        // Wishlist de l'étudiant
        $wishlist = $db->query('
            SELECT o.id_offer, o.title AS titre, e.name AS entreprise,
                o.remuneration AS salaire, a.city AS ville
            FROM whishlist w
            JOIN Offer o      ON o.id_offer      = w.id_offer
            JOIN Entreprise e ON e.id_entreprise = o.id_entreprise
            JOIN Adress a     ON a.id_adress     = e.id_adress
            WHERE w.id_user = ?
        ', [$userId])->fetchAll();
        // Stats offres (pour les tueurs/admins)
        $offreModel = new Offre();

        $this->render('dashboard/admin-stats.html.twig', [
            'title'        => 'Dashboard — StageHub',
            'user'         => $_SESSION['user'],
            'stats'        => [
                'total_offres'    => $offreModel->count(),
                'avg_candidatures'=> $offreModel->avgCandidatures(),
                'top_wishlist'    => $offreModel->topWishlist(3),
            ],
            'candidatures' => $candidatures,
            'wishlist'     => $wishlist,
        ]);
    }

        public function admin_users(): void
    {
        $this->requireAuth();

        $userId = $_SESSION['user']['id'];
        $db     = Database::getInstance();

        // Candidatures de l'étudiant
        $candidatures = $db->query('
            SELECT o.title AS titre, e.name AS entreprise,
                a.city AS ville, ap.motivation_letter,
                o.publication_date AS date
            FROM apply ap
            JOIN Offer o      ON o.id_offer      = ap.id_offer
            JOIN Entreprise e ON e.id_entreprise = o.id_entreprise
            JOIN Adress a     ON a.id_adress     = e.id_adress
            WHERE ap.id_user = ?
            ORDER BY o.publication_date DESC
        ', [$userId])->fetchAll();

        // Wishlist de l'étudiant
        $wishlist = $db->query('
            SELECT o.id_offer, o.title AS titre, e.name AS entreprise,
                o.remuneration AS salaire, a.city AS ville
            FROM whishlist w
            JOIN Offer o      ON o.id_offer      = w.id_offer
            JOIN Entreprise e ON e.id_entreprise = o.id_entreprise
            JOIN Adress a     ON a.id_adress     = e.id_adress
            WHERE w.id_user = ?
        ', [$userId])->fetchAll();
        // Stats offres (pour les tueurs/admins)
        $offreModel = new Offre();

        $this->render('dashboard/admin-users.html.twig', [
            'title'        => 'Dashboard — StageHub',
            'user'         => $_SESSION['user'],
            'stats'        => [
                'total_offres'    => $offreModel->count(),
                'avg_candidatures'=> $offreModel->avgCandidatures(),
                'top_wishlist'    => $offreModel->topWishlist(3),
            ],
            'candidatures' => $candidatures,
            'wishlist'     => $wishlist,
        ]);
    }

    
        public function admin_entreprises(): void
    {
        $this->requireAuth();

        $userId = $_SESSION['user']['id'];
        $db     = Database::getInstance();

        // Candidatures de l'étudiant
        $candidatures = $db->query('
            SELECT o.title AS titre, e.name AS entreprise,
                a.city AS ville, ap.motivation_letter,
                o.publication_date AS date
            FROM apply ap
            JOIN Offer o      ON o.id_offer      = ap.id_offer
            JOIN Entreprise e ON e.id_entreprise = o.id_entreprise
            JOIN Adress a     ON a.id_adress     = e.id_adress
            WHERE ap.id_user = ?
            ORDER BY o.publication_date DESC
        ', [$userId])->fetchAll();

        // Wishlist de l'étudiant
        $wishlist = $db->query('
            SELECT o.id_offer, o.title AS titre, e.name AS entreprise,
                o.remuneration AS salaire, a.city AS ville
            FROM whishlist w
            JOIN Offer o      ON o.id_offer      = w.id_offer
            JOIN Entreprise e ON e.id_entreprise = o.id_entreprise
            JOIN Adress a     ON a.id_adress     = e.id_adress
            WHERE w.id_user = ?
        ', [$userId])->fetchAll();
        // Stats offres (pour les tueurs/admins)
        $offreModel = new Offre();

        $this->render('dashboard/admin-entreprises.html.twig', [
            'title'        => 'Dashboard — StageHub',
            'user'         => $_SESSION['user'],
            'stats'        => [
                'total_offres'    => $offreModel->count(),
                'avg_candidatures'=> $offreModel->avgCandidatures(),
                'top_wishlist'    => $offreModel->topWishlist(3),
            ],
            'candidatures' => $candidatures,
            'wishlist'     => $wishlist,
        ]);
    }


    
        public function admin_offres(): void
    {
        $this->requireAuth();

        $userId = $_SESSION['user']['id'];
        $db     = Database::getInstance();

        // Candidatures de l'étudiant
        $candidatures = $db->query('
            SELECT o.title AS titre, e.name AS entreprise,
                a.city AS ville, ap.motivation_letter,
                o.publication_date AS date
            FROM apply ap
            JOIN Offer o      ON o.id_offer      = ap.id_offer
            JOIN Entreprise e ON e.id_entreprise = o.id_entreprise
            JOIN Adress a     ON a.id_adress     = e.id_adress
            WHERE ap.id_user = ?
            ORDER BY o.publication_date DESC
        ', [$userId])->fetchAll();

        // Wishlist de l'étudiant
        $wishlist = $db->query('
            SELECT o.id_offer, o.title AS titre, e.name AS entreprise,
                o.remuneration AS salaire, a.city AS ville
            FROM whishlist w
            JOIN Offer o      ON o.id_offer      = w.id_offer
            JOIN Entreprise e ON e.id_entreprise = o.id_entreprise
            JOIN Adress a     ON a.id_adress     = e.id_adress
            WHERE w.id_user = ?
        ', [$userId])->fetchAll();
        // Stats offres (pour les tueurs/admins)
        $offreModel = new Offre();

        $this->render('dashboard/admin-offres.html.twig', [
            'title'        => 'Dashboard — StageHub',
            'user'         => $_SESSION['user'],
            'stats'        => [
                'total_offres'    => $offreModel->count(),
                'avg_candidatures'=> $offreModel->avgCandidatures(),
                'top_wishlist'    => $offreModel->topWishlist(3),
            ],
            'candidatures' => $candidatures,
            'wishlist'     => $wishlist,
        ]);
    }
}
