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
            'title'           => 'Entreprises partenaires — StageHub',
            'entreprises'     => $entreprises,
            'stats'           => ['total_entreprises' => $total],
            'pagination'      => [
                'current'     => $page,
                'total_pages' => $totalPages,
            ],
            'app_query'        => htmlspecialchars($search, ENT_QUOTES),
            'app_note_min'     => $noteMin,
            'app_offres_range' => $offresRange,
            'app_domain'       => $domainIds,
            'domaines'         => (new Offre())->getDomaines(),
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
        $domains = (new Entreprise())->getAllDomains();
        $this->render('entreprise/form.html.twig', [
            'title'      => 'Nouvelle entreprise — StageHub',
            'domains'    => $domains,
            'entreprise' => null,
            'errors'     => [],
        ]);
    }

    public function store(): void
    {
        $this->requireAdmin();
        $data   = $this->extractFormData();
        $errors = $this->validate($data);

        if ($errors) {
            $this->render('entreprise/form.html.twig', [
                'title'      => 'Nouvelle entreprise — StageHub',
                'domains'    => (new Entreprise())->getAllDomains(),
                'entreprise' => $data,
                'errors'     => $errors,
            ]);
            return;
        }

        (new Entreprise())->create($data);
        $this->redirect('/dashboard/entreprises');
    }

    public function editForm(int $id): void
    {
        $this->requireAdmin();
        $model      = new Entreprise();
        $entreprise = $model->getById((string)$id);

        if (!$entreprise) {
            http_response_code(404);
            $this->render('errors/404.html.twig', []);
            return;
        }

        $this->render('entreprise/form.html.twig', [
            'title'      => 'Modifier ' . $entreprise['name'] . ' — StageHub',
            'domains'    => $model->getAllDomains(),
            'entreprise' => $entreprise,
            'errors'     => [],
        ]);
    }

    public function update(int $id): void
    {
        $this->requireAdmin();
        $data   = $this->extractFormData();
        $errors = $this->validate($data);

        if ($errors) {
            $this->render('entreprise/form.html.twig', [
                'title'      => 'Modifier l\'entreprise — StageHub',
                'domains'    => (new Entreprise())->getAllDomains(),
                'entreprise' => array_merge($data, ['id_entreprise' => $id]),
                'errors'     => $errors,
            ]);
            return;
        }

        (new Entreprise())->update($id, $data);
        $this->redirect('/dashboard/entreprises');
    }

    public function destroy(int $id): void
    {
        $this->requireAdmin();
        (new Entreprise())->delete($id);
        $this->redirect('/dashboard/entreprises');
    }

    private function extractFormData(): array
    {
        return [
            'name'          => trim($_POST['name']          ?? ''),
            'description'   => trim($_POST['description']   ?? ''),
            'email'         => trim($_POST['email']         ?? ''),
            'id_domain'     => $_POST['id_domain'] ?: null,
            'city'          => trim($_POST['city']          ?? ''),
            'street_number' => trim($_POST['street_number'] ?? ''),
            'street_name'   => trim($_POST['street_name']   ?? ''),
            'region'        => trim($_POST['region']        ?? ''),
        ];
    }

    private function validate(array $data): array
    {
        $errors = [];
        if ($data['name'] === '') $errors['name'] = 'Le nom est obligatoire.';
        if ($data['city'] === '') $errors['city'] = 'La ville est obligatoire.';
        if ($data['email'] !== '' && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email invalide.';
        }
        return $errors;
    }
}