<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Offre;

class OffreController extends BaseController
{
    public function index(): void
    {
        $model  = new Offre();
        $search = trim($_GET['q']   ?? '');
        $loc    = trim($_GET['loc'] ?? '');

        $offres = $model->getAll($search, $loc);

        $this->render('offre/list.html.twig', [
            'title'     => 'Offres de stage — StageHub',
            'offres'    => $offres,
            'stats'     => [
                'total_offres' => $model->count(),
            ],
            'app_query' => htmlspecialchars($search, ENT_QUOTES),
            'app_loc'   => htmlspecialchars($loc, ENT_QUOTES),
        ]);
    }

    public function show(int $id): void
    {
        $offre = (new Offre())->getById($id);

        if (!$offre) {
            http_response_code(404);
            $this->render('errors/404.html.twig', []);
            return;
        }

        $this->render('offre/detail.html.twig', [
            'title' => $offre['title'] . ' — StageHub',
            'offre' => $offre,
        ]);
    }
}
?>