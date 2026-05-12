<?php
require __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html#postulacion');
    exit;
}

$nombre = trim($_POST['nombre'] ?? '');
$rut = trim($_POST['rut'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$comuna = trim($_POST['comuna'] ?? '');
$experiencia = trim($_POST['experiencia'] ?? '');
$disponibilidad = trim($_POST['disponibilidad'] ?? '');
$mensaje = trim($_POST['mensaje'] ?? '');

if ($nombre === '' || $rut === '' || $telefono === '' || $correo === '' || $comuna === '' || $experiencia === '' || $disponibilidad === '') {
    header('Location: resultado.php?tipo=postulacion&estado=error');
    exit;
}

$stmt = $pdo->prepare(
    'INSERT INTO postulaciones (nombre, rut, telefono, correo, comuna, experiencia, disponibilidad, mensaje)
     VALUES (:nombre, :rut, :telefono, :correo, :comuna, :experiencia, :disponibilidad, :mensaje)'
);

$stmt->execute([
    ':nombre' => $nombre,
    ':rut' => $rut,
    ':telefono' => $telefono,
    ':correo' => $correo,
    ':comuna' => $comuna,
    ':experiencia' => $experiencia,
    ':disponibilidad' => $disponibilidad,
    ':mensaje' => $mensaje,
]);

header('Location: resultado.php?tipo=postulacion&estado=ok');
exit;
