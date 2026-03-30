<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entreprise;

class EntrepriseController extends BaseController
{
    public function index(): void
    {
        $model  = new Entreprise();
        $search = trim($_GET['q'] ?? '');

        $this->render('entreprise/list.html.twig', [
            'title'       => 'Entreprises partenaires — StageHub',
            'entreprises' => $model->getAll($search),
            'stats'       => [
                'total_entreprises' => $model->count(),
            ],
            'app_query'   => htmlspecialchars($search, ENT_QUOTES),
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
?>