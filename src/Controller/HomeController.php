<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Offre;
use App\Model\Entreprise;
use App\Model\User;

class HomeController extends BaseController
{
    public function index(): void
    {
        $offreModel      = new Offre();
        $entrepriseModel = new Entreprise();
        $userModel       = new User();

        $offres  = (new Offre())->getAll('', '', '', 0, [1], 5, 0);
        $entreprises = $entrepriseModel->getAll();

        $this->render('home/index.html.twig', [
            'title'               => 'StageHub — Trouvez votre stage idéal',
            'offres_recentes'     => array_slice($offres, 0, 3),
            'entreprises_vedette' => array_slice($entreprises, 0, 4),
            'stats' => [
                'total_offres'      => $offreModel->count(),
                'total_entreprises' => $entrepriseModel->countFiltered(),
                'total_etudiants'   => $userModel->count(),
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
