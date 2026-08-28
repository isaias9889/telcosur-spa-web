<?php
$pageTitle = 'Contacto | TelcoSur SPA';
$pageDescription = 'Contacta a TelcoSur SPA por WhatsApp, consulta planes, revisa cobertura o envía tu postulación comercial.';
$activeNav = 'contacto';
$whatsappMessage = 'Hola TelcoSur SPA, quisiera hacer una consulta.';

require __DIR__ . '/includes/layout-start.php';
?>

  <main>
    <section class="page-hero">
      <div class="page-hero-inner">
        <span class="badge">Contacto</span>
        <h1>Elige el canal correcto y avancemos</h1>
        <p>Centralizamos consultas de planes, cobertura y postulaciones para responder con más orden y rapidez.</p>
      </div>
    </section>

    <section class="plan-summary">
      <div class="plan-summary-grid">
        <article class="summary-card">
          <span>Planes</span>
          <h3>Quiero contratar</h3>
          <p>Déjanos tus datos para revisar disponibilidad y el plan que más conviene a tu hogar.</p>
          <a href="planes.php#consulta-plan">Consultar plan</a>
        </article>
        <article class="summary-card">
          <span>Cobertura</span>
          <h3>Revisar dirección</h3>
          <p>Usa el mapa interactivo y deja tu comuna, sector o dirección de referencia.</p>
          <a href="cobertura.php#consulta-plan">Consultar cobertura</a>
        </article>
        <article class="summary-card">
          <span>Postulación</span>
          <h3>Quiero vender</h3>
          <p>Completa tu postulación o escribe al correo dedicado para oportunidades comerciales.</p>
          <a href="trabaja-con-nosotros.php">Postular</a>
        </article>
      </div>
    </section>

    <section class="contact-section">
      <div>
        <span class="section-tag dark-tag">Canales directos</span>
        <h2>WhatsApp y correo de postulaciones</h2>
        <p>Para consultas rápidas usa WhatsApp. Para postulaciones comerciales también puedes escribir a postulaciones@telcosurspa.cl.</p>
      </div>
      <div class="contact-actions">
        <a href="#" class="btn-whatsapp big" data-whatsapp-message="Hola TelcoSur SPA, quisiera hacer una consulta.">Contactar por WhatsApp</a>
        <a href="mailto:postulaciones@telcosurspa.cl" class="btn-secondary">Enviar postulación</a>
      </div>
    </section>
  </main>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
