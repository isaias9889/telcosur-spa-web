<?php
$pageTitle = 'Sobre Nosotros | TelcoSur SPA';
$pageDescription = 'Conoce TelcoSur SPA, una empresa orientada a conectar hogares y oportunidades comerciales con atención cercana en el sur de Chile.';
$activeNav = 'sobre';
$whatsappMessage = 'Hola TelcoSur SPA, quisiera conocer más sobre la empresa.';

require __DIR__ . '/includes/layout-start.php';
?>

  <main>
    <section class="page-hero">
      <div class="page-hero-inner">
        <span class="badge">Sobre nosotros</span>
        <h1>Conectamos hogares y oportunidades con atención cercana</h1>
        <p>TelcoSur SPA trabaja para que la contratación de servicios de telecomunicaciones sea más clara, humana y ordenada para clientes y vendedores.</p>
      </div>
    </section>

    <section class="plan-summary">
      <div class="plan-summary-grid">
        <article class="summary-card">
          <span>Propósito</span>
          <h3>Conectar con claridad</h3>
          <p>Ayudamos a las personas a entender opciones, cobertura y pasos antes de contratar.</p>
        </article>
        <article class="summary-card">
          <span>Confianza</span>
          <h3>Seguimiento responsable</h3>
          <p>Guardamos consultas y postulaciones para dar continuidad a cada oportunidad comercial.</p>
        </article>
        <article class="summary-card">
          <span>Crecimiento</span>
          <h3>Equipo comercial</h3>
          <p>Impulsamos vendedores con orientación, proceso y acompañamiento para mejorar sus resultados.</p>
        </article>
      </div>
    </section>

    <section class="sell-section">
      <div class="sell-container">
        <div class="sell-text">
          <span class="section-tag">Nuestra forma de trabajar</span>
          <h2>Profesionalismo sin perder cercanía</h2>
          <p>Queremos que cada interacción sea simple: preguntar, recibir orientación y avanzar con datos claros. Esa experiencia ordenada mejora la confianza y la conversión.</p>
          <div class="sell-buttons">
            <a href="planes.php" class="btn-primary">Ver planes</a>
            <a href="contacto.php" class="btn-secondary">Contactar</a>
          </div>
        </div>
        <aside class="sell-card">
          <span>TelcoSur SPA</span>
          <h3>Atención orientada al sur</h3>
          <p>Una marca cercana, moderna y enfocada en convertir consultas en oportunidades reales.</p>
        </aside>
      </div>
    </section>
  </main>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
