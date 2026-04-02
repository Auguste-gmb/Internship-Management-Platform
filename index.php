<?php
declare(strict_types=1);


require_once __DIR__ . '/vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}


if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => isset($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig   = new \Twig\Environment($loader, [
    'cache'       => __DIR__ . '/var/cache/twig',
    'auto_reload' => true,
    'debug'       => ($_ENV['APP_ENV'] ?? 'prod') === 'dev',
]);


if (($_ENV['APP_ENV'] ?? 'prod') === 'dev') {
    $twig->addExtension(new \Twig\Extension\DebugExtension());
}

$twig->addFunction(new \Twig\TwigFunction('auth_can', [\App\Core\Auth::class, 'can']));
$twig->addFunction(new \Twig\TwigFunction('auth_role', [\App\Core\Auth::class, 'hasRole']));


(new \App\Core\Router($twig))->dispatch();