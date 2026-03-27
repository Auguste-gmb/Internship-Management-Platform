<?php
declare(strict_types=1);

namespace App\Controller;

class AuthController extends BaseController
{
    public function loginForm(): void
    {
        // Si déjà connecté → dashboard
        if (!empty($_SESSION['user'])) {
            $this->redirect('/dashboard');
        }

        $this->render('auth/login.html.twig', [
            'title' => 'Connexion — StageHub',
            'tab'   => 'login',
        ]);
    }
    public function login(): void
    {
        $email = trim(htmlspecialchars($_POST['email']    ?? '', ENT_QUOTES));
        $mdp   = $_POST['password'] ?? '';

        // TODO: remplacer par une vraie requête PDO + password_verify()

        $users = [
            [
                "id"=> 0,
                "email"=>"test@cesi.fr",
                "password"=> "motdepasse",
                "prenom" => "Thomas",
                "nom"    => "Thomas Dupont",
                "promo"  => "PGE A2 · CPI INFO",
                "role"   => "tuteur",
            ],
            [
                "id"=> 1,
                "email"=>"auguste.gambu@viacesi.fr",
                "password"=> "mdp1234",
                "prenom" => "Auguste",
                "nom"    => "Gambu",
                "promo"  => "PGE A2 · CPI INFO",
                "role"   => "etudiant",
            ],
        ];

        foreach ($users as $user) {
            if ($email === $user["email"] && $mdp === $user["password"]) {
                $_SESSION['user'] = [
                    'email'  => $user["email"],
                    'prenom' => $user["prenom"],
                    'nom'    => $user["nom"],
                    'promo'  => $user["promo"],
                    'role'   => $user["role"],
                ];
                $this->redirect('/dashboard');
                return;
            }
        }


        // Echec → on réaffiche le formulaire avec l'erreur
        $this->render('auth/login.html.twig', [
            'title'     => 'Connexion — StageHub',
            'tab'       => 'login',
            'error'     => 'Email ou mot de passe incorrect.',
            'old_email' => $email,
        ]);
    }
    public function register(): void
    {
        $prenom  = trim(htmlspecialchars($_POST['prenom']   ?? '', ENT_QUOTES));
        $nom     = trim(htmlspecialchars($_POST['nom']      ?? '', ENT_QUOTES));
        $email   = trim(htmlspecialchars($_POST['email']    ?? '', ENT_QUOTES));
        $role    = trim(htmlspecialchars($_POST['role']     ?? 'etudiant', ENT_QUOTES));
        $mdp     = $_POST['password']         ?? '';
        $confirm = $_POST['password_confirm'] ?? '';

        // Validation basique
        if ($mdp !== $confirm) {
            $this->render('auth/login.html.twig', [
                'title'          => 'Connexion — StageHub',
                'tab'            => 'register',
                'register_error' => 'Les mots de passe ne correspondent pas.',
                'old_prenom'     => $prenom,
                'old_nom'        => $nom,
                'old_reg_email'  => $email,
            ]);
            return;
        }

        if (strlen($mdp) < 8) {
            $this->render('auth/login.html.twig', [
                'title'          => 'Connexion — StageHub',
                'tab'            => 'register',
                'register_error' => 'Le mot de passe doit contenir au moins 8 caractères.',
                'old_prenom'     => $prenom,
                'old_nom'        => $nom,
                'old_reg_email'  => $email,
            ]);
            return;
        }

        // TODO: insérer en BDD avec password_hash($mdp, PASSWORD_BCRYPT)
        // Pour l'instant on connecte directement après inscription
        $_SESSION['user'] = [
            'email'  => $email,
            'prenom' => $prenom,
            'nom'    => "$prenom $nom",
            'promo'  => 'PGE A2 · CPI INFO',
            'role'   => $role,
        ];

        $this->redirect('/dashboard');
    }

    
    public function logout(): void
    {
        session_destroy();
        $this->redirect('/');
    }
}