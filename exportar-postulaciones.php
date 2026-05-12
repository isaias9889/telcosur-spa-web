<?php
require __DIR__ . '/db.php';

$registros = $pdo->query('SELECT fecha_postulacion, nombre, rut, telefono, correo, comuna, experiencia, disponibilidad, mensaje FROM postulaciones ORDER BY fecha_postulacion DESC')->fetchAll();

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=postulaciones_telcosur.csv');

$salida = fopen('php://output', 'w');
fprintf($salida, chr(0xEF) . chr(0xBB) . chr(0xBF));
fputcsv($salida, ['Fecha', 'Nombre', 'RUT', 'Teléfono', 'Correo', 'Comuna', 'Experiencia', 'Disponibilidad', 'Mensaje'], ';');

foreach ($registros as $fila) {
    fputcsv($salida, $fila, ';');
}

fclose($salida);
