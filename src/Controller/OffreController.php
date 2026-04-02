<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Offre;
use App\Core\Auth;

class OffreController extends BaseController
{
    private const PER_PAGE = 12;

    public function index(): void
    {
        $model = new Offre();

        $search    = trim($_GET['q']        ?? '');
        $loc       = trim($_GET['loc']      ?? '');
        $duration  = trim($_GET['duration'] ?? '');
        $remuMax   = (int) ($_GET['remu_max'] ?? 0);
        $domainIds = $this->getArrayParam('domain');
        $page      = max(1, (int) ($_GET['page'] ?? 1));
        $offset    = ($page - 1) * self::PER_PAGE;

        $total      = $model->countFiltered($search, $loc, $duration, $remuMax, $domainIds);
        $totalPages = (int) ceil($total / self::PER_PAGE);
        $offres     = $model->getAll($search, $loc, $duration, $remuMax, $domainIds, self::PER_PAGE, $offset);

        $filters = [
            'q'        => $search,
            'loc'      => $loc,
            'duration' => $duration,
            'remu_max' => $remuMax,
            'domain'   => $domainIds,
        ];

        $this->render('offre/list.html.twig', [
            'title'      => 'Offres de stage — StageHub',
            'offres'     => $offres,
            'domaines'   => $model->getDomaines(),
            'stats'      => ['total_offres' => $total],
            'pagination' => [
                'current'     => $page,
                'total_pages' => $totalPages,
                'per_page'    => self::PER_PAGE
            ],
            'filters'    => $filters,
            
            'app_query'    => htmlspecialchars($search,   ENT_QUOTES),
            'app_loc'      => htmlspecialchars($loc,      ENT_QUOTES),
            'app_duration' => htmlspecialchars($duration, ENT_QUOTES),
            'app_remu_max' => $remuMax,
            'app_domain'   => $domainIds,
        ]);
    }

    public function show(int $id): void
    {
        $offreModel = new Offre();
        $offre = $offreModel->getById($id);

        if (!$offre) {
            $this->renderError(404);
        }

        if (Auth::check()) {
            $wishlistModel = new \App\Model\Wishlist();
            $offre['in_wishlist'] = $wishlistModel->isInWishlist(
                Auth::id(), 
                $id
            );
        }

        $this->render('offre/detail.html.twig', [
            'title' => $offre['title'] . ' — StageHub',
            'offre' => $offre,
        ]);
    }


    private function getArrayParam(string $key): array
    {
        $val = $_GET[$key] ?? [];
        return is_array($val) ? $val : [$val];
    }
}