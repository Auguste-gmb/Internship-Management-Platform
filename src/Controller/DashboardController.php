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


    public function admin(): void
    {
        $this->requireAuth();
        $db = Database::getInstance();
        $offreModel = new Offre();

        // 🔹 Statistiques globales
        $statsStatus = $db->query("
            SELECT
                COUNT(*) FILTER (WHERE ap.statut = 'accepted') AS acceptes,
                COUNT(*) FILTER (WHERE ap.statut = 'pending')  AS en_attente,
                COUNT(*) FILTER (WHERE ap.statut = 'refused')  AS refuses
            FROM apply ap
        ")->fetch();

        $acceptes   = $statsStatus['acceptes']   ?? 0;
        $en_attente = $statsStatus['en_attente'] ?? 0;
        $refuses    = $statsStatus['refuses']    ?? 0;

        $total = $acceptes + $en_attente + $refuses;
        $circ  = 97.4; // pour le donut

        // 🔹 Tableau des stats à passer à Twig
        $stats = [
            // KPIs affichés en haut
            'kpis' => [
                ['icon'=>'✓', 'value'=>$acceptes,   'label'=>'Acceptés',    'color'=>'green'],
                ['icon'=>'⏳','value'=>$en_attente, 'label'=>'En attente',  'color'=>'yellow'],
                ['icon'=>'✕', 'value'=>$refuses,    'label'=>'Refusés',     'color'=>'red'],
                ['icon'=>'🏢','value'=>$offreModel->count(), 'label'=>'Offres','color'=>'blue'],
            ],

            // Donut chart
            'acceptes_dash' => $total > 0 ? round(($acceptes / $total * $circ), 1) : 0,
            'attente_dash'  => $total > 0 ? round(($en_attente / $total * $circ), 1) : 0,
            'refuses_dash'  => $total > 0 ? round(($refuses / $total * $circ), 1) : 0,

            // Pourcentages simples
            'acceptes'      => $total > 0 ? round(($acceptes / $total * 100)) : 0,
            'en_attente'    => $total > 0 ? round(($en_attente / $total * 100)) : 0,
            'refuses'       => $total > 0 ? round(($refuses / $total * 100)) : 0,

            // Top entreprises et top offres
            'top_wishlist'  => $offreModel->topWishlist(5), // doit renvoyer nom, secteur, candidatures
            'top_offres'    => $offreModel->topOffres(5),   // doit renvoyer titre, entreprise, domaine, remuneration, candidatures
        ];

        $this->render('dashboard/admin-stats.html.twig', [
            'title' => 'Dashboard Admin — StageHub',
            'user'  => $_SESSION['user'],
            'stats' => $stats
        ]);
    }

    
    public function admin_users(): void
    {
        $this->requireAuth();
        $db = Database::getInstance();

        $perPage = 10;
        $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $offset = ($currentPage - 1) * $perPage;

        // Total utilisateurs pour pagination
        $totalUsers = (int)$db->query('SELECT COUNT(*) AS total FROM "User_"')->fetch()['total'];
        $pages = (int)ceil($totalUsers / $perPage);

        // Récupérer utilisateurs pour la page courante
        $users = $db->query('
            SELECT u.id_user AS id,
                p.first_name AS prenom,
                p.name       AS nom,
                u.email,
                r.role_name AS role,
                p.creation_date AS inscription
            FROM "User_" u
            LEFT JOIN "Profil" p ON p.id_profil = u.id_profil
            LEFT JOIN "Role"   r ON r.id_role  = u.id_role
            ORDER BY p.name, p.first_name
            LIMIT ? OFFSET ?;
        ', [$perPage, $offset])->fetchAll();

        // Stats par rôle
        $statsRaw = $db->query('
            SELECT r.role_name AS role, COUNT(*) AS count
            FROM "User_" u
            LEFT JOIN "Role" r ON r.id_role = u.id_role
            GROUP BY r.role_name
        ')->fetchAll();

        $statsArray = [
            'etudiants'    => 0,
            'pilotes'      => 0,
            'admins'       => 0,
            'entreprises'  => 0,
        ];

        foreach ($statsRaw as $s) {
            switch ($s['role']) {
                case 'etudiant': $statsArray['etudiants'] = (int)$s['count']; break;
                case 'pilote': $statsArray['pilotes'] = (int)$s['count']; break;
                case 'admin': $statsArray['admins'] = (int)$s['count']; break;
                case 'entreprise': $statsArray['entreprises'] = (int)$s['count']; break;
            }
        }

        $this->render('dashboard/admin-users.html.twig', [
            'title'      => 'Dashboard Admin — Utilisateurs',
            'user'       => $_SESSION['user'],
            'users'      => $users,
            'stats'      => $statsArray,
            'pagination' => [
                'current' => $currentPage,
                'pages'   => $pages
            ]
        ]);
    }


    public function admin_entreprises(): void
    {
        $this->requireAuth();
        $db = Database::getInstance();

        $perPage = 10; // nombre d'entreprises par page
        $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $offset = ($currentPage - 1) * $perPage;

        // 🔹 Récupérer le total pour la pagination
        $totalEntreprises = (int) $db->query('SELECT COUNT(*) AS total FROM "Entreprise"')->fetch()['total'];

        $pages = (int) ceil($totalEntreprises / $perPage);

        // 🔹 Récupérer entreprises avec stats pour la page courante
        $entreprises = $db->query('
            SELECT 
                e.id_entreprise AS id,
                e.name AS nom,
                d.name AS secteur,
                COALESCE(COUNT(o.id_offer) FILTER (WHERE o.active = TRUE), 0) AS "offresActives",
                COALESCE(AVG(g.note), 0) AS "note",
                e.creation_date AS dateAjout
            FROM "Entreprise" e
            LEFT JOIN "Offer" o   ON o.id_entreprise = e.id_entreprise
            LEFT JOIN "Domain" d  ON d.id_domain = e.id_domain
            LEFT JOIN "grade" g   ON g.id_entreprise = e.id_entreprise
            GROUP BY e.id_entreprise, e.name, d.name, e.creation_date
            ORDER BY e.name
            LIMIT ? OFFSET ?;
        ', [$perPage, $offset])->fetchAll();

        // 🔹 Récupérer tous les secteurs
        $sectorsRaw = $db->query('
            SELECT DISTINCT d.name AS secteur
            FROM "Entreprise" e
            LEFT JOIN "Domain" d ON e.id_domain = d.id_domain
            ORDER BY d.name
        ')->fetchAll();
        $sectors = array_map(fn($s) => $s['secteur'], $sectorsRaw);

        // 🔹 Statistiques globales
        $avecOffres = array_reduce($entreprises, fn($carry,$e)=>$carry + ($e['offresActives']>0?1:0), 0);
        $totalOffres = $db->query('SELECT COUNT(*) AS total FROM "Offer"')->fetch()['total'] ?? 0;
        $noteMoyenne = $db->query('
            SELECT COALESCE(AVG(g.note),0) AS avg_note
            FROM "Entreprise" e
            LEFT JOIN "grade" g ON g.id_entreprise = e.id_entreprise
        ')->fetch()['avg_note'] ?? 0;
        $noteMoyenne = round((float)$noteMoyenne,2);

        $stats = [
            'totalEntreprises' => $totalEntreprises,
            'avecOffres'       => $avecOffres,
            'totalOffres'      => $totalOffres,
            'noteMoyenne'      => $noteMoyenne
        ];

        $this->render('dashboard/admin-entreprises.html.twig', [
            'title'       => 'Dashboard Admin — Entreprises',
            'user'        => $_SESSION['user'],
            'entreprises' => $entreprises,
            'sectors'     => $sectors,
            'stats'       => $stats,
            'pagination'  => [
                'current' => $currentPage,
                'pages'   => $pages
            ]
        ]);
    }

   public function admin_offres(): void
{
    $this->requireAuth();
    $db = Database::getInstance();
    $offreModel = new Offre();

    $perPage     = 15;
    $currentPage = max(1, (int)($_GET['page'] ?? 1));
    $offset      = ($currentPage - 1) * $perPage;

    $total      = $offreModel->count();
    $totalPages = (int) ceil($total / $perPage);

    $offres = $db->query('
        SELECT o.id_offer, o.title, o.duration, o.remuneration,
               e.name AS entreprise, d.name AS domain
        FROM "Offer" o
        LEFT JOIN "Entreprise" e ON e.id_entreprise = o.id_entreprise
        LEFT JOIN "Domain" d     ON d.id_domain     = o.id_domain
        ORDER BY o.publication_date DESC
        LIMIT ? OFFSET ?
    ', [$perPage, $offset])->fetchAll();

    $this->render('dashboard/admin-offres.html.twig', [
        'title'      => 'Dashboard Admin — Offres',
        'user'       => $_SESSION['user'],
        'offres'     => $offres,
        'stats'      => ['total' => $total],
        'pagination' => [
            'current'     => $currentPage,
            'total_pages' => $totalPages,
        ],
    ]);
}
}