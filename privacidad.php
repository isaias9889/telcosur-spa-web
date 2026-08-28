<?php
$pageTitle = 'Privacidad y datos | TelcoSur';
$pageDescription = 'Política de privacidad y tratamiento de datos personales de TelcoSur SPA.';
$activeNav = '';

require __DIR__ . '/includes/layout-start.php';
?>

  <main id="contenido">
    <?php
    $breadcrumbItems = [
        ['label' => 'Inicio', 'href' => 'index.php'],
        ['label' => 'Privacidad', 'href' => 'privacidad.php'],
    ];
    $heroEyebrow = 'Legal';
    $heroTitle = 'Privacidad y tratamiento de datos';
    $heroLead = 'En TelcoSur SPA tratamos la información personal con responsabilidad, solo para los fines declarados en cada formulario.';
    require __DIR__ . '/includes/corp-page-hero.php';
    ?>

    <section class="corp-section alt">
      <div class="corp-equipo-tema-copy">
        <p><strong>Responsable:</strong> TelcoSur SPA · contacto@telcosurspa.cl · Operación regional sur de Chile.</p>
        <p>Los datos enviados a través de formularios de contacto, cobertura o postulación se utilizan exclusivamente para responder consultas, validar disponibilidad técnica o evaluar perfiles laborales.</p>
        <p>No comercializamos bases de datos ni compartimos información con terceros ajenos a la operación, salvo obligación legal o requerimiento de marcas asociadas cuando corresponda al servicio solicitado.</p>
        <p>Los archivos adjuntos (por ejemplo CV) se almacenan de forma restringida en sistemas internos y solo el personal autorizado puede acceder a ellos.</p>
        <p>Utilizamos cookies técnicas para el funcionamiento del sitio. Si se habilita analítica web, se usará de forma agregada y anónima.</p>
        <p>Puedes solicitar actualización o eliminación de tus datos escribiendo a través de los <a href="contacto.php">canales oficiales de contacto</a>. Consulta también nuestros <a href="terminos.php">términos de uso</a>.</p>
      </div>
    </section>
  </main>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
