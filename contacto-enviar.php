<?php
require __DIR__ . '/security.php';
$pdo = require __DIR__ . '/db.php';

securityHeaders();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contacto.php');
    exit;
}

if (!csrfValidate($_POST['csrf_token'] ?? null)) {
    header('Location: resultado.php?tipo=contacto&estado=csrf');
    exit;
}

if (!rateLimitAllow('contacto', 5, 900)) {
    header('Location: resultado.php?tipo=contacto&estado=limit');
    exit;
}

if (honeypotDisparado()) {
    header('Location: resultado.php?tipo=contacto&estado=ok');
    exit;
}

turnstileCheckOrRedirect('contacto');

$nombre = sanitizarTexto($_POST['nombre'] ?? '', 120);
$telefono = sanitizarTexto($_POST['telefono'] ?? '', 30);
$comuna = sanitizarTexto($_POST['comuna'] ?? 'No indicada', 100);
$asunto = sanitizarTexto($_POST['asunto'] ?? '', 120);
$correo = sanitizarTexto($_POST['correo'] ?? '', 120);
$mensajeUsuario = sanitizarTexto($_POST['mensaje'] ?? '', 2000);

if ($nombre === '' || $telefono === '' || $asunto === '' || $mensajeUsuario === '') {
    header('Location: resultado.php?tipo=contacto&estado=error');
    exit;
}

if (!validarTelefonoChile($telefono)) {
    header('Location: resultado.php?tipo=contacto&estado=error');
    exit;
}

$mensaje = $mensajeUsuario;
if ($correo !== '') {
    $mensaje = 'Email: ' . $correo . "\n\n" . $mensaje;
}

$stmt = $pdo->prepare(
    'INSERT INTO consultas_planes (nombre, telefono, comuna, plan_interes, mensaje)
     VALUES (:nombre, :telefono, :comuna, :plan_interes, :mensaje)'
);

$stmt->execute([
    ':nombre' => $nombre,
    ':telefono' => $telefono,
    ':comuna' => $comuna,
    ':plan_interes' => 'Contacto: ' . $asunto,
    ':mensaje' => $mensaje,
]);

require __DIR__ . '/includes/mailer.php';
enviarNotificacion('Nuevo mensaje de contacto: ' . $asunto, [
    'Nombre' => $nombre,
    'Teléfono' => $telefono,
    'Correo' => $correo,
    'Comuna' => $comuna,
    'Asunto' => $asunto,
    'Mensaje' => $mensajeUsuario,
], $correo !== '' ? $correo : null, $nombre);

if ($correo !== '') {
    enviarConfirmacionUsuario(
        $correo,
        $nombre,
        'Recibimos tu mensaje — TelcoSur SPA',
        'Gracias por contactarnos. Hemos recibido tu mensaje sobre "' . $asunto . '" y te responderemos en días hábiles.'
    );
}

header('Location: resultado.php?tipo=contacto&estado=ok');
exit;
