<?php
/**
 * Configuración para PROBAR correos en local con Mailpit (no envía correos reales).
 *
 * Cómo usar:
 *   1. Inicia Mailpit en una terminal:   mailpit
 *      - SMTP local:  127.0.0.1:1025
 *      - Bandeja web: http://localhost:8025
 *   2. Copia este archivo como mail-config.php (respalda el de producción antes).
 *   3. Envía cualquier formulario del sitio y revísalo en http://localhost:8025
 *   4. Cuando termines, restaura tu mail-config.php de producción.
 */
return [
    'enabled'    => true,
    'host'       => '127.0.0.1',
    'port'       => 1025,
    'secure'     => 'none', // sin cifrado
    'smtp_auth'  => false,   // Mailpit no requiere autenticación
    'username'   => '',
    'password'   => '',

    'from_email' => 'sitio@telcosurspa.local',
    'from_name'  => 'Sitio web TelcoSur (local)',
    'to'         => 'buzon@telcosurspa.local',
];
