<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Router\Router;

session_start();

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig   = new \Twig\Environment($loader, [
    'cache' => false, // mettre __DIR__ . '/cache' en prod
    'debug' => true,
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

$router = new Router($twig);
$router->dispatch();

?>
