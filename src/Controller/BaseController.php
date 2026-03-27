<?php
declare(strict_types=1);

namespace App\Controller;

use Twig\Environment;

abstract class BaseController
{
    public function __construct(protected Environment $twig) {}

    /** Raccourci : rend un template Twig */
    protected function render(string $template, array $data = []): void
    {
        echo $this->twig->render($template, $data);
    }

    /** Redirige vers une URL */
    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    /** Vérifie que l'utilisateur est connecté, sinon redirige */
    protected function requireAuth(): void
    {
        if (empty($_SESSION['user'])) {
            $this->redirect('/connexion');
        }
    }
}
?>