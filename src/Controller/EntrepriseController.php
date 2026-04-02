<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entreprise;
use App\Model\Offre;

class EntrepriseController extends BaseController
{
    private const PER_PAGE = 12;

    public function index(): void
    {
        $model       = new Entreprise();
        $search      = trim($_GET['q'] ?? '');
        $noteMin     = (int)($_GET['note_min'] ?? 0);
        $offresRange = trim($_GET['offres_range'] ?? '');
        $page        = max(1, (int)($_GET['page'] ?? 1));
        $offset      = ($page - 1) * self::PER_PAGE;

        $domainIds = $_GET['domain'] ?? [];
        if (!is_array($domainIds)) {
            $domainIds = [$domainIds];
        }

        $total = $model->countFiltered($search, $noteMin, $offresRange, $domainIds);
        $totalPages = (int) ceil($total / self::PER_PAGE);

        $entreprises = $model->getAll(
            $search,
            $noteMin,
            $offresRange,
            $domainIds,
            self::PER_PAGE,
            $offset
        );

        $this->render('entreprise/list.html.twig', [
            'title'          => 'Entreprises partenaires — StageHub',
            'entreprises'    => $entreprises,
            'stats'          => ['total_entreprises' => $total],
            'pagination'     => [
                'current'     => $page,
                'total_pages' => $totalPages,
            ],
            'app_query'       => htmlspecialchars($search, ENT_QUOTES),
            'app_note_min'    => $noteMin,
            'app_offres_range'=> $offresRange,
            'app_domain'      => $domainIds,
            'domaines'        => (new Offre())->getDomaines(),
        ]);
    }

    public function show(int $id): void
    {
        $entreprise = (new Entreprise())->getById((string)$id);

        if (!$entreprise) {
            http_response_code(404);
            $this->render('errors/404.html.twig', []);
            return;
        }

        $this->render('entreprise/detail.html.twig', [
            'title'      => $entreprise['name'] . ' — StageHub',
            'entreprise' => $entreprise,
        ]);
    }

}