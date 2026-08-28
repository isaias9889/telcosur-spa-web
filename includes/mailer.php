<?php
/**
 * Helper de envío de correo con PHPMailer.
 *
 * Uso:
 *   require __DIR__ . '/includes/mailer.php';
 *   enviarNotificacion('Nueva consulta de plan', [
 *       'Nombre'   => $nombre,
 *       'Teléfono' => $telefono,
 *       'Comuna'   => $comuna,
 *   ], $correoUsuario, $nombreUsuario);
 *
 * Nunca lanza excepciones al llamador: si el correo no está configurado o el
 * envío falla, registra el error y devuelve false, para que el formulario siga
 * funcionando (el guardado en base de datos es la fuente de verdad).
 */

if (!function_exists('cargarConfigCorreo')) {
    function cargarConfigCorreo(): ?array
    {
        $ruta = __DIR__ . '/../mail-config.php';
        if (!is_file($ruta)) {
            return null;
        }
        $config = require $ruta;
        return is_array($config) ? $config : null;
    }
}

if (!function_exists('enviarNotificacion')) {
    /**
     * @param string      $asunto        Asunto del correo.
     * @param array       $datos         Pares etiqueta => valor a listar en el cuerpo.
     * @param string|null $replyToEmail  Correo del usuario para poder responderle.
     * @param string|null $replyToName   Nombre del usuario.
     * @param array       $adjuntos      Rutas absolutas de archivos a adjuntar.
     */
    function enviarNotificacion(
        string $asunto,
        array $datos,
        ?string $replyToEmail = null,
        ?string $replyToName = null,
        array $adjuntos = []
    ): bool {
        $config = cargarConfigCorreo();

        if (!$config || empty($config['enabled'])) {
            return false;
        }

        $autoload = __DIR__ . '/../vendor/autoload.php';
        if (!is_file($autoload)) {
            error_log('mailer: falta vendor/autoload.php (ejecuta composer install).');
            return false;
        }
        require_once $autoload;

        if (!class_exists(\PHPMailer\PHPMailer\PHPMailer::class)) {
            error_log('mailer: PHPMailer no está disponible.');
            return false;
        }

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $config['host'] ?? '';
            $mail->Username = $config['username'] ?? '';
            $mail->Password = $config['password'] ?? '';
            $mail->Port = (int) ($config['port'] ?? 587);
            $mail->CharSet = 'UTF-8';

            // Autenticación (desactivable para servidores locales como Mailpit).
            $mail->SMTPAuth = $config['smtp_auth'] ?? true;

            $secure = strtolower((string) ($config['secure'] ?? 'tls'));
            if ($secure === 'ssl') {
                $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
            } elseif ($secure === 'tls') {
                $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            } else {
                // Sin cifrado (ej. Mailpit local en 127.0.0.1:1025).
                $mail->SMTPSecure = false;
                $mail->SMTPAutoTLS = false;
            }

            $fromEmail = $config['from_email'] ?? $config['username'] ?? '';
            $fromName = $config['from_name'] ?? 'Sitio web';
            $mail->setFrom($fromEmail, $fromName);

            $destinatarios = array_filter(array_map('trim', explode(',', (string) ($config['to'] ?? ''))));
            foreach ($destinatarios as $destino) {
                $mail->addAddress($destino);
            }
            if (!$destinatarios) {
                error_log('mailer: no hay destinatarios configurados en mail-config.php.');
                return false;
            }

            if ($replyToEmail && filter_var($replyToEmail, FILTER_VALIDATE_EMAIL)) {
                $mail->addReplyTo($replyToEmail, $replyToName ?: $replyToEmail);
            }

            foreach ($adjuntos as $adjunto) {
                if (is_string($adjunto) && is_file($adjunto)) {
                    $mail->addAttachment($adjunto);
                }
            }

            // Cuerpo HTML + texto plano.
            $filas = '';
            $texto = '';
            foreach ($datos as $etiqueta => $valor) {
                $valor = (string) $valor;
                if ($valor === '') {
                    $valor = '—';
                }
                $etiquetaSafe = htmlspecialchars((string) $etiqueta, ENT_QUOTES, 'UTF-8');
                $valorSafe = nl2br(htmlspecialchars($valor, ENT_QUOTES, 'UTF-8'));
                $filas .= '<tr>'
                    . '<td style="padding:6px 12px;font-weight:600;color:#0d1b2a;vertical-align:top;">' . $etiquetaSafe . '</td>'
                    . '<td style="padding:6px 12px;color:#333;">' . $valorSafe . '</td>'
                    . '</tr>';
                $texto .= $etiqueta . ': ' . $valor . "\n";
            }

            $asuntoSafe = htmlspecialchars($asunto, ENT_QUOTES, 'UTF-8');
            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body = '<div style="font-family:Arial,Helvetica,sans-serif;max-width:600px;margin:0 auto;">'
                . '<h2 style="color:#0d1b2a;border-bottom:2px solid #123a6b;padding-bottom:8px;">' . $asuntoSafe . '</h2>'
                . '<table style="border-collapse:collapse;width:100%;">' . $filas . '</table>'
                . '<p style="color:#8a8a8a;font-size:12px;margin-top:24px;">Enviado automáticamente desde el sitio web de TelcoSur SPA.</p>'
                . '</div>';
            $mail->AltBody = $texto;

            $mail->send();
            return true;
        } catch (\Throwable $e) {
            error_log('mailer: error al enviar correo: ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('enviarConfirmacionUsuario')) {
    /**
     * Correo automático al usuario que envió un formulario (aspecto profesional).
     */
    function enviarConfirmacionUsuario(
        string $toEmail,
        string $toName,
        string $asunto,
        string $mensaje
    ): bool {
        $config = cargarConfigCorreo();

        if (!$config || empty($config['enabled']) || empty($config['send_user_confirmation'])) {
            return false;
        }

        if (!filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $autoload = __DIR__ . '/../vendor/autoload.php';
        if (!is_file($autoload)) {
            return false;
        }
        require_once $autoload;

        if (!class_exists(\PHPMailer\PHPMailer\PHPMailer::class)) {
            return false;
        }

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $config['host'] ?? '';
            $mail->Username = $config['username'] ?? '';
            $mail->Password = $config['password'] ?? '';
            $mail->Port = (int) ($config['port'] ?? 587);
            $mail->CharSet = 'UTF-8';
            $mail->SMTPAuth = $config['smtp_auth'] ?? true;

            $secure = strtolower((string) ($config['secure'] ?? 'tls'));
            if ($secure === 'ssl') {
                $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
            } elseif ($secure === 'tls') {
                $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            } else {
                $mail->SMTPSecure = false;
                $mail->SMTPAutoTLS = false;
            }

            $fromEmail = $config['from_email'] ?? $config['username'] ?? '';
            $fromName = $config['from_name'] ?? 'TelcoSur SPA';
            $mail->setFrom($fromEmail, $fromName);
            $mail->addAddress($toEmail, $toName);

            $nombreSafe = htmlspecialchars($toName, ENT_QUOTES, 'UTF-8');
            $mensajeSafe = nl2br(htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'));
            $asuntoSafe = htmlspecialchars($asunto, ENT_QUOTES, 'UTF-8');

            $mail->isHTML(true);
            $mail->Subject = $config['confirmation_subject'] ?? $asunto;
            $mail->Body = '<div style="font-family:Arial,Helvetica,sans-serif;max-width:600px;margin:0 auto;">'
                . '<h2 style="color:#0d1b2a;">Hola, ' . $nombreSafe . '</h2>'
                . '<p style="color:#333;line-height:1.6;">' . $mensajeSafe . '</p>'
                . '<p style="color:#8a8a8a;font-size:12px;margin-top:24px;">TelcoSur SPA — Cerca de ti, cerca de todos.</p>'
                . '</div>';
            $mail->AltBody = strip_tags($mensaje);

            $mail->send();

            return true;
        } catch (\Throwable $e) {
            error_log('mailer: error al enviar confirmación: ' . $e->getMessage());

            return false;
        }
    }
}
