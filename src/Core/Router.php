<?php
declare(strict_types=1);

namespace App\Core;

use SebastianBergmann\Environment\Console;
use Twig\Environment;
use App\Controller\HomeController;
use App\Controller\OffreController;
use App\Controller\EntrepriseController;
use App\Controller\AuthController;
use App\Controller\DashboardController;
use App\Controller\CandidatureController;
use App\Controller\ProfilController;
use App\Controller\WishlistController;
use App\Controller\HistoriqueController;

class Router
{
    public function __construct(private Environment $twig) {}

    private function handleDashboard($pages): void
    {
        if (empty($_SESSION['user'])) {
            header('Location: /connexion');
            exit;
        }

        $role = $_SESSION['user']['role'];
        if ($role === 'administrator') {
            // Dashboard admin
            if ($pages == ''){
                (new DashboardController($this->twig))->admin();
            } elseif ($pages == 'users') {
                (new DashboardController($this->twig))->admin_users();
            } elseif ($pages == 'entreprises') {
                (new DashboardController($this->twig))->admin_entreprises();
            } elseif ($pages == 'offres') {
                (new DashboardController($this->twig))->admin_offres();
            }
        } else {
            // Dashboard étudiant / normal
            (new DashboardController($this->twig))->index();
        }
    }

    public function dispatch(): void
    {
        $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri    = rtrim($uri, '/') ?: '/';
        $method = $_SERVER['REQUEST_METHOD'];
    
        // Injecter user dans Twig si connecté
        if (!empty($_SESSION['user'])) {
            $this->twig->addGlobal('app_user', $_SESSION['user']);
        }

        match (true) {
            // Home
            $uri === '/' && $method === 'GET'
                => (new HomeController($this->twig))->index(),

            // Offres
            $uri === '/offres' && $method === 'GET'
                => (new OffreController($this->twig))->index(),

            preg_match('#^/offres/(\d+)$#', $uri, $m) && $method === 'GET'
                => (new OffreController($this->twig))->show((int)$m[1]),

            // Entreprises
            $uri === '/entreprises' && $method === 'GET'
                => (new EntrepriseController($this->twig))->index(),

                // --- CRUD entreprises (admin) ---
            $uri === '/entreprises/create' && $method === 'GET'
                => (new EntrepriseController($this->twig))->createForm(),

            $uri === '/entreprises/create' && $method === 'POST'
                => (new EntrepriseController($this->twig))->store(),

            preg_match('#^/entreprises/(\d+)/edit$#', $uri, $m) && $method === 'GET'
                => (new EntrepriseController($this->twig))->editForm((int)$m[1]),

            preg_match('#^/entreprises/(\d+)/edit$#', $uri, $m) && $method === 'POST'
                => (new EntrepriseController($this->twig))->update((int)$m[1]),

            preg_match('#^/entreprises/(\d+)/delete$#', $uri, $m) && $method === 'POST'
                => (new EntrepriseController($this->twig))->destroy((int)$m[1]),

            preg_match('#^/entreprises/(\d+)$#', $uri, $m) && $method === 'GET'
                => (new EntrepriseController($this->twig))->show((int)$m[1]),

            // Auth
            $uri === '/connexion' && $method === 'GET'
                => (new AuthController($this->twig))->loginForm(),

            $uri === '/connexion' && $method === 'POST'
                => (new AuthController($this->twig))->login(),

            $uri === '/inscription' && $method === 'POST'
                => (new AuthController($this->twig))->register(),

            $uri === '/deconnexion'
                => (new AuthController($this->twig))->logout(),

            // Dashboard
            $uri === '/dashboard' && $method === 'GET'
                => $this->handleDashboard(''),
    
            $uri === '/dashboard/users' && $method === 'GET'
                => $this->handleDashboard('users'),
                
            $uri === '/dashboard/entreprises' && $method === 'GET'
                => $this->handleDashboard('entreprises'),
                
            $uri === '/dashboard/offres' && $method === 'GET'
                => $this->handleDashboard('offres'),
            
            // Candidatures
            $uri === '/dashboard/candidatures' && $method === 'GET'
                => (new HistoriqueController($this->twig))->index(),

            // Wishlist
            $uri === '/dashboard/wishlist' && $method === 'GET'
                => (new WishlistController($this->twig))->index(),

            $uri === '/dashboard/wishlist/add' && $method === 'POST'
                => (new WishlistController($this->twig))->add(),

            $uri === '/dashboard/wishlist/remove' && $method === 'POST'
                => (new WishlistController($this->twig))->remove(),

            // Profil
            $uri === '/profil' && $method === 'GET'
                => (new ProfilController($this->twig))->index(),

            $uri === '/profil/update' && $method === 'POST'
                => (new ProfilController($this->twig))->update(),

            $uri === '/profil/password' && $method === 'POST'
                => (new ProfilController($this->twig))->password(),

            // Postuler
            $uri === '/postuler' && $method === 'GET'
                => (new CandidatureController($this->twig))->form(),

            $uri === '/postuler' && $method === 'POST'
                => (new CandidatureController($this->twig))->submit(),

            // Mentions légales
            $uri === '/mentions-legales' && $method === 'GET'
                => (new HomeController($this->twig))->mentions(),

                

            // 404
            default => $this->notFound(),
        };
    }

    private function notFound(): void
    {
        http_response_code(404);
        echo $this->twig->render('errors/404.html.twig');
    }
}