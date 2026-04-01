<?php
    declare(strict_types=1);

    // à retier (pour afficher les erreur)
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once __DIR__ . '/vendor/autoload.php';

    use App\Core\Router;

    session_start();

    $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
    $twig   = new \Twig\Environment($loader, [
        'cache' => false,
        'debug' => true,
    ]);
    $twig->addExtension(new \Twig\Extension\DebugExtension());

    $router = new Router($twig);
    $router->dispatch();
?>