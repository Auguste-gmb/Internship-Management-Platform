<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\User;

class ProfilController extends BaseController
{
    public function index(): void
    {
        $this->requireAuth();
        
        $userId = $_SESSION['user']['id'];
        $userModel = new User();
        $user = $userModel->findById($userId);
        
        $this->render('dashboard/profil.html.twig', [
            'title' => 'Mon profil — StageHub',
            'user'  => $user,
            'stats' => [
                'candidatures' => $userModel->countCandidatures($userId),
                'wishlist'     => $userModel->countWishlist($userId),
            ],
        ]);
    }

    public function update(): void
    {
        $this->requireAuth();
        
        $userId = $_SESSION['user']['id'];
        $prenom = trim($_POST['prenom'] ?? '');
        $nom    = trim($_POST['nom']    ?? '');
        $email  = trim($_POST['email']  ?? '');
        $tel    = trim($_POST['telephone'] ?? '');
        
        $userModel = new User();
        $userModel->updateProfil($userId, [
            'prenom'    => $prenom,
            'nom'       => $nom,
            'email'     => $email,
            'telephone' => $tel,
        ]);
        
        $_SESSION['user']['prenom'] = $prenom;
        $_SESSION['user']['nom']    = $nom;
        $_SESSION['user']['email']  = $email;
        
        $this->redirect('/dashboard/profil?success=1');
    }

    public function password(): void
    {
        $this->requireAuth();
        
        $userId      = $_SESSION['user']['id'];
        $current     = $_POST['current_password'] ?? '';
        $new         = $_POST['new_password']     ?? '';
        $confirm     = $_POST['confirm_password'] ?? '';
        
        $userModel = new User();
        $user = $userModel->findById($userId);
        
        if (!password_verify($current, $user['password'])) {
            $this->redirect('/dashboard/profil?error=current');
            return;
        }
        
        if ($new !== $confirm) {
            $this->redirect('/dashboard/profil?error=mismatch');
            return;
        }
        
        if (strlen($new) < 8) {
            $this->redirect('/dashboard/profil?error=length');
            return;
        }
        
        $userModel->updatePassword($userId, $new);
        $this->redirect('/dashboard/profil?success=password');
    }
}