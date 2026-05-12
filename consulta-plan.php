<?php
require __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html#consulta-plan');
    exit;
}

$nombre = trim($_POST['nombre'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$comuna = trim($_POST['comuna'] ?? '');
$planInteres = trim($_POST['plan_interes'] ?? '');
$mensaje = trim($_POST['mensaje'] ?? '');

if ($nombre === '' || $telefono === '' || $comuna === '' || $planInteres === '') {
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
