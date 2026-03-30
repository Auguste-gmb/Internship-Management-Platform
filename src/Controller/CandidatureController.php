<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Offre;
use App\Core\Database;

class CandidatureController extends BaseController
{
    public function form(): void
    {
        $this->requireAuth();

        $offreId = (int)($_GET['offre'] ?? 0);
        $offre   = (new Offre())->getById($offreId);

        if (!$offre) {
            http_response_code(404);
            $this->render('errors/404.html.twig', []);
            return;
        }

        $this->render('candidature/postuler.html.twig', [
            'title' => 'Postuler — ' . $offre['title'] . ' · StageHub',
            'offre' => $offre,
            'user'  => $_SESSION['user'],
        ]);
    }

    public function submit(): void
    {
        $this->requireAuth();

        $offreId = (int)($_POST['offre_id'] ?? 0);
        $offre   = (new Offre())->getById($offreId);

        if (!$offre) {
            http_response_code(404);
            $this->render('errors/404.html.twig', []);
            return;
        }

        $lm      = trim($_POST['lm']      ?? '');
        $message = trim($_POST['message'] ?? '');
        $consent = isset($_POST['consent']);

        // Validation
        if (strlen($lm) < 50) {
            $this->renderForm($offre, 'Votre lettre de motivation est trop courte (50 caractères min).', $lm, $message);
            return;
        }

        if (!$consent) {
            $this->renderForm($offre, 'Vous devez accepter la politique de confidentialité.', $lm, $message);
            return;
        }

        // Gestion CV
        $cvPath = null;
        if (!empty($_FILES['cv']['name'])) {
            $allowed = ['pdf', 'doc', 'docx'];
            $ext     = strtolower(pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                $this->renderForm($offre, 'Format CV non accepté (PDF, DOC, DOCX).', $lm, $message);
                return;
            }

            if ($_FILES['cv']['size'] > 5 * 1024 * 1024) {
                $this->renderForm($offre, 'Le CV dépasse 5 Mo.', $lm, $message);
                return;
            }

            $uploadDir = __DIR__ . '/../../../uploads/cv/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0750, true);
            }

            $cvPath = uniqid('cv_', true) . '.' . $ext;
            move_uploaded_file($_FILES['cv']['tmp_name'], $uploadDir . $cvPath);
        }

        // Insertion BDD via procédure stockée
        Database::getInstance()->query(
            'CALL sp_apply(?, ?, ?, ?, ?)',
            [
                $_SESSION['user']['id'],
                $offreId,
                $cvPath,
                $lm,
                $message,
            ]
        );

        $this->render('candidature/postuler.html.twig', [
            'title'   => 'Postuler — StageHub',
            'offre'   => $offre,
            'success' => true,
            'user'    => $_SESSION['user'],
        ]);
    }

    private function renderForm(array $offre, string $error, string $lm, string $message): void
    {
        $this->render('candidature/postuler.html.twig', [
            'title'       => 'Postuler — StageHub',
            'offre'       => $offre,
            'error'       => $error,
            'old_lm'      => $lm,
            'old_message' => $message,
            'user'        => $_SESSION['user'],
        ]);
    }
}
?>