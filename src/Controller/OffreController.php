<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Offre;

class OffreController extends BaseController
{
    public function index(): void
    {
        $this->render('offre/list.html.twig', [
            'title'  => 'Offres de stage — StageHub',
            'offres' => Offre::fakeList(),
            'stats'  => [
                'total_offres'      => 128,
                'total_entreprises' => 80,
            ],
            // Décommenter quand la pagination BDD sera prête :
            // 'pagination' => [
            //     'current'     => 1,
            //     'total_pages' => 11,
            // ],
            'app_query' => $_GET['q']   ?? '',
            'app_loc'   => $_GET['loc'] ?? '',
        ]);
    }

    public function show(int $id): void
    {
        $offre = Offre::fakeById($id);

        if (!$offre) {
            http_response_code(404);
            $this->render('errors/404.html.twig');
            return;
        }

        $this->render('offre/detail.html.twig', [
            'title' => $offre['titre'] . ' — StageHub',
            'offre' => $offre,
        ]);
    }
}