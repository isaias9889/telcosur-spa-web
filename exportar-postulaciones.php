<?php
require __DIR__ . '/db.php';

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

$registros = $pdo->query('SELECT fecha_postulacion, nombre, rut, telefono, correo, comuna, cargo, experiencia, disponibilidad, estado, cv_archivo, mensaje FROM postulaciones ORDER BY fecha_postulacion DESC')->fetchAll();

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=postulaciones_telcosur.csv');

$salida = fopen('php://output', 'w');
fprintf($salida, chr(0xEF) . chr(0xBB) . chr(0xBF));
fputcsv($salida, ['Fecha', 'Nombre', 'RUT', 'Teléfono', 'Correo', 'Comuna', 'Experiencia', 'Disponibilidad', 'Mensaje'], ';');

foreach ($registros as $fila) {
    fputcsv($salida, $fila, ';');
}

fclose($salida);
