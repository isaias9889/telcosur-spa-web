<?php
$tipo = $_GET['tipo'] ?? '';
$estado = $_GET['estado'] ?? '';
$esConsulta = $tipo === 'consulta';

$titulos = [
    'ok' => $esConsulta ? 'Tu consulta fue registrada correctamente' : 'Has postulado correctamente',
    'error' => 'No se pudo guardar la información',
    'csrf' => 'La solicitud no pudo validarse',
    'limit' => 'Has enviado demasiadas solicitudes',
];

$mensajes = [
    'ok' => $esConsulta
        ? 'Tus datos quedaron guardados en la base de datos. Pronto podrán contactarte para revisar cobertura y disponibilidad del plan.'
        : 'Tu postulación quedó guardada en la base de datos. El equipo de TelcoSur SPA podrá revisarla y contactarte.',
    'error' => 'Revisa que todos los campos obligatorios estén completos, que el RUT, teléfono y correo sean válidos, e intenta nuevamente.',
    'csrf' => 'La sesión de seguridad expiró o el formulario no es válido. Vuelve a la página anterior y envía el formulario otra vez.',
    'limit' => 'Por seguridad, espera unos minutos antes de enviar otra consulta o postulación.',
];

$titulo = $titulos[$estado] ?? $titulos['error'];
$mensaje = $mensajes[$estado] ?? $mensajes['error'];
?>
<!DOCTYPE html>
<html lang="es-CL">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?> | TelcoSur SPA</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <main class="application-section" style="min-height: 100vh; display: grid; place-items: center;">
    <section class="application-form" style="text-align: center;">
      <?php if ($estado === 'ok'): ?>
        <div style="width: 74px; height: 74px; margin: 0 auto 18px; border-radius: 999px; display: grid; place-items: center; background: #15c84f; color: #ffffff; font-size: 42px; font-weight: 900;">✓</div>
      <?php endif; ?>
      <h1 style="color: #071a3d; margin-bottom: 12px;"><?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?></h1>
      <p style="color: #526075; line-height: 1.55; margin-bottom: 24px;"><?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?></p>
      <div class="form-actions" style="justify-content: center;">
        <a class="btn-primary" href="index.php">Volver al sitio</a>
        <?php if ($estado === 'ok'): ?>
          <a class="btn-secondary" href="<?php echo $esConsulta ? 'consultas-planes.php' : 'postulaciones.php'; ?>">Ver registros</a>
        <?php endif; ?>
      </div>
    </section>
  </main>
</body>
</html>
