<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Offre;

class CandidatureController extends BaseController
{
    // ── GET /postuler?offre=1 ─────────────────────────────────────────────────
    public function form(): void
    {
        $this->requireAuth();

        $offreId = (int)($_GET['offre'] ?? 1);
        $offre   = Offre::fakeById($offreId) ?? Offre::fakeById(1);

        $this->render('candidature/postuler.html.twig', [
            'title' => 'Postuler — ' . $offre['titre'] . ' · StageHub',
            'offre' => $offre,
            'user'  => [
                'prenom' => $_SESSION['user']['prenom'] ?? '',
                'nom'    => $_SESSION['user']['nom']    ?? '',
                'email'  => $_SESSION['user']['email']  ?? '',
            ],
        ]);
    }

    // ── POST /postuler ────────────────────────────────────────────────────────
    public function submit(): void
    {
        $this->requireAuth();

        $offreId = (int)($_POST['offre_id'] ?? 1);
        $offre   = Offre::fakeById($offreId) ?? Offre::fakeById(1);

        // ── Validation PHP ────────────────────────────────────────────────────
        $prenom  = trim(htmlspecialchars($_POST['prenom']  ?? '', ENT_QUOTES));
        $nom     = trim(htmlspecialchars($_POST['nom']     ?? '', ENT_QUOTES));
        $email   = trim(htmlspecialchars($_POST['email']   ?? '', ENT_QUOTES));
        $lm      = trim($_POST['lm']      ?? '');
        $message = trim($_POST['message'] ?? '');
        $consent = isset($_POST['consent']);

        if (!$prenom || !$nom || !$email) {
            $this->render('candidature/postuler.html.twig', [
                'title'  => 'Postuler — StageHub',
                'offre'  => $offre,
                'error'  => 'Veuillez remplir tous les champs obligatoires.',
                'old_lm' => $lm,
            ]);
            return;
        }

        if (strlen($lm) < 50) {
            $this->render('candidature/postuler.html.twig', [
                'title'       => 'Postuler — StageHub',
                'offre'       => $offre,
                'error'       => 'Votre lettre de motivation est trop courte.',
                'old_lm'      => $lm,
                'old_message' => $message,
            ]);
            return;
        }

        if (!$consent) {
            $this->render('candidature/postuler.html.twig', [
                'title'       => 'Postuler — StageHub',
                'offre'       => $offre,
                'error'       => 'Vous devez accepter la politique de confidentialité.',
                'old_lm'      => $lm,
                'old_message' => $message,
            ]);
            return;
        }

        // ── Upload CV ─────────────────────────────────────────────────────────
        if (!empty($_FILES['cv']['name'])) {
            $allowed    = ['pdf', 'doc', 'docx'];
            $ext        = strtolower(pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION));
            $maxSize    = 5 * 1024 * 1024; // 5 Mo

            if (!in_array($ext, $allowed)) {
                $this->render('candidature/postuler.html.twig', [
                    'title' => 'Postuler — StageHub',
                    'offre' => $offre,
                    'error' => 'Format de CV non accepté (PDF, DOC, DOCX uniquement).',
                    'old_lm' => $lm,
                ]);
                return;
            }

            if ($_FILES['cv']['size'] > $maxSize) {
                $this->render('candidature/postuler.html.twig', [
                    'title' => 'Postuler — StageHub',
                    'offre' => $offre,
                    'error' => 'Le fichier CV dépasse la taille maximale de 5 Mo.',
                    'old_lm' => $lm,
                ]);
                return;
            }

            // TODO: déplacer le fichier dans un dossier sécurisé hors webroot
            // $dest = __DIR__ . '/../../../uploads/cv/' . uniqid() . '.' . $ext;
            // move_uploaded_file($_FILES['cv']['tmp_name'], $dest);
        }

        // ── TODO: insertion BDD ───────────────────────────────────────────────
        // $db = Database::getInstance();
        // $db->prepare("INSERT INTO candidatures (...) VALUES (...)")->execute([...]);

        // ── Succès : on réaffiche la page avec la modale ouverte ──────────────
        $this->render('candidature/postuler.html.twig', [
            'title'   => 'Postuler — StageHub',
            'offre'   => $offre,
            'success' => true,
            'user'    => [
                'prenom' => $prenom,
                'nom'    => $nom,
                'email'  => $email,
            ],
        ]);
    }
}