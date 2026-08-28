<?php
require_once __DIR__ . '/includes/site-config.php';

function securityStartSession(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start([
            'cookie_httponly' => true,
            'cookie_samesite' => 'Lax',
        ]);
    }
}

function securityHeaders(): void
{
    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
}

function csrfToken(): string
{
    securityStartSession();

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') . '">';
}

function csrfValidate(?string $token): bool
{
    securityStartSession();

    if ($token === null || $token === '' || empty($_SESSION['csrf_token'])) {
        return false;
    }

    return hash_equals($_SESSION['csrf_token'], $token);
}

function clientIp(): string
{
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

/**
 * Campo trampa anti-spam. Los bots rellenan campos ocultos; un humano no.
 * Devuelve true si el campo trampa viene con contenido (probable bot).
 */
function honeypotDisparado(): bool
{
    return trim((string) ($_POST['sitio_web'] ?? '')) !== '';
}

function rateLimitAllow(string $scope, int $maxAttempts, int $windowSeconds): bool
{
    $storageDir = __DIR__ . '/storage/rate-limit';

    if (!is_dir($storageDir)) {
        mkdir($storageDir, 0755, true);
    }

    $file = $storageDir . '/' . hash('sha256', $scope . '|' . clientIp()) . '.json';
    $now = time();
    $attempts = [];

    if (is_file($file)) {
        $decoded = json_decode((string) file_get_contents($file), true);

        if (is_array($decoded) && isset($decoded['attempts']) && is_array($decoded['attempts'])) {
            $attempts = $decoded['attempts'];
        }
    }

    $attempts = array_values(array_filter(
        $attempts,
        static fn ($timestamp) => is_int($timestamp) && $timestamp > ($now - $windowSeconds)
    ));

    if (count($attempts) >= $maxAttempts) {
        return false;
    }

    $attempts[] = $now;
    file_put_contents($file, json_encode(['attempts' => $attempts]), LOCK_EX);

    return true;
}

function sanitizarTexto(string $texto, int $maxLength): string
{
    $texto = trim($texto);

    if ($texto === '') {
        return '';
    }

    if (function_exists('mb_strlen') && function_exists('mb_substr')) {
        if (mb_strlen($texto) > $maxLength) {
            return mb_substr($texto, 0, $maxLength);
        }

        return $texto;
    }

    if (strlen($texto) > $maxLength) {
        return substr($texto, 0, $maxLength);
    }

    return $texto;
}

function validarTelefonoChile(string $telefono): bool
{
    $digits = preg_replace('/\D+/', '', $telefono) ?? '';

    if ($digits === '') {
        return false;
    }

    if (preg_match('/^9\d{8}$/', $digits)) {
        return true;
    }

    if (preg_match('/^569\d{8}$/', $digits)) {
        return true;
    }

    return strlen($digits) >= 8 && strlen($digits) <= 12;
}

function validarEmail(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validarRutChile(string $rut): bool
{
    $rut = strtoupper(preg_replace('/[^0-9K]/', '', $rut) ?? '');

    if (strlen($rut) < 2) {
        return false;
    }

    $dv = substr($rut, -1);
    $numero = substr($rut, 0, -1);

    if ($numero === '' || !ctype_digit($numero)) {
        return false;
    }

    $suma = 0;
    $multiplo = 2;

    for ($i = strlen($numero) - 1; $i >= 0; $i--) {
        $suma += (int) $numero[$i] * $multiplo;
        $multiplo = $multiplo === 7 ? 2 : $multiplo + 1;
    }

    $resto = 11 - ($suma % 11);

    if ($resto === 11) {
        $dvEsperado = '0';
    } elseif ($resto === 10) {
        $dvEsperado = 'K';
    } else {
        $dvEsperado = (string) $resto;
    }

    return $dv === $dvEsperado;
}

function valorPermitido(string $valor, array $permitidos): bool
{
    return in_array($valor, $permitidos, true);
}
