<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Auth;
use App\Core\Database;
use App\Model\Offre;
use App\Model\User;




class DashboardController extends BaseController
{

    public function index(): void
    {
        $this->requirePermission('dashboard.view');

        if (Auth::hasRole(Auth::ROLE_ADMINISTRATOR)) {
            $this->adminStats();
            return;
        }

        $this->studentDashboard();
    }

 
    private function studentDashboard(): void
    {
        $userId = Auth::id();
        $db     = Database::getInstance();
        $offreModel = new Offre();

        $candidatures = $db->query('
            SELECT o.title AS titre, e.name AS entreprise,
                   a.city AS ville, ap.motivation_letter,
                   ap.statut,
                   o.publication_date AS date
            FROM apply ap
            JOIN "Offer"      o ON o.id_offer      = ap.id_offer
            JOIN "Entreprise" e ON e.id_entreprise = o.id_entreprise
            JOIN "Adress"     a ON a.id_adress     = e.id_adress
            WHERE ap.id_user = ?
            ORDER BY o.publication_date DESC
        ', [$userId])->fetchAll();

        $wishlist = $db->query('
            SELECT o.id_offer, o.title AS titre, e.name AS entreprise,
                   o.remuneration AS salaire, a.city AS ville
            FROM wishlist w
            JOIN "Offer"      o ON o.id_offer      = w.id_offer
            JOIN "Entreprise" e ON e.id_entreprise = o.id_entreprise
            JOIN "Adress"     a ON a.id_adress     = e.id_adress
            WHERE w.id_user = ?
        ', [$userId])->fetchAll();

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
            'user'         => Auth::user(),
            'stats'        => $stats,
            'candidatures' => $candidatures,
            'wishlist'     => $wishlist,
        ]);
    }


    public function adminStats(): void
    {
        $this->requirePermission('admin.dashboard');

        $db         = Database::getInstance();
        $offreModel = new Offre();

        $statsStatus = $db->query("
            SELECT
                COUNT(*) FILTER (WHERE ap.statut = 'accepted') AS acceptes,
                COUNT(*) FILTER (WHERE ap.statut = 'pending')  AS en_attente,
                COUNT(*) FILTER (WHERE ap.statut = 'refused')  AS refuses
            FROM apply ap
        ")->fetch();

        $acceptes   = (int) ($statsStatus['acceptes']   ?? 0);
        $en_attente = (int) ($statsStatus['en_attente'] ?? 0);
        $refuses    = (int) ($statsStatus['refuses']    ?? 0);
        $total      = $acceptes + $en_attente + $refuses;
        $circ       = 97.4;

        $stats = [
            'kpis' => [
                ['icon' => '✓',  'value' => $acceptes,           'label' => 'Acceptés',   'color' => 'green'],
                ['icon' => '⏳', 'value' => $en_attente,         'label' => 'En attente', 'color' => 'yellow'],
                ['icon' => '✕',  'value' => $refuses,            'label' => 'Refusés',    'color' => 'red'],
                ['icon' => '🏢', 'value' => $offreModel->count(),'label' => 'Offres',     'color' => 'blue'],
            ],
            'acceptes_dash' => $total > 0 ? round(($acceptes   / $total * $circ), 1) : 0,
            'attente_dash'  => $total > 0 ? round(($en_attente / $total * $circ), 1) : 0,
            'refuses_dash'  => $total > 0 ? round(($refuses    / $total * $circ), 1) : 0,
            'acceptes'      => $total > 0 ? round(($acceptes   / $total * 100)) : 0,
            'en_attente'    => $total > 0 ? round(($en_attente / $total * 100)) : 0,
            'refuses'       => $total > 0 ? round(($refuses    / $total * 100)) : 0,
            'top_wishlist'  => $offreModel->topWishlist(5),
            'top_offres'    => $offreModel->topOffres(5),
        ];

        $this->render('dashboard/admin-stats.html.twig', [
            'title' => 'Dashboard Admin — StageHub',
            'user'  => Auth::user(),
            'stats' => $stats,
        ]);
    }

  
    public function adminUsers(): void
    {
        $this->requirePermission('admin.users');

        $db      = Database::getInstance();
        $perPage = 10;
        $page    = max(1, (int) ($_GET['page'] ?? 1));
        $offset  = ($page - 1) * $perPage;

        $totalUsers = (int) $db->query('SELECT COUNT(*) AS total FROM "User_"')->fetch()['total'];
        $pages      = (int) ceil($totalUsers / $perPage);

        $users = $db->query('
            SELECT u.id_user AS id,
                   p.first_name AS prenom,
                   p.name       AS nom,
                   u.email,
                   r.role_name  AS role,
                   p.creation_date AS inscription
            FROM "User_" u
            LEFT JOIN "Profil" p ON p.id_profil = u.id_profil
            LEFT JOIN "Role"   r ON r.id_role   = u.id_role
            ORDER BY p.name, p.first_name
            LIMIT ? OFFSET ?
        ', [$perPage, $offset])->fetchAll();

        $statsRaw = $db->query('
            SELECT r.role_name AS role, COUNT(*) AS count
            FROM "User_" u
            LEFT JOIN "Role" r ON r.id_role = u.id_role
            GROUP BY r.role_name
        ')->fetchAll();

        $statsArray = ['etudiants' => 0, 'pilotes' => 0, 'admins' => 0, 'entreprises' => 0];
        foreach ($statsRaw as $s) {
            match ($s['role']) {
                'etudiant'  => $statsArray['etudiants']   = (int) $s['count'],
                'pilote'    => $statsArray['pilotes']      = (int) $s['count'],
                'admin'     => $statsArray['admins']       = (int) $s['count'],
                'entreprise'=> $statsArray['entreprises']  = (int) $s['count'],
                default     => null,
            };
        }

        $this->render('dashboard/admin-users.html.twig', [
            'title'      => 'Admin — Utilisateurs',
            'user'       => Auth::user(),
            'users'      => $users,
            'stats'      => $statsArray,
            'pagination' => ['current' => $page, 'pages' => $pages],
        ]);
    }

    public function adminEntreprises(): void
    {
        $this->requirePermission('admin.entreprises');

        $db      = Database::getInstance();
        $perPage = 10;
        $page    = max(1, (int) ($_GET['page'] ?? 1));
        $offset  = ($page - 1) * $perPage;

        $totalEntreprises = (int) $db->query('SELECT COUNT(*) AS total FROM "Entreprise"')->fetch()['total'];
        $pages            = (int) ceil($totalEntreprises / $perPage);

        $entreprises = $db->query('
            SELECT
                e.id_entreprise AS id,
                e.name          AS nom,
                d.name          AS secteur,
                COALESCE(COUNT(o.id_offer) FILTER (WHERE o.active = TRUE), 0) AS "offresActives",
                COALESCE(AVG(g.note), 0) AS "note",
                e.creation_date AS dateAjout
            FROM "Entreprise" e
            LEFT JOIN "Offer"  o ON o.id_entreprise = e.id_entreprise
            LEFT JOIN "Domain" d ON d.id_domain     = e.id_domain
            LEFT JOIN "grade"  g ON g.id_entreprise = e.id_entreprise
            GROUP BY e.id_entreprise, e.name, d.name, e.creation_date
            ORDER BY e.name
            LIMIT ? OFFSET ?
        ', [$perPage, $offset])->fetchAll();

        $sectorsRaw = $db->query('
            SELECT DISTINCT d.name AS secteur
            FROM "Entreprise" e
            LEFT JOIN "Domain" d ON e.id_domain = d.id_domain
            ORDER BY d.name
        ')->fetchAll();
        $sectors = array_map(fn($s) => $s['secteur'], $sectorsRaw);

        $avecOffres  = array_reduce($entreprises, fn($c, $e) => $c + ($e['offresActives'] > 0 ? 1 : 0), 0);
        $totalOffres = $db->query('SELECT COUNT(*) AS total FROM "Offer"')->fetch()['total'] ?? 0;
        $noteMoyenne = round((float) ($db->query('
            SELECT COALESCE(AVG(g.note), 0) AS avg_note
            FROM "Entreprise" e
            LEFT JOIN "grade" g ON g.id_entreprise = e.id_entreprise
        ')->fetch()['avg_note'] ?? 0), 2);

        $this->render('dashboard/admin-entreprises.html.twig', [
            'title'       => 'Admin — Entreprises',
            'user'        => Auth::user(),
            'entreprises' => $entreprises,
            'sectors'     => $sectors,
            'stats'       => [
                'totalEntreprises' => $totalEntreprises,
                'avecOffres'       => $avecOffres,
                'totalOffres'      => $totalOffres,
                'noteMoyenne'      => $noteMoyenne,
            ],
            'pagination' => ['current' => $page, 'pages' => $pages],
        ]);
    }


    public function adminOffres(): void
    {
        $this->requirePermission('admin.offres');

        $userId     = Auth::id();
        $db         = Database::getInstance();
        $offreModel = new Offre();

        $candidatures = $db->query('
            SELECT o.title AS titre, e.name AS entreprise,
                   a.city AS ville, ap.motivation_letter,
                   ap.statut, o.publication_date AS date
            FROM apply ap
            JOIN "Offer"      o ON o.id_offer      = ap.id_offer
            JOIN "Entreprise" e ON e.id_entreprise = o.id_entreprise
            JOIN "Adress"     a ON a.id_adress     = e.id_adress
            WHERE ap.id_user = ?
            ORDER BY o.publication_date DESC
        ', [$userId])->fetchAll();

        $wishlist = $db->query('
            SELECT o.id_offer, o.title AS titre, e.name AS entreprise,
                   o.remuneration AS salaire, a.city AS ville
            FROM wishlist w
            JOIN "Offer"      o ON o.id_offer      = w.id_offer
            JOIN "Entreprise" e ON e.id_entreprise = o.id_entreprise
            JOIN "Adress"     a ON a.id_adress     = e.id_adress
            WHERE w.id_user = ?
        ', [$userId])->fetchAll();

        $this->render('dashboard/admin-offres.html.twig', [
            'title'        => 'Admin — Offres',
            'user'         => Auth::user(),
            'stats'        => [
                'total_offres'     => $offreModel->count(),
                'avg_candidatures' => $offreModel->avgCandidatures(),
                'top_wishlist'     => $offreModel->topWishlist(3),
            ],
            'candidatures' => $candidatures,
            'wishlist'     => $wishlist,
        ]);
    }
}