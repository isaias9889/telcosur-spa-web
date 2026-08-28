<?php
require __DIR__ . '/admin-auth.php';
adminRequireLogin();
require __DIR__ . '/db.php';

require __DIR__ . '/includes/schema.php';
ensurePostulacionesSchema($pdo);

$registros = $pdo->query('SELECT fecha_postulacion, nombre, rut, telefono, correo, comuna, cargo, experiencia, disponibilidad, estado, cv_archivo, mensaje FROM postulaciones ORDER BY fecha_postulacion DESC')->fetchAll();

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=postulaciones_telcosur.csv');

$salida = fopen('php://output', 'w');
fprintf($salida, chr(0xEF) . chr(0xBB) . chr(0xBF));
fputcsv($salida, ['Fecha', 'Nombre', 'RUT', 'Teléfono', 'Correo', 'Comuna', 'Cargo', 'Experiencia', 'Disponibilidad', 'Estado', 'CV', 'Mensaje'], ';');

foreach ($registros as $fila) {
    fputcsv($salida, $fila, ';');
}

fclose($salida);
