<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Offre;

class OffreController extends BaseController
{
    private const PER_PAGE = 12;

    public function index(): void
    {
        $model    = new Offre();
        $search   = trim($_GET['q']        ?? '');
        $loc      = trim($_GET['loc']      ?? '');
        $duration = trim($_GET['duration'] ?? '');
        $remuMax  = (int)($_GET['remu_max'] ?? 0);
        
        // Toujours récupérer domainIds comme tableau
        $domainIds = $_GET['domain'] ?? [];
        if (!is_array($domainIds)) {
            $domainIds = [$domainIds];
        }

        $page   = max(1, (int)($_GET['page'] ?? 1));
        $offset = ($page - 1) * self::PER_PAGE;

        // Récupérer les offres filtrées et le total
        $offres = $model->getAll($search, $loc, $duration, $remuMax, $domainIds, self::PER_PAGE, $offset);
        $total  = $model->countFiltered($search, $loc, $duration, $remuMax, $domainIds);

        $totalPages = (int) ceil($total / self::PER_PAGE);
        $domaines   = $model->getDomaines();

        $this->render('offre/list.html.twig', [
            'title'        => 'Offres de stage — StageHub',
            'offres'       => $offres,
            'domaines'     => $domaines,
            'stats'        => ['total_offres' => $total],
            'pagination'   => [
                'current'     => $page,
                'total_pages' => $totalPages,
                'per_page'    => self::PER_PAGE,
            ],
            'app_query'    => htmlspecialchars($search,   ENT_QUOTES),
            'app_loc'      => htmlspecialchars($loc,      ENT_QUOTES),
            'app_duration' => htmlspecialchars($duration, ENT_QUOTES),
            'app_remu_max' => $remuMax,
            'app_domain'   => $domainIds,
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