<?php
require __DIR__ . '/security.php';
http_response_code(404);

$pageTitle = 'Página no encontrada | TelcoSur';
$pageDescription = 'La página que buscas no existe o fue movida. Vuelve al inicio de TelcoSur.';
$activeNav = '';
$robotsMeta = 'noindex, follow';

require __DIR__ . '/includes/layout-start.php';
?>

  <main id="contenido">
    <section class="corp-section anim-section reveal-on-scroll" style="text-align:center;padding-top:96px;padding-bottom:96px;">
      <div class="corp-section-head" style="margin-inline:auto;">
        <span class="eyebrow">Error 404</span>
        <h1 style="font-size:clamp(2.5rem,6vw,4.5rem);margin:.2em 0;">Página no encontrada</h1>
        <p>La página que buscas no existe o fue movida. Puede que el enlace esté desactualizado.</p>
      </div>
      <div class="form-actions" style="justify-content:center;margin-top:24px;">
        <a href="index.php" class="sl-btn-primary">Volver al inicio</a>
        <a href="contacto.php" class="sl-btn-outline">Contáctanos</a>
      </div>
      <p class="corp-form-note" style="margin-top:28px;">
        ¿Buscabas algo en particular? Revisa nuestros
        <a href="servicios.php">servicios</a>,
        <a href="cobertura.php">cobertura</a> o
        <a href="trabaja-con-nosotros.php">oportunidades laborales</a>.
      </p>
    </section>
  </main>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
