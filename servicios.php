<?php

$pageTitle = 'Servicios | TelcoSur';

$pageDescription = 'Conoce la operación de TelcoSur: presencia regional, desarrollo comercial y distribución autorizada Claro y VTR en el sur de Chile.';

$activeNav = 'servicios';

$ogImage = 'https://telcosurspa.cl/assets/og/og-servicios.jpg';

require __DIR__ . '/includes/layout-start.php';

?>

  <main id="contenido">
    <?php
    $breadcrumbItems = [
        ['label' => 'Inicio', 'href' => 'index.php'],
        ['label' => 'Servicios', 'href' => 'servicios.php'],
    ];
    $heroEyebrow = 'Servicios';
    $heroTitle = 'Operación regional con respaldo de marcas líderes';
    $heroLead = 'TelcoSur articula gestión territorial, equipos comerciales y distribución hogar Claro y VTR con enfoque institucional y presencia en el sur de Chile.';
    require __DIR__ . '/includes/corp-page-hero.php';
    ?>

    <section class="corp-section alt anim-section reveal-on-scroll">

      <div class="corp-section-head">
        <span class="eyebrow">Líneas de operación</span>
        <h2>Ámbitos en los que generamos valor</h2>
        <p>Estructura regional, equipos especializados y procesos ordenados para hogares, colaboradores y territorio.</p>
      </div>

      <div class="corp-pillars anim-stagger">
        <article class="corp-pillar reveal-on-scroll">
          <span class="corp-pillar-icon">01</span>
          <h3>Operación comercial</h3>
          <p>Estructura de ventas en terreno con capacitación, seguimiento y coordinación regional.</p>
        </article>
        <article class="corp-pillar reveal-on-scroll">
          <span class="corp-pillar-icon">02</span>
          <h3>Gestión territorial</h3>
          <p>Coordinación desde oficinas en las principales ciudades del sur para respuesta ágil y presencia local.</p>
        </article>
        <article class="corp-pillar reveal-on-scroll">
          <span class="corp-pillar-icon">03</span>
          <h3>Relación institucional</h3>
          <p>Canales de contacto para hogares, colaboradores y aliados que requieran información sobre TelcoSur.</p>
        </article>
        <article class="corp-pillar reveal-on-scroll">
          <span class="corp-pillar-icon">04</span>
          <h3>Conectividad hogar</h3>
          <p>Internet fibra, TV y entretenimiento Claro y VTR, con orientación según cobertura y necesidades del hogar.</p>
        </article>
      </div>

    </section>

    <section class="corp-section anim-section reveal-on-scroll">

      <div class="corp-split">

        <div class="corp-split-copy">
          <span class="corp-hero-kicker">Presencia regional</span>
          <h2>Oficinas y cobertura territorial</h2>
          <p>Revisamos factibilidad según comuna y sector. Nuestro equipo orienta sobre disponibilidad y alternativas en cada territorio.</p>
          <a href="cobertura.php" class="sl-btn-outline">Ver oficinas y cobertura</a>
        </div>

        <aside class="corp-panel corp-panel--muted">
          <h3>Referencia de servicios hogar</h3>
          <p>Valores orientativos de internet, TV y streaming con consulta asistida previa a cualquier contratación.</p>
          <a href="planes.php" class="corp-link-subtle">Consultar catálogo de referencia →</a>
        </aside>
      </div>
    </section>

    <?php require_once __DIR__ . '/includes/salesland-brands.php'; ?>

    <?php
    $ctaTitle = '¿Necesitas información sobre TelcoSur?';
    $ctaLead = 'Nuestros canales institucionales están disponibles para consultas sobre la empresa y su operación regional.';
    $ctaHref = 'contacto.php';
    $ctaLabel = 'Contacto institucional';
    require __DIR__ . '/includes/corp-cta-band.php';
    ?>
  </main>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
