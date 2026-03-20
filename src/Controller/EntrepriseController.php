<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entreprise;

class EntrepriseController extends BaseController
{
    public function index(): void
    {
        $this->render('entreprise/list.html.twig', [
            'title'       => 'Entreprises partenaires — StageHub',
            'entreprises' => Entreprise::fakeList(),
            'stats'       => [
                'total_entreprises' => 80,
            ],
            'app_query'   => $_GET['q'] ?? '',
        ]);
    }

    public function show(int $id): void
    {
        $entreprise = Entreprise::fakeById($id);

        if (!$entreprise) {
            http_response_code(404);
            $this->render('errors/404.html.twig');
            return;
        }

        $this->render('entreprise/detail.html.twig', [
            'title'      => $entreprise['nom'] . ' — StageHub',
            'entreprise' => $entreprise,
        ]);
    }
}