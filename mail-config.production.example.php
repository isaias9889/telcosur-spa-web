<?php
/**
 * Plantilla SMTP para producción — TelcoSur SPA
 *
 * 1. Copia como mail-config.php en el servidor (fuera de Git).
 * 2. En cPanel: «Cuentas de correo» → crea contacto@ y postulaciones@telcosurspa.cl
 * 3. Usa el servidor SMTP del hosting (suele ser mail.telcosurspa.cl).
 * 4. Configura SPF y DKIM en el DNS del dominio (cPanel → Zone Editor / Email Deliverability).
 * 5. Pon 'enabled' => true solo cuando hayas probado un envío real.
 */
return [
    'enabled' => true,

    // SMTP del hosting (cPanel típico)
    'host' => 'mail.telcosurspa.cl',
    'port' => 587,
    'secure' => 'tls',
    'smtp_auth' => true,
    'username' => 'contacto@telcosurspa.cl',
    'password' => 'CONTRASEÑA_DEL_CORREO',

    'from_email' => 'contacto@telcosurspa.cl',
    'from_name' => 'Sitio web TelcoSur SPA',

    // Recibe formularios de contacto, planes y cobertura
    'to' => 'contacto@telcosurspa.cl, postulaciones@telcosurspa.cl',

    // Opcional: copia automática al usuario que envía (requiere plantilla en mailer).
    'send_user_confirmation' => true,
    'confirmation_subject' => 'Recibimos tu mensaje — TelcoSur SPA',
];
