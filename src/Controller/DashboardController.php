<?php
declare(strict_types=1);

namespace App\Controller;

class DashboardController extends BaseController
{
    public function index(): void
    {
        $this->requireAuth();

        // TODO: remplacer par de vraies requêtes PDO liées à $_SESSION['user']['id']
        $candidatures = [
            ['titre' => 'Développeur Full-Stack', 'entreprise' => 'Accenture',    'ville' => 'Paris',    'statut' => 'pending',  'date' => '02/03'],
            ['titre' => 'UX/UI Designer',         'entreprise' => 'Capgemini',    'ville' => 'Lyon',     'statut' => 'refused',  'date' => '25/02'],
            ['titre' => 'Analyste Data',           'entreprise' => 'Sopra Steria', 'ville' => 'Bordeaux', 'statut' => 'pending',  'date' => '20/02'],
            ['titre' => 'Ingénieur DevOps',        'entreprise' => 'Alten',        'ville' => 'Toulouse', 'statut' => 'refused',  'date' => '14/02'],
            ['titre' => 'Chef de projet digital',  'entreprise' => 'Orange Group', 'ville' => 'Paris',    'statut' => 'pending',  'date' => '10/02'],
        ];

        $wishlist = [
            ['titre' => 'Développeur Full-Stack PHP/JS', 'entreprise' => 'Accenture',   'salaire' => '800 €/mois', 'ville' => 'Paris'],
            ['titre' => 'UX/UI Designer Stage',          'entreprise' => 'Capgemini',   'salaire' => '700 €/mois', 'ville' => 'Lyon'],
            ['titre' => 'Analyste Financier Junior',     'entreprise' => 'BNP Paribas', 'salaire' => '950 €/mois', 'ville' => 'Rouen'],
            ['titre' => 'Chef de projet digital',        'entreprise' => 'Orange Group','salaire' => '780 €/mois', 'ville' => 'Paris'],
        ];

        $this->render('dashboard/index.html.twig', [
            'title'        => 'Dashboard — StageHub',
            'user'         => [
                'prenom' => $_SESSION['user']['prenom'] ?? 'Thomas',
                'nom'    => $_SESSION['user']['prenom'] . " " . $_SESSION['user']['nom']    ?? 'Thomas Dupont',
                'email'  => $_SESSION['user']['email']  ?? 'thomas.dupont@cesi.fr',
                'promo'  => $_SESSION['user']['promo']  ?? 'PGE A2 · CPI INFO',
            ],
            'stats'        => [
                'acceptes'   => 0,
                'en_attente' => 5,
                'refuses'    => 28,
            ],
            'candidatures' => $candidatures,
            'wishlist'     => $wishlist,
        ]);
    }
}