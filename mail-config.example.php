<?php
/**
 * Copia este archivo como mail-config.php y completa los datos de tu correo SMTP.
 *
 * Ejemplos de configuración:
 *
 * Gmail / Google Workspace:
 *   - host: smtp.gmail.com
 *   - port: 587
 *   - secure: tls
 *   - username: tucorreo@gmail.com
 *   - password: (usa una "Contraseña de aplicación", NO la de tu cuenta)
 *
 * Hosting propio (cPanel, etc.):
 *   - host: mail.tudominio.cl
 *   - port: 465 (secure: ssl) o 587 (secure: tls)
 *
 * Si dejas 'enabled' => false, el sitio seguirá funcionando y guardando en la
 * base de datos, pero no enviará correos.
 *
 * Para producción en hosting, usa mail-config.production.example.php como guía.
 */
return [
    'enabled'   => false,
    'host'      => 'smtp.gmail.com',
    'port'      => 587,
    'secure'    => 'tls', // 'tls' o 'ssl'
    'username'  => 'tucorreo@gmail.com',
    'password'  => 'contraseña_de_aplicacion',

    // Remitente que verá el destinatario.
    'from_email' => 'tucorreo@gmail.com',
    'from_name'  => 'Sitio web TelcoSur',

    // Bandeja(s) que reciben las notificaciones (separa varias con coma).
    'to'         => 'contacto@telcosurspa.cl',

    // Correo automático al usuario (contacto y postulaciones con email).
    'send_user_confirmation' => false,
    'confirmation_subject' => 'Recibimos tu mensaje — TelcoSur SPA',
];
