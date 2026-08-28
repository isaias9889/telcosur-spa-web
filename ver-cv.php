<?php
require __DIR__ . '/admin-auth.php';

adminRequireLogin();

$archivo = basename($_GET['f'] ?? '');

if ($archivo === '' || !preg_match('/^cv_[A-Za-z0-9._-]+$/', $archivo)) {
    http_response_code(404);
    exit('CV no encontrado.');
}

$ruta = __DIR__ . '/uploads/cv/' . $archivo;

if (!is_file($ruta)) {
    http_response_code(404);
    exit('CV no encontrado.');
}

$extension = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
$tipos = [
    'pdf' => 'application/pdf',
    'doc' => 'application/msword',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
];

header('Content-Type: ' . ($tipos[$extension] ?? 'application/octet-stream'));
header('Content-Disposition: inline; filename="' . rawurlencode($archivo) . '"');
header('Content-Length: ' . filesize($ruta));
readfile($ruta);
exit;
