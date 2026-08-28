<?php
$pageTitle = 'Servicios | TelcoSur SPA';
$pageDescription = 'Servicios de TelcoSur SPA: internet para hogares, TV, streaming, revisión de cobertura y oportunidades comerciales para vendedores.';
$activeNav = 'servicios';
$whatsappMessage = 'Hola TelcoSur SPA, quisiera recibir información sobre sus servicios.';

require __DIR__ . '/includes/layout-start.php';
?>

  <main>
    <section class="page-hero">
      <div class="page-hero-inner">
        <span class="badge">Servicios TelcoSur SPA</span>
        <h1>Soluciones de conectividad y apoyo comercial para el sur</h1>
        <p>Unimos asesoría clara, revisión por dirección y seguimiento cercano para ayudar a hogares y vendedores a avanzar con confianza.</p>
      </div>
    </section>

    <section class="plan-summary">
      <div class="plan-summary-grid">
        <article class="summary-card">
          <span>Hogar</span>
          <h3>Internet, TV y streaming</h3>
          <p>Orientamos a cada cliente según uso, comuna, disponibilidad y presupuesto.</p>
          <a href="planes.php">Ver planes</a>
        </article>

        <article class="summary-card">
          <span>Cobertura</span>
          <h3>Factibilidad por dirección</h3>
          <p>Recibimos datos del sector para revisar disponibilidad antes de avanzar.</p>
          <a href="cobertura.php">Consultar zona</a>
        </article>

        <article class="summary-card">
          <span>Comercial</span>
          <h3>Postulación de vendedores</h3>
          <p>Apoyamos a personas con actitud comercial para generar ingresos con seguimiento y capacitación.</p>
          <a href="trabaja-con-nosotros.php">Postular</a>
        </article>
      </div>
    </section>

    <section class="coverage-section">
      <div class="section-title compact">
        <span>Cómo trabajamos</span>
        <h2>Un proceso simple, humano y medible</h2>
        <p>Capturamos datos, revisamos disponibilidad y respondemos con orientación clara para aumentar conversiones reales.</p>
      </div>

      <div class="coverage-grid">
        <article>
          <h3>Escuchamos la necesidad</h3>
          <p>El cliente o vendedor deja sus datos y contexto para recibir una orientación más precisa.</p>
        </article>
        <article>
          <h3>Revisamos disponibilidad</h3>
          <p>La consulta se guarda en MySQL para seguimiento ordenado y contacto posterior.</p>
        </article>
        <article>
          <h3>Guiamos hacia la acción</h3>
          <p>Los CTAs llevan a planes, cobertura o postulación según la intención del visitante.</p>
        </article>
      </div>
    </section>
  </main>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
