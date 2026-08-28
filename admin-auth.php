<?php
require_once __DIR__ . '/security.php';

function adminConfig(): array
{
    securityStartSession();
    $path = __DIR__ . '/admin-config.php';

    if (!is_file($path)) {
        http_response_code(500);
        exit('Configuración de administrador no encontrada. Copia admin-config.example.php como admin-config.php.');
    }

    return require $path;
}

function adminIsLoggedIn(): bool
{
    securityStartSession();

    return !empty($_SESSION['admin_logged_in']);
}

function adminRequireLogin(): void
{
    if (adminIsLoggedIn()) {
        return;
    }

    $requestUri = $_SERVER['REQUEST_URI'] ?? 'postulaciones.php';
    $redirect = rawurlencode($requestUri);

    header('Location: admin-login.php?redirect=' . $redirect);
    exit;
}

function adminAttemptLogin(string $username, string $password): bool
{
    securityStartSession();
    $config = adminConfig();

    if (!hash_equals($config['username'], $username)) {
        return false;
    }

    if (!password_verify($password, $config['password_hash'])) {
        return false;
    }

    session_regenerate_id(true);
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_username'] = $config['username'];

    return true;
}

function adminLogout(): void
{
    securityStartSession();
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();
}

function adminSafeRedirect(string $redirect): string
{
    if ($redirect === '' || str_contains($redirect, '://') || str_starts_with($redirect, '//')) {
        return 'postulaciones.php';
    }

    return $redirect;
}
