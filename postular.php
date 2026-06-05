<?php
require __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: trabaja-con-nosotros.php#postulacion');
    exit;
}

$nombre = trim($_POST['nombre'] ?? '');
$rut = trim($_POST['rut'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$comuna = trim($_POST['comuna'] ?? '');
$cargo = trim($_POST['cargo'] ?? 'Ejecutivo comercial');
$experiencia = trim($_POST['experiencia'] ?? '');
$disponibilidad = trim($_POST['disponibilidad'] ?? '');
$mensaje = trim($_POST['mensaje'] ?? '');

if ($nombre === '' || $rut === '' || $telefono === '' || $correo === '' || $comuna === '' || $cargo === '' || $experiencia === '' || $disponibilidad === '') {
    header('Location: resultado.php?tipo=postulacion&estado=error');
    exit;
}

$columnas = $pdo->query("SHOW COLUMNS FROM postulaciones")->fetchAll(PDO::FETCH_COLUMN);
$columnasExistentes = array_flip($columnas);

if (!isset($columnasExistentes['cargo'])) {
    $pdo->exec("ALTER TABLE postulaciones ADD cargo VARCHAR(120) DEFAULT 'Ejecutivo comercial' AFTER disponibilidad");
}

if (!isset($columnasExistentes['cv_archivo'])) {
    $pdo->exec("ALTER TABLE postulaciones ADD cv_archivo VARCHAR(255) NULL AFTER cargo");
}

if (!isset($columnasExistentes['estado'])) {
    $pdo->exec("ALTER TABLE postulaciones ADD estado VARCHAR(40) DEFAULT 'Recibida' AFTER cv_archivo");
}

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
