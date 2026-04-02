<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Auth;
use Twig\Environment;



abstract class BaseController
{
    public function __construct(protected Environment $twig) {}


    protected function render(string $template, array $data = []): void
    {
        echo $this->twig->render($template, $data);
    }

    protected function redirect(string $url): never
    {
        header('Location: ' . $url);
        exit;
    }


    protected function requireAuth(): void
    {
        Auth::requireAuth();
    }

    protected function requireRole(string $minimumRole): void
    {
        try {
            Auth::requireRole($minimumRole);
        } catch (\RuntimeException $e) {
            $this->renderError(403);
        }
    }


    protected function requirePermission(string $permission): void
    {
        try {
            Auth::requirePermission($permission);
        } catch (\RuntimeException $e) {
            $this->renderError(403);
        }
    }

    protected function renderError(int $code): never
    {
        http_response_code($code);
        $template = match ($code) {
            403     => 'errors/403.html.twig',
            404     => 'errors/404.html.twig',
            default => 'errors/500.html.twig',
        };

        // Fallback si le template n'existe pas
        if (!$this->twig->getLoader()->exists($template)) {
            echo "<h1>Erreur $code</h1>";
            exit;
        }

        echo $this->twig->render($template, ['code' => $code]);
        exit;
    }
}