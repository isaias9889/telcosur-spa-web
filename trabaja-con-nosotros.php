<?php
require __DIR__ . '/security.php';
$csrfToken = csrfToken();

$pageTitle = 'Talento | TelcoSur';
$pageDescription = 'Oportunidades laborales en TelcoSur. Únete a nuestros equipos comerciales como distribuidor Claro y VTR en el sur de Chile.';
$activeNav = 'trabaja';
$mobilePrimaryLabel = 'Postular';
$mobilePrimaryHref = '#postulacion';
$whatsappMessage = 'Hola TelcoSur SPA, quisiera postular o consultar oportunidades comerciales.';
$floatingWhatsappMessage = $whatsappMessage;
$mobilePrimaryLabel = 'Postular ahora';
$mobilePrimaryHref = '#postulacion';
$ogImage = 'https://telcosurspa.cl/assets/og/og-talento.jpg';

require __DIR__ . '/includes/layout-start.php';
?>

  <main id="contenido">
    <?php
    $breadcrumbItems = [
        ['label' => 'Inicio', 'href' => 'index.php'],
        ['label' => 'Talento', 'href' => 'trabaja-con-nosotros.php'],
    ];
    $heroEyebrow = 'Talento';
    $heroTitle = 'Desarrolla tu carrera comercial con respaldo regional';
    $heroLead = 'Formamos equipos que representan servicios Claro y VTR con capacitación, acompañamiento y cultura de equipo en el sur de Chile.';
    $heroActions = [
        ['href' => '#postulacion', 'label' => 'Postular ahora', 'class' => 'sl-btn-primary'],
        ['href' => '#cargos', 'label' => 'Ver cargos', 'class' => 'sl-btn-outline'],
    ];
    require __DIR__ . '/includes/corp-page-hero.php';
    ?>

    <section class="corp-facts-strip" aria-label="Proceso de postulación">
      <article>
        <strong>Postulación en línea</strong>
        <span>Formulario seguro con datos para revisión interna</span>
      </article>
      <article>
        <strong>CV adjunto</strong>
        <span>PDF, DOC o DOCX hasta 5 MB</span>
      </article>
      <article>
        <strong>Seguimiento</strong>
        <span>Contacto cuando el perfil calce con la vacante</span>
      </article>
    </section>

    <section id="cargos" class="role-board corp-section anchor-section">
      <div class="corp-section-head">
        <span class="eyebrow">Cargos disponibles</span>
        <h2>Oportunidades para perfiles comerciales</h2>
        <p>Elige el cargo que mejor calce con tu experiencia y disponibilidad. Puedes postular aunque estés comenzando si tienes buena actitud y compromiso.</p>
      </div>

      <div class="role-grid">
        <article class="role-card">
          <span>Comercial</span>
          <h3>Ejecutivo comercial terreno</h3>
          <p>Para personas con capacidad de generar contactos, visitar sectores y acompañar solicitudes de clientes.</p>
          <ul>
            <li>Modalidad flexible según zona</li>
            <li>Capacitación inicial</li>
            <li>Seguimiento de oportunidades</li>
          </ul>
          <a href="#postulacion" class="sl-btn-primary" data-role-select="Ejecutivo comercial terreno">Postular a este cargo</a>
        </article>

        <article class="role-card">
          <span>Supervisión</span>
          <h3>Supervisor en venta</h3>
          <p>Para candidatos con experiencia liderando equipos comerciales, ordenando metas y apoyando cierres de venta por comuna o plaza.</p>
          <ul>
            <li>Supervisión de ejecutivos comerciales</li>
            <li>Seguimiento de metas y oportunidades</li>
            <li>Apoyo en cierres y gestión comercial</li>
          </ul>
          <a href="#postulacion" class="sl-btn-primary" data-role-select="Supervisor en venta">Postular a este cargo</a>
        </article>
      </div>
    </section>

    <section class="corp-process-section">
      <div class="corp-section-head">
        <span class="eyebrow">Proceso</span>
        <h2>Un flujo claro para postular sin fricción</h2>
      </div>

      <div class="corp-process-steps">
        <article>
          <strong>1</strong>
          <h3>Envías tus datos</h3>
          <p>Completa el formulario, selecciona cargo y adjunta tu CV si lo tienes listo.</p>
        </article>
        <article>
          <strong>2</strong>
          <h3>Revisión interna</h3>
          <p>Tu postulación queda con estado “Recibida” para revisión por el equipo TelcoSur SPA.</p>
        </article>
        <article>
          <strong>3</strong>
          <h3>Contacto y orientación</h3>
          <p>Si tu perfil calza, te contactan para explicar modalidad, apoyo comercial y próximos pasos.</p>
        </article>
      </div>
    </section>

    <section id="postulacion" class="application-section corp-section anchor-section">
      <div class="corp-section-head">
        <span class="eyebrow">Postulación laboral</span>
        <h2>Completa tus datos y adjunta tu CV</h2>
        <p>La información se guardará para seguimiento interno. Para más seguridad, evita enviar datos sensibles que no sean necesarios para postular.</p>
      </div>

      <form class="application-form corp-form" id="postulacion-form" action="postular.php" method="post" enctype="multipart/form-data">
        <?php require __DIR__ . '/includes/csrf-input.php'; ?>
        <?php require __DIR__ . '/includes/honeypot-field.php'; ?>
        <div class="form-grid">
          <label>
            Nombre completo
            <input type="text" name="nombre" autocomplete="name" placeholder="Ej: Camila Muñoz" required>
          </label>

          <label>
            RUT
            <input type="text" name="rut" placeholder="Ej: 12.345.678-9" required>
          </label>

          <label>
            Teléfono
            <input type="tel" name="telefono" autocomplete="tel" placeholder="Ej: +56 9 1234 5678" required>
          </label>

          <label>
            Correo electrónico
            <input type="email" name="correo" autocomplete="email" placeholder="Ej: nombre@correo.cl" required>
          </label>

          <label>
            Comuna o ciudad
            <input type="text" name="comuna" list="comunas-sur-list" autocomplete="address-level2" placeholder="Ej: Puerto Montt" required>
          </label>

          <label>
            Cargo de interés
            <select name="cargo" id="cargo-interes" required>
              <option value="">Selecciona un cargo</option>
              <option value="Ejecutivo comercial terreno">Ejecutivo comercial terreno</option>
              <option value="Supervisor en venta">Supervisor en venta</option>
            </select>
          </label>

          <label>
            Experiencia en ventas
            <select name="experiencia" required>
              <option value="">Selecciona una opción</option>
              <option value="sin-experiencia">Sin experiencia, quiero aprender</option>
              <option value="menos-1">Menos de 1 año</option>
              <option value="1-3">1 a 3 años</option>
              <option value="mas-3">Más de 3 años</option>
            </select>
          </label>

          <label>
            Disponibilidad
            <select name="disponibilidad" required>
              <option value="">Selecciona una opción</option>
              <option value="part-time">Part time</option>
              <option value="full-time">Full time</option>
              <option value="flexible">Flexible</option>
            </select>
          </label>
        </div>

        <label class="full-field">
          Adjuntar CV
          <input type="file" name="cv" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
          <small class="file-hint">Formatos permitidos: PDF, DOC o DOCX. Tamaño máximo: 5 MB.</small>
        </label>

        <label class="full-field">
          Cuéntanos brevemente por qué quieres postular
          <textarea name="mensaje" rows="5" placeholder="Escribe tu motivación, sector donde podrías vender o experiencia previa."></textarea>
        </label>

        <label class="consent-field">
          <input type="checkbox" required>
          Acepto que TelcoSur SPA almacene mis datos para gestionar esta postulación.
        </label>

        <?php require __DIR__ . '/includes/turnstile-field.php'; ?>

        <div class="form-actions">
          <button type="submit" class="sl-btn-primary" name="canal" value="correo">Enviar postulación</button>
          <button type="submit" class="sl-btn-outline" name="canal" value="whatsapp">Enviar por WhatsApp</button>
        </div>

        <p class="form-success" id="postulacion-success" hidden>Se abrió el canal de contacto con tu postulación lista para enviar.</p>
        <p class="corp-form-note">TelcoSur revisará tu postulación y te contactará si tu perfil calza con las vacantes disponibles.</p>
      </form>
      <?php require __DIR__ . '/includes/corp-comunas-datalist.php'; ?>
    </section>

    <section class="corp-talent" aria-label="Por qué TelcoSur">
      <div class="corp-talent-inner">
        <div>
          <span class="corp-hero-kicker">Cultura TelcoSur</span>
          <h2>Marcas líderes, operación regional y acompañamiento profesional</h2>
          <p>Como distribuidor Claro y VTR ofrecemos formación en productos, presencia en ocho ciudades y un entorno orientado al desarrollo comercial.</p>
          <a href="#postulacion" class="sl-btn-primary">Completar postulación</a>
        </div>
        <aside class="corp-talent-card">
          <h3>Lo que ofrecemos</h3>
          <ul>
            <li>Capacitación en productos Claro y VTR</li>
            <li>Acompañamiento en terreno</li>
            <li>Plazas comerciales en el sur de Chile</li>
          </ul>
        </aside>
      </div>
    </section>

    <?php
    $ctaTitle = '¿Te interesa unirte al equipo?';
    $ctaLead = 'Revisa las oportunidades disponibles y completa tu postulación en línea.';
    $ctaHref = '#postulacion';
    $ctaLabel = 'Postular ahora';
    require __DIR__ . '/includes/corp-cta-band.php';
    ?>
  </main>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
