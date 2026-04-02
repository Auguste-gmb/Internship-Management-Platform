<?php
declare(strict_types=1);

namespace App\Core;


final class Auth
{

    public const ROLE_ETUDIANT      = 'student';
    public const ROLE_PILOTE        = 'tutor';
    public const ROLE_ADMINISTRATOR = 'administrator';

    private const HIERARCHY = [
        self::ROLE_ETUDIANT      => 1,
        self::ROLE_PILOTE        => 2,
        self::ROLE_ADMINISTRATOR => 3,
    ];

    private const PERMISSIONS = [
        // Dashboard personnel
        'dashboard.view'            => self::ROLE_ETUDIANT,

        // Profil
        'profil.view'               => self::ROLE_ETUDIANT,
        'profil.edit'               => self::ROLE_ETUDIANT,

        // Candidatures & wishlist
        'candidature.submit'        => self::ROLE_ETUDIANT,
        'wishlist.manage'           => self::ROLE_ETUDIANT,

        // Historique
        'historique.view'           => self::ROLE_ETUDIANT,

        // Gestion offres (pilote+)
        'offre.create'              => self::ROLE_PILOTE,
        'offre.edit'                => self::ROLE_PILOTE,
        'offre.delete'              => self::ROLE_PILOTE,

        // Administration (admin uniquement)
        'admin.dashboard'           => self::ROLE_ADMINISTRATOR,
        'admin.users'               => self::ROLE_ADMINISTRATOR,
        'admin.users.edit'          => self::ROLE_ADMINISTRATOR,
        'admin.users.delete'        => self::ROLE_ADMINISTRATOR,
        'admin.entreprises'         => self::ROLE_ADMINISTRATOR,
        'admin.entreprises.create'  => self::ROLE_ADMINISTRATOR,
        'admin.entreprises.edit'    => self::ROLE_ADMINISTRATOR,
        'admin.entreprises.delete'  => self::ROLE_ADMINISTRATOR,
        'admin.offres'              => self::ROLE_ADMINISTRATOR,
    ];


    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function check(): bool
    {
        return !empty($_SESSION['user']);
    }

    public static function role(): ?string
    {
        return $_SESSION['user']['role'] ?? null;
    }

    public static function id(): ?int
    {
        return isset($_SESSION['user']['id']) ? (int) $_SESSION['user']['id'] : null;
    }


    public static function hasRole(string $minimumRole): bool
    {
        $currentRole = self::role();
        if ($currentRole === null) {
            return false;
        }

        $currentLevel = self::HIERARCHY[$currentRole]  ?? 0;
        $requiredLevel = self::HIERARCHY[$minimumRole] ?? 0;

        return $currentLevel >= $requiredLevel;
    }


    public static function can(string $permission): bool
    {
        if (!self::check()) {
            return false;
        }

        $requiredRole = self::PERMISSIONS[$permission] ?? null;

        if ($requiredRole === null) {
            return true;
        }

        return self::hasRole($requiredRole);
    }


    public static function requireAuth(): void
    {
        if (!self::check()) {
            header('Location: /connexion');
            exit;
        }
    }


    public static function requireRole(string $minimumRole): void
    {
        self::requireAuth();

        if (!self::hasRole($minimumRole)) {
            http_response_code(403);
            throw new \RuntimeException('Accès refusé : rôle insuffisant.', 403);
        }
    }


    public static function requirePermission(string $permission): void
    {
        self::requireAuth();

        if (!self::can($permission)) {
            http_response_code(403);
            throw new \RuntimeException("Accès refusé : permission '$permission' requise.", 403);
        }
    }


    public static function login(array $user): void
    {
        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id'     => $user['id_user'],
            'email'  => $user['email'],
            'prenom' => $user['first_name'],
            'nom'    => $user['name'],
            'role'   => $user['role_name'],
        ];
    }

    public static function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(
                session_name(), '', time() - 42000,
                $p['path'], $p['domain'], $p['secure'], $p['httponly']
            );
        }
        session_destroy();
    }
}