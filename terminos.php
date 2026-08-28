<?php
$pageTitle = 'Términos de uso | TelcoSur';
$pageDescription = 'Términos de uso del sitio web TelcoSur SPA.';
$activeNav = '';

require __DIR__ . '/includes/layout-start.php';
?>

  <main id="contenido">
    <?php
    $breadcrumbItems = [
        ['label' => 'Inicio', 'href' => 'index.php'],
        ['label' => 'Términos', 'href' => 'terminos.php'],
    ];
    $heroEyebrow = 'Legal';
    $heroTitle = 'Términos de uso del sitio';
    $heroLead = 'Condiciones generales para el uso de la información y servicios publicados en telcosurspa.cl.';
    require __DIR__ . '/includes/corp-page-hero.php';
    ?>

    <section class="corp-section alt">
      <div class="corp-equipo-tema-copy">
        <p>El contenido de este sitio tiene fines informativos sobre TelcoSur SPA, su operación regional y orientación sobre servicios hogar Claro y VTR.</p>
        <p>Los precios, planes y disponibilidad técnica publicados son referenciales y pueden variar según comuna, factibilidad y condiciones vigentes de las marcas asociadas.</p>
        <p>TelcoSur SPA es distribuidor independiente. Claro y VTR son marcas de sus respectivos titulares.</p>
        <p>El uso del sitio implica aceptar estas condiciones y nuestra <a href="privacidad.php">política de privacidad</a>.</p>
      </div>
    </section>
  </main>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
