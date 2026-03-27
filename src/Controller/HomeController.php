<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Offre;
use App\Model\Entreprise;

class HomeController extends BaseController
{
    public function index(): void
    {
        $this->render('home/index.html.twig', [
            'title'              => 'StageHub — Trouvez votre stage idéal',
            // Les 3 offres les plus récentes pour la section accueil
            'offres_recentes'    => Offre::fakeList(),
            // Les 4 premières entreprises pour la section partenaires
            'entreprises_vedette'=> array_slice(Entreprise::fakeList(), 0, 4),
            // Stats pour la carte (sera remplacé par des vraies requêtes BDD)
            'stats'              => [
                'total_offres'      => 128,
                'total_entreprises' => 80,
                'total_etudiants'   => 128,
            ],
        ]);
    }

    public function mentions(): void
    {
        $this->render('legal/mentions.html.twig', [
            'title' => 'Mentions légales — StageHub',
        ]);
    }
}
?>