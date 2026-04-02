<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Offre;

class OffreController extends BaseController
{
    private const PER_PAGE = 12;

    public function index(): void
    {
        $model = new Offre();

        // Récup des filtres
        $search   = trim($_GET['q']        ?? '');
        $loc      = trim($_GET['loc']      ?? '');
        $duration = trim($_GET['duration'] ?? '');
        $remuMax  = (int)($_GET['remu_max'] ?? 0);
        $domainIds = $_GET['domain'] ?? [];
        if (!is_array($domainIds)) {
            $domainIds = [$domainIds];
        }

        $page   = max(1, (int)($_GET['page'] ?? 1));
        $offset = ($page - 1) * self::PER_PAGE;

        // Récupération des offres et du total
        $total      = $model->countFiltered($search, $loc, $duration, $remuMax, $domainIds);
        $totalPages = (int) ceil($total / self::PER_PAGE);
        $offres     = $model->getAll($search, $loc, $duration, $remuMax, $domainIds, self::PER_PAGE, $offset);

        // Domaines pour le filtre
        $domaines = $model->getDomaines();

        // Rendu
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

    private function requireAdmin(): void
{
    $this->requireAuth();
    if (($_SESSION['user']['role'] ?? '') !== 'administrator') {
        http_response_code(403);
        $this->render('errors/403.html.twig', []);
        exit;
    }
}

public function createForm(): void
{
    $this->requireAdmin();
    $model = new Offre();
    $this->render('offre/form.html.twig', [
        'title'      => 'Nouvelle offre — StageHub',
        'offre'      => null,
        'errors'     => [],
        'domaines'   => $model->getDomaines(),
        'entreprises'=> $model->getAllEntreprises(),
    ]);
}

public function store(): void
{
    $this->requireAdmin();
    $data   = $this->extractFormData();
    $errors = $this->validate($data);
    $model  = new Offre();

    if ($errors) {
        $this->render('offre/form.html.twig', [
            'title'      => 'Nouvelle offre — StageHub',
            'offre'      => $data,
            'errors'     => $errors,
            'domaines'   => $model->getDomaines(),
            'entreprises'=> $model->getAllEntreprises(),
        ]);
        return;
    }

    $model->create($data);
    $this->redirect('/dashboard/offres');
}

public function editForm(int $id): void
{
    $this->requireAdmin();
    $model = new Offre();
    $offre = $model->getById($id);

    if (!$offre) {
        http_response_code(404);
        $this->render('errors/404.html.twig', []);
        return;
    }

    $this->render('offre/form.html.twig', [
        'title'      => 'Modifier ' . $offre['title'] . ' — StageHub',
        'offre'      => $offre,
        'errors'     => [],
        'domaines'   => $model->getDomaines(),
        'entreprises'=> $model->getAllEntreprises(),
    ]);
}

public function update(int $id): void
{
    $this->requireAdmin();
    $data   = $this->extractFormData();
    $errors = $this->validate($data);
    $model  = new Offre();

    if ($errors) {
        $this->render('offre/form.html.twig', [
            'title'      => 'Modifier l\'offre — StageHub',
            'offre'      => array_merge($data, ['id_offer' => $id]),
            'errors'     => $errors,
            'domaines'   => $model->getDomaines(),
            'entreprises'=> $model->getAllEntreprises(),
        ]);
        return;
    }

    $model->update($id, $data);
    $this->redirect('/dashboard/offres');
}

public function destroy(int $id): void
{
    $this->requireAdmin();
    (new Offre())->delete($id);
    $this->redirect('/dashboard/offres');
}

private function extractFormData(): array
{
    return [
        'title'         => trim($_POST['title']         ?? ''),
        'description'   => trim($_POST['description']   ?? ''),
        'skill'         => trim($_POST['skill']         ?? ''),
        'duration'      => trim($_POST['duration']      ?? ''),
        'remuneration'  => trim($_POST['remuneration']  ?? ''),
        'level'         => trim($_POST['level']         ?? ''),
        'type'          => trim($_POST['type']          ?? ''),
        'id_domain'     => $_POST['id_domain']     ?: null,
        'id_entreprise' => $_POST['id_entreprise'] ?: null,
    ];
}

private function validate(array $data): array
{
    $errors = [];
    if ($data['title'] === '') $errors['title'] = 'L\'intitulé est obligatoire.';
    return $errors;
}
}