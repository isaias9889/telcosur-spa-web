<?php
require __DIR__ . '/db.php';

$registros = $pdo->query('SELECT fecha_consulta, nombre, telefono, comuna, plan_interes, mensaje FROM consultas_planes ORDER BY fecha_consulta DESC')->fetchAll();

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=consultas_planes_telcosur.csv');

$salida = fopen('php://output', 'w');
fprintf($salida, chr(0xEF) . chr(0xBB) . chr(0xBF));
fputcsv($salida, ['Fecha', 'Nombre', 'Teléfono', 'Comuna', 'Plan de interés', 'Mensaje'], ';');

foreach ($registros as $fila) {
    fputcsv($salida, $fila, ';');
}

fclose($salida);
