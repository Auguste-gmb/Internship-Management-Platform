<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Auth;
use App\Model\User;


class AuthController extends BaseController
{
    public function loginForm(): void
    {
        if (Auth::check()) {
            $this->redirect('/dashboard');
        }

        $this->render('auth/login.html.twig', [
            'title' => 'Connexion — StageHub',
            'tab'   => 'login',
        ]);
    }

    
    public function login(): void
    {
        $email = trim($_POST['email']    ?? '');
        $mdp   = $_POST['password'] ?? '';

        $user = (new User())->findByEmail($email);

        if (!$user || !password_verify($mdp, $user['password'])) {
            $this->render('auth/login.html.twig', [
                'title'     => 'Connexion — StageHub',
                'tab'       => 'login',
                'error'     => 'Email ou mot de passe incorrect.',
                'old_email' => htmlspecialchars($email, ENT_QUOTES),
            ]);
            return;
        }

        Auth::login($user);
        $this->redirect('/dashboard');
    }

 
    public function register(): void
    {
        $prenom  = trim($_POST['prenom']           ?? '');
        $nom     = trim($_POST['nom']              ?? '');
        $email   = trim($_POST['email']            ?? '');
        $mdp     = $_POST['password']         ?? '';
        $confirm = $_POST['password_confirm'] ?? '';

        if ($mdp !== $confirm) {
            $this->renderRegisterError('Les mots de passe ne correspondent pas.', $prenom, $nom, $email);
            return;
        }

        if (strlen($mdp) < 8) {
            $this->renderRegisterError('Le mot de passe doit contenir au moins 8 caractères.', $prenom, $nom, $email);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->renderRegisterError('Adresse email invalide.', $prenom, $nom, $email);
            return;
        }

        $userModel = new User();

        if ($userModel->findByEmail($email)) {
            $this->renderRegisterError('Cette adresse email est déjà utilisée.', $prenom, $nom, $email);
            return;
        }

        $id   = $userModel->create([
            'first_name' => $prenom,
            'name'       => $nom,
            'email'      => $email,
            'password'   => $mdp,
            'id_role'    => 1, // etudiant par défaut
        ]);

        $user = $userModel->findById($id);
        Auth::login($user);

        $this->redirect('/dashboard');
    }


    public function logout(): void
    {
        Auth::logout();
        $this->redirect('/');
    }


    private function renderRegisterError(string $msg, string $prenom, string $nom, string $email): void
    {
        $this->render('auth/login.html.twig', [
            'title'          => 'Connexion — StageHub',
            'tab'            => 'register',
            'register_error' => $msg,
            'old_prenom'     => htmlspecialchars($prenom, ENT_QUOTES),
            'old_nom'        => htmlspecialchars($nom, ENT_QUOTES),
            'old_reg_email'  => htmlspecialchars($email, ENT_QUOTES),
        ]);
    }
}