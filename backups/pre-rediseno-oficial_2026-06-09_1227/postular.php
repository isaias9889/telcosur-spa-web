<?php
require __DIR__ . '/security.php';
require __DIR__ . '/db.php';

securityHeaders();

$cargosPermitidos = [
    'Ejecutivo comercial',
    'Ejecutivo comercial terreno',
    'Asesor de planes hogar',
    'Supervisor en venta',
];

$experienciasPermitidas = [
    'sin-experiencia',
    'menos-1',
    '1-3',
    'mas-3',
];

$disponibilidadesPermitidas = [
    'part-time',
    'full-time',
    'flexible',
];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: trabaja-con-nosotros.php#postulacion');
    exit;
}

if (!csrfValidate($_POST['csrf_token'] ?? null)) {
    header('Location: resultado.php?tipo=postulacion&estado=csrf');
    exit;
}

if (!rateLimitAllow('postulacion', 3, 1800)) {
    header('Location: resultado.php?tipo=postulacion&estado=limit');
    exit;
}

$nombre = sanitizarTexto($_POST['nombre'] ?? '', 120);
$rut = sanitizarTexto($_POST['rut'] ?? '', 20);
$telefono = sanitizarTexto($_POST['telefono'] ?? '', 30);
$correo = sanitizarTexto($_POST['correo'] ?? '', 120);
$comuna = sanitizarTexto($_POST['comuna'] ?? '', 100);
$cargo = sanitizarTexto($_POST['cargo'] ?? 'Ejecutivo comercial', 120);

if ($cargo === '') {
    $cargo = 'Ejecutivo comercial';
}
$experiencia = sanitizarTexto($_POST['experiencia'] ?? '', 80);
$disponibilidad = sanitizarTexto($_POST['disponibilidad'] ?? '', 80);
$mensaje = sanitizarTexto($_POST['mensaje'] ?? '', 2000);

if (
    $nombre === '' ||
    $rut === '' ||
    $telefono === '' ||
    $correo === '' ||
    $comuna === '' ||
    $cargo === '' ||
    $experiencia === '' ||
    $disponibilidad === ''
) {
    header('Location: resultado.php?tipo=postulacion&estado=error');
    exit;
}

if (
    !validarRutChile($rut) ||
    !validarTelefonoChile($telefono) ||
    !validarEmail($correo) ||
    !valorPermitido($cargo, $cargosPermitidos) ||
    !valorPermitido($experiencia, $experienciasPermitidas) ||
    !valorPermitido($disponibilidad, $disponibilidadesPermitidas)
) {
    header('Location: resultado.php?tipo=postulacion&estado=error');
    exit;
}

require __DIR__ . '/includes/schema.php';
ensurePostulacionesSchema($pdo);

$cvArchivo = null;

if (isset($_FILES['cv']) && $_FILES['cv']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['cv']['error'] !== UPLOAD_ERR_OK || $_FILES['cv']['size'] > 5 * 1024 * 1024) {
        header('Location: resultado.php?tipo=postulacion&estado=error');
        exit;
    }

    $extension = strtolower(pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION));
    $extensionesPermitidas = ['pdf', 'doc', 'docx'];

    if (!in_array($extension, $extensionesPermitidas, true)) {
        header('Location: resultado.php?tipo=postulacion&estado=error');
        exit;
    }

    $directorioCv = __DIR__ . '/uploads/cv';

    if (!is_dir($directorioCv)) {
        mkdir($directorioCv, 0755, true);
    }

    $cvArchivo = 'cv_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
    $destino = $directorioCv . '/' . $cvArchivo;

    if (!move_uploaded_file($_FILES['cv']['tmp_name'], $destino)) {
        header('Location: resultado.php?tipo=postulacion&estado=error');
        exit;
    }
}

$stmt = $pdo->prepare(
    'INSERT INTO postulaciones (nombre, rut, telefono, correo, comuna, experiencia, disponibilidad, cargo, cv_archivo, estado, mensaje)
     VALUES (:nombre, :rut, :telefono, :correo, :comuna, :experiencia, :disponibilidad, :cargo, :cv_archivo, :estado, :mensaje)'
);

$stmt->execute([
    ':nombre' => $nombre,
    ':rut' => $rut,
    ':telefono' => $telefono,
    ':correo' => $correo,
    ':comuna' => $comuna,
    ':experiencia' => $experiencia,
    ':disponibilidad' => $disponibilidad,
    ':cargo' => $cargo,
    ':cv_archivo' => $cvArchivo,
    ':estado' => 'Recibida',
    ':mensaje' => $mensaje,
]);

header('Location: resultado.php?tipo=postulacion&estado=ok');
exit;
