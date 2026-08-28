<?php
$tipo = $_GET['tipo'] ?? '';
$estado = $_GET['estado'] ?? '';
$esConsulta = $tipo === 'consulta';
$esContacto = $tipo === 'contacto';

$titulos = [
    'ok' => $esContacto ? 'Mensaje enviado correctamente' : ($esConsulta ? 'Consulta registrada correctamente' : 'Postulación enviada correctamente'),
    'error' => 'No se pudo procesar la solicitud',
    'csrf' => 'La solicitud no pudo validarse',
    'limit' => 'Límite de solicitudes alcanzado',
    'captcha' => 'Verificación de seguridad requerida',
];

$mensajes = [
    'ok' => $esContacto
        ? 'Hemos recibido tu mensaje. Nuestro equipo te contactará en días hábiles.'
        : ($esConsulta
        ? 'Hemos recibido tu consulta. Nuestro equipo revisará cobertura y disponibilidad para contactarte.'
        : 'Hemos recibido tu postulación. El equipo de TelcoSur la revisará y te contactará si tu perfil calza.'),
    'error' => 'Revisa que todos los campos obligatorios estén completos e intenta nuevamente.',
    'csrf' => 'La sesión expiró. Vuelve a la página anterior y envía el formulario otra vez.',
    'limit' => 'Por seguridad, espera unos minutos antes de enviar otra solicitud.',
    'captcha' => 'Completa la verificación anti-spam e intenta enviar el formulario nuevamente.',
];

$pageTitle = ($titulos[$estado] ?? $titulos['error']) . ' | TelcoSur';
$hidePartnerStrip = true;

require __DIR__ . '/includes/layout-start.php';

$titulo = $titulos[$estado] ?? $titulos['error'];
$mensaje = $mensajes[$estado] ?? $mensajes['error'];
$esOk = $estado === 'ok';
?>

  <main id="contenido" class="corp-result-page">
    <section class="corp-result-card" aria-live="polite">
      <?php if ($esOk): ?>
        <div class="corp-result-icon" aria-hidden="true">✓</div>
      <?php else: ?>
        <div class="corp-result-icon corp-result-icon--alert" aria-hidden="true">!</div>
      <?php endif; ?>
      <h1><?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?></h1>
      <p><?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?></p>
      <div class="corp-result-actions">
        <a class="sl-btn-primary" href="index.php">Volver al inicio</a>
        <a class="sl-btn-outline" href="<?php echo $esConsulta ? 'cobertura.php' : 'trabaja-con-nosotros.php'; ?>">
          <?php echo $esConsulta ? 'Ir a cobertura' : 'Ir a talento'; ?>
        </a>
      </div>
    </section>
  </main>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
