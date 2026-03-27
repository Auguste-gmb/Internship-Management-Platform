<?php
declare(strict_types=1);

namespace App\Router;

use Twig\Environment;
use App\Controller\HomeController;
use App\Controller\OffreController;
use App\Controller\EntrepriseController;
use App\Controller\AuthController;
use App\Controller\DashboardController;
use App\Controller\CandidatureController;

class Router
{
    public function __construct(private Environment $twig) {}

    public function dispatch(): void
    {
        $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri    = rtrim($uri, '/') ?: '/';
        $method = $_SERVER['REQUEST_METHOD'];

        match (true) {
            $uri === '/' && $method === 'GET'
                => (new HomeController($this->twig))->index(),

            $uri === '/offres' && $method === 'GET'
                => (new OffreController($this->twig))->index(),

            preg_match('#^/offres/(\d+)$#', $uri, $m) && $method === 'GET'
                => (new OffreController($this->twig))->show((int)$m[1]),

            $uri === '/entreprises' && $method === 'GET'
                => (new EntrepriseController($this->twig))->index(),

            preg_match('#^/entreprises/(\d+)$#', $uri, $m) && $method === 'GET'
                => (new EntrepriseController($this->twig))->show((int)$m[1]),

            $uri === '/connexion' && $method === 'GET'
                => (new AuthController($this->twig))->loginForm(),

            $uri === '/connexion' && $method === 'POST'
                => (new AuthController($this->twig))->login(),

            $uri === '/inscription' && $method === 'POST'
                => (new AuthController($this->twig))->register(),

            $uri === '/deconnexion'
                => (new AuthController($this->twig))->logout(),

            $uri === '/dashboard' && $method === 'GET'
                => (new DashboardController($this->twig))->index(),

            $uri === '/postuler' && $method === 'GET'
                => (new CandidatureController($this->twig))->form(),

            $uri === '/postuler' && $method === 'POST'
                => (new CandidatureController($this->twig))->submit(),

            $uri === '/mentions-legales' && $method === 'GET'
                => (new HomeController($this->twig))->mentions(),

            default => $this->notFound(),
        };
    }

    private function notFound(): void
    {
        http_response_code(404);
        echo $this->twig->render('errors/404.html.twig');
    }
}