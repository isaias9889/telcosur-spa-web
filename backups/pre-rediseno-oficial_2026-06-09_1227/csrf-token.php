<?php
require __DIR__ . '/security.php';

securityHeaders();
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate');

echo json_encode([
    'token' => csrfToken(),
]);
