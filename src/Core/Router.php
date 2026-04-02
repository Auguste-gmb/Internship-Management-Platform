<?php
declare(strict_types=1);

namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

use App\Controller\HomeController;
use App\Controller\OffreController;
use App\Controller\EntrepriseController;
use App\Controller\AuthController;
use App\Controller\DashboardController;
use App\Controller\CandidatureController;
use App\Controller\ProfilController;
use App\Controller\WishlistController;
use App\Controller\HistoriqueController;
use App\Controller\LegalController;


class Router
{
    private readonly Environment $twig;
    private array $routes = [];

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader, [
            'cache' => false, // En production : __DIR__ . '/../../cache'
            'debug' => true,
        ]);
        

        $this->twig->addFunction(new TwigFunction('path', function (string $route, array $params = []): string {
            $query = http_build_query($params);
            return "/$route" . ($query ? "?$query" : '');
        }));

        $this->twig->addFunction(new TwigFunction('auth_can', function (string $permission): bool {
            return Auth::can($permission);
        }));

        $this->twig->addFunction(new TwigFunction('auth_has_role', function (string $role): bool {
            return Auth::hasRole($role);
        }));

        $this->twig->addFunction(new TwigFunction('auth_check', function (): bool {
            return Auth::check();
        }));

        
        if (Auth::check()) {
            $this->twig->addGlobal('app_user', Auth::user());
        }
    }
    
    private function get(string $pattern, array $handler): void
    {
        $this->routes[] = ['GET', $pattern, $handler];
    }

    private function post(string $pattern, array $handler): void
    {
        $this->routes[] = ['POST', $pattern, $handler];
    }

    private function any(string $pattern, array $handler): void
    {
        $this->routes[] = ['ANY', $pattern, $handler];
    }

    private function registerRoutes(): void
    {
        // Pages publiques
        $this->get('/',                  [HomeController::class, 'index']);
        $this->get('/mentions-legales', [LegalController::class, 'mentions']);

        // Offres 
        $this->get('/offres',            [OffreController::class, 'index']);
        $this->get('#^/offres/(\d+)$#',  [OffreController::class, 'show']);

        
        // Formulaire de création / édition d'une offre (pilote/admin)
        $this->get('/offres/create',        [OffreController::class, 'form']);
        $this->post('/offres/create',       [OffreController::class, 'submit']);
        $this->get('#^/offres/(\d+)/edit$#',[OffreController::class, 'form']);
        $this->post('#^/offres/(\d+)/edit$#',[OffreController::class, 'submit']);

        // Entreprises
        $this->get('/entreprises',                        [EntrepriseController::class, 'index']);
        $this->get('/entreprises/create',                 [EntrepriseController::class, 'createForm']);
        $this->post('/entreprises/create',                [EntrepriseController::class, 'store']);
        $this->get('#^/entreprises/(\d+)/edit$#',         [EntrepriseController::class, 'editForm']);
        $this->post('#^/entreprises/(\d+)/edit$#',        [EntrepriseController::class, 'update']);
        $this->post('#^/entreprises/(\d+)/delete$#',      [EntrepriseController::class, 'destroy']);
        $this->get('#^/entreprises/(\d+)$#',              [EntrepriseController::class, 'show']);

        // Auth
        $this->get('/connexion',   [AuthController::class, 'loginForm']);
        $this->post('/connexion',  [AuthController::class, 'login']);
        $this->post('/inscription',[AuthController::class, 'register']);
        $this->any('/deconnexion', [AuthController::class, 'logout']);

        // Dashboard
        $this->get('/dashboard',              [DashboardController::class, 'index']);
        $this->get('/dashboard/users',        [DashboardController::class, 'adminUsers']);
        $this->get('/dashboard/entreprises',  [DashboardController::class, 'adminEntreprises']);
        $this->get('/dashboard/offres',       [DashboardController::class, 'adminOffres']);

        // Candidatures & historique
        $this->get('/dashboard/candidatures', [HistoriqueController::class, 'index']);
        $this->get('/postuler',               [CandidatureController::class, 'form']);
        $this->post('/postuler',              [CandidatureController::class, 'submit']);

        // Wishlist
        $this->get('/dashboard/wishlist',         [WishlistController::class, 'index']);
        $this->post('/dashboard/wishlist/add',    [WishlistController::class, 'add']);
        $this->post('/dashboard/wishlist/remove', [WishlistController::class, 'remove']);

        // Profil
        $this->get('/profil',             [ProfilController::class, 'index']);
        $this->post('/profil/update',     [ProfilController::class, 'update']);
        $this->post('/profil/password',   [ProfilController::class, 'password']);
    }

    public function dispatch(): void
    {
        if (Auth::check()) {
            $this->twig->addGlobal('app_user', Auth::user());
        }

        $this->registerRoutes();

        $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri    = rtrim($uri, '/') ?: '/';
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as [$routeMethod, $pattern, $handler]) {
            if ($routeMethod !== 'ANY' && $routeMethod !== $method) {
                continue;
            }

            $params = [];
            if (str_starts_with($pattern, '#')) {
                if (!preg_match($pattern, $uri, $matches)) {
                    continue;
                }
                $params = array_slice($matches, 1);
            } else {
                if ($uri !== $pattern) {
                    continue;
                }
            }

            [$controllerClass, $action] = $handler;
            $controller = new $controllerClass($this->twig);

            try {
                $params = array_map(fn($p) => is_numeric($p) ? (int)$p : $p, $params);
                $controller->$action(...$params);
            } catch (\RuntimeException $e) {
                if ($e->getCode() === 403) {
                    http_response_code(403);
                    if ($this->twig->getLoader()->exists('errors/403.html.twig')) {
                        echo $this->twig->render('errors/403.html.twig');
                    } else {
                        echo '<h1>403 — Accès refusé</h1>';
                    }
                }
            }
            return;
        }
        http_response_code(404);
        if ($this->twig->getLoader()->exists('errors/404.html.twig')) {
            echo $this->twig->render('errors/404.html.twig');
        } else {
            echo '<h1>404 — Page introuvable</h1>';
        }
    }
}