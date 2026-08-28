<?php
require __DIR__ . '/security.php';
csrfToken();

$pageTitle = 'Contacto | TelcoSur';
$pageDescription = 'Contacta a TelcoSur. Información corporativa, consultas generales y canales oficiales de comunicación.';
$activeNav = 'contacto';
$ogImage = 'https://telcosurspa.cl/assets/og/og-contacto.jpg';

require __DIR__ . '/includes/layout-start.php';
?>

  <main id="contenido">
    <?php
    $breadcrumbItems = [
        ['label' => 'Inicio', 'href' => 'index.php'],
        ['label' => 'Contacto', 'href' => 'contacto.php'],
    ];
    $heroEyebrow = 'Contacto';
    $heroTitle = 'Canales oficiales de TelcoSur';
    $heroLead = 'Escríbenos para consultas corporativas, información sobre servicios, cobertura u oportunidades de colaboración.';
    require __DIR__ . '/includes/corp-page-hero.php';
    ?>

    <section class="corp-section alt anim-section reveal-on-scroll">
      <div class="corp-section-head">
        <span class="eyebrow">Cómo contactarnos</span>
        <h2>Selecciona el canal según tu consulta</h2>
      </div>
      <div class="corp-contact-grid anim-stagger">
        <article class="corp-contact-card reveal-on-scroll">
          <h3>Información corporativa</h3>
          <p>Consultas sobre TelcoSur, nuestra operación regional y alianzas comerciales.</p>
          <p class="corp-contact-meta">WhatsApp corporativo</p>
          <a href="#" class="sl-btn-primary contact-link" data-whatsapp-message="Hola TelcoSur, quisiera más información sobre la empresa.">Escribir por WhatsApp</a>
        </article>
        <article class="corp-contact-card reveal-on-scroll">
          <h3>Cobertura y servicios</h3>
          <p>Disponibilidad técnica, oficinas y orientación sobre servicios hogar Claro y VTR.</p>
          <p class="corp-contact-meta">Formulario de cobertura</p>
          <a href="cobertura.php#consulta-plan" class="sl-btn-outline">Solicitar información</a>
        </article>
        <article class="corp-contact-card reveal-on-scroll">
          <h3>Talento y postulaciones</h3>
          <p>Oportunidades para integrar equipos comerciales en el sur de Chile.</p>
          <p class="corp-contact-meta">postulaciones@telcosurspa.cl</p>
          <a href="trabaja-con-nosotros.php" class="sl-btn-outline">Ver oportunidades</a>
        </article>
        <article class="corp-contact-card reveal-on-scroll">
          <h3>Oficinas regionales</h3>
          <p>Plazas comerciales desde Santiago hasta Puerto Montt.</p>
          <p class="corp-contact-meta">8 ciudades</p>
          <a href="cobertura.php" class="sl-btn-outline">Ver ubicaciones</a>
        </article>
      </div>
    </section>

    <section id="formulario-contacto" class="application-section corp-section anchor-section anim-section reveal-on-scroll">
      <div class="corp-section-head">
        <span class="eyebrow">Escríbenos</span>
        <h2>Formulario de contacto</h2>
        <p>Completa el formulario y nuestro equipo te responderá en días hábiles.</p>
      </div>
      <form class="application-form corp-form" id="contacto-form" action="contacto-enviar.php" method="post">
        <?php require __DIR__ . '/includes/csrf-input.php'; ?>
        <?php require __DIR__ . '/includes/honeypot-field.php'; ?>
        <div class="form-grid">
          <label>
            Nombre completo
            <input type="text" name="nombre" autocomplete="name" required placeholder="Ej: Camila Muñoz">
          </label>
          <label>
            Teléfono
            <input type="tel" name="telefono" autocomplete="tel" required placeholder="Ej: +56 9 1234 5678">
          </label>
          <label>
            Correo (opcional)
            <input type="email" name="correo" autocomplete="email" placeholder="Ej: nombre@correo.cl">
          </label>
          <label>
            Comuna o ciudad (opcional)
            <input type="text" name="comuna" list="comunas-sur-list" autocomplete="address-level2" placeholder="Ej: Temuco">
          </label>
          <label class="full-field">
            Motivo de consulta
            <select name="asunto" required>
              <option value="">Selecciona un motivo</option>
              <option value="Información corporativa">Información corporativa</option>
              <option value="Cobertura y servicios hogar">Cobertura y servicios hogar</option>
              <option value="Talento y postulaciones">Talento y postulaciones</option>
              <option value="Otra consulta">Otra consulta</option>
            </select>
          </label>
        </div>
        <label class="full-field">
          Mensaje
          <textarea name="mensaje" rows="5" required placeholder="Cuéntanos en qué podemos ayudarte."></textarea>
        </label>
        <label class="consent-field">
          <input type="checkbox" required>
          Acepto el tratamiento de mis datos según la <a href="privacidad.php">política de privacidad</a>.
        </label>
        <?php require __DIR__ . '/includes/turnstile-field.php'; ?>
        <div class="form-actions">
          <button type="submit" class="sl-btn-primary">Enviar mensaje</button>
          <a href="#" class="sl-btn-outline contact-link" data-whatsapp-message="Hola TelcoSur, quisiera contactarlos.">WhatsApp</a>
        </div>
        <p class="corp-form-note">También puedes escribirnos por WhatsApp si prefieres una respuesta más rápida.</p>
      </form>
      <?php require __DIR__ . '/includes/corp-comunas-datalist.php'; ?>
    </section>

    <section class="corp-section">
      <div class="corp-split">
        <div class="corp-split-copy">
          <span class="corp-hero-kicker">TelcoSur SPA</span>
          <h2>Distribuidor autorizado Claro y VTR</h2>
          <p><em>Cerca de ti, cerca de todos.</em> Impulsamos conectividad hogar y desarrollo comercial con presencia regional y procesos transparentes.</p>
        </div>
        <aside class="corp-panel">
          <h3>Horario de respuesta</h3>
          <p>Procesamos consultas en días hábiles. Para postulaciones laborales, contactamos cuando el perfil calce con nuestras vacantes.</p>
        </aside>
      </div>
    </section>

    <?php require_once __DIR__ . '/includes/salesland-brands.php'; ?>

    <?php
    $ctaTitle = '¿Prefieres ver nuestras oficinas?';
    $ctaLead = 'Consulta el mapa interactivo con las 8 plazas comerciales en el sur de Chile.';
    $ctaHref = 'cobertura.php';
    $ctaLabel = 'Ver cobertura';
    require __DIR__ . '/includes/corp-cta-band.php';
    ?>
  </main>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
