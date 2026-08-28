<?php
require __DIR__ . '/security.php';
$csrfToken = csrfToken();

$pageTitle = 'Oficinas y Cobertura | TelcoSur SPA - Claro y VTR';
$pageDescription = 'Oficinas TelcoSur SPA y cobertura regional. Distribuidor Claro y VTR con presencia en el sur de Chile.';
$activeNav = 'cobertura';
$ogImage = 'https://telcosurspa.cl/assets/og/og-cobertura.jpg';
$whatsappMessage = 'Hola TelcoSur SPA, quisiera consultar cobertura.';

require __DIR__ . '/includes/layout-start.php';
?>

  <main id="contenido">
    <?php
    $breadcrumbItems = [
        ['label' => 'Inicio', 'href' => 'index.php'],
        ['label' => 'Cobertura', 'href' => 'cobertura.php'],
    ];
    $heroEyebrow = 'Presencia regional';
    $heroTitle = 'Oficinas y cobertura TelcoSur';
    $heroLead = 'Plazas comerciales en el sur de Chile para coordinar operaciones, talento y orientación sobre servicios hogar Claro y VTR.';
    $heroStats = [
        ['value' => '8', 'label' => 'plazas comerciales'],
        ['value' => 'Sur', 'label' => 'zona de operación'],
        ['value' => '2', 'label' => 'marcas asociadas'],
    ];
    require __DIR__ . '/includes/corp-page-hero.php';
    ?>

    <section id="cobertura" class="coverage-page-layout corp-map-section anchor-section">
      <?php
      $mapVariant = 'full';
      require __DIR__ . '/includes/interactive-map.php';
      ?>

      <div class="coverage-grid">
        <article>
          <h3>Consulta por dirección</h3>
          <p>Validamos disponibilidad técnica para evitar trámites innecesarios y ayudarte con información clara.</p>
        </article>
        <article>
          <h3>Asesoría comercial</h3>
          <p>Comparamos opciones de internet, TV y entretenimiento según tu uso real y presupuesto.</p>
        </article>
        <article>
          <h3>Seguimiento cercano</h3>
          <p>Mantenemos comunicación simple durante la solicitud, postulación o proceso comercial.</p>
        </article>
      </div>
    </section>

    <section id="consulta-plan" class="application-section corp-section anchor-section anim-section reveal-on-scroll">
      <div class="corp-section-head">
        <span class="eyebrow">Consulta de cobertura</span>
        <h2>Solicita revisión de disponibilidad</h2>
        <p>Registramos tu consulta para orientarte según comuna, sector y alternativas disponibles.</p>
      </div>

      <form class="application-form corp-form" id="consulta-plan-form" action="consulta-plan.php" method="post">
        <?php require __DIR__ . '/includes/csrf-input.php'; ?>
        <?php require __DIR__ . '/includes/honeypot-field.php'; ?>
        <div class="form-grid">
          <label>
            Nombre completo
            <input type="text" name="nombre" autocomplete="name" placeholder="Ej: Camila Muñoz" required>
          </label>

          <label>
            Teléfono
            <input type="tel" name="telefono" autocomplete="tel" placeholder="Ej: +56 9 1234 5678" required>
          </label>

          <label>
            Comuna o ciudad
            <input type="text" name="comuna" list="comunas-sur-list" autocomplete="address-level2" placeholder="Ej: Puerto Montt" required>
          </label>

          <label>
            Plan o zona de interés
            <input type="text" name="plan_interes" id="plan-interes" placeholder="Ej: Consulta de cobertura en Osorno" required>
          </label>
        </div>

        <label class="full-field">
          Dirección o mensaje
          <textarea name="mensaje" rows="4" placeholder="Escribe calle, sector o referencia para revisar factibilidad."></textarea>
        </label>

        <?php require __DIR__ . '/includes/turnstile-field.php'; ?>

        <div class="form-actions">
          <button type="submit" class="sl-btn-primary">Solicitar revisión</button>
          <a href="#" class="sl-btn-outline contact-link" data-whatsapp-message="Hola TelcoSur SPA, quiero consultar cobertura en mi dirección:">Consultar por WhatsApp</a>
        </div>
        <p class="corp-form-note">Tu consulta queda registrada para validación de cobertura antes de confirmar cualquier contratación.</p>
      </form>
      <?php require __DIR__ . '/includes/corp-comunas-datalist.php'; ?>
    </section>

    <?php
    $ctaTitle = 'Consultas corporativas';
    $ctaLead = 'Para otras consultas sobre TelcoSur, nuestros canales institucionales están disponibles.';
    require __DIR__ . '/includes/corp-cta-band.php';
    ?>
  </main>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
