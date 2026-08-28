<?php
require __DIR__ . '/security.php';
require __DIR__ . '/db.php';

securityHeaders();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php#consulta-plan');
    exit;
}

if (!csrfValidate($_POST['csrf_token'] ?? null)) {
    header('Location: resultado.php?tipo=consulta&estado=csrf');
    exit;
}

if (!rateLimitAllow('consulta-plan', 5, 900)) {
    header('Location: resultado.php?tipo=consulta&estado=limit');
    exit;
}

$nombre = sanitizarTexto($_POST['nombre'] ?? '', 120);
$telefono = sanitizarTexto($_POST['telefono'] ?? '', 30);
$comuna = sanitizarTexto($_POST['comuna'] ?? '', 100);
$planInteres = sanitizarTexto($_POST['plan_interes'] ?? '', 160);
$mensaje = sanitizarTexto($_POST['mensaje'] ?? '', 2000);

if ($nombre === '' || $telefono === '' || $comuna === '' || $planInteres === '') {
    header('Location: resultado.php?tipo=consulta&estado=error');
    exit;
}

if (!validarTelefonoChile($telefono)) {
    header('Location: resultado.php?tipo=consulta&estado=error');
    exit;
}

$stmt = $pdo->prepare(
    'INSERT INTO consultas_planes (nombre, telefono, comuna, plan_interes, mensaje)
     VALUES (:nombre, :telefono, :comuna, :plan_interes, :mensaje)'
);

$stmt->execute([
    ':nombre' => $nombre,
    ':telefono' => $telefono,
    ':comuna' => $comuna,
    ':plan_interes' => $planInteres,
    ':mensaje' => $mensaje,
]);

header('Location: resultado.php?tipo=consulta&estado=ok');
exit;
