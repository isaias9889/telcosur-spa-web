<!DOCTYPE html>
<html lang="es-CL">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trabaja con Nosotros | TelcoSur SPA</title>
  <meta name="description" content="Postula a oportunidades comerciales en TelcoSur SPA. Envía tus datos, adjunta tu CV y conoce el proceso de reclutamiento.">
  <link rel="icon" type="image/png" href="assets/logo.png">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header class="header">
    <a class="logo" href="index.html#inicio" aria-label="Ir al inicio de TelcoSur SPA">
      <img src="assets/logo.png" alt="Logo de TelcoSur SPA" width="82" height="82">
    </a>

    <button class="mobile-menu-toggle" type="button" aria-label="Abrir menú" aria-expanded="false" aria-controls="mobile-main-menu"><span></span><span></span><span></span></button>

    <nav class="navbar" id="mobile-main-menu" aria-label="Navegación principal">
      <a href="index.html#inicio">Inicio</a>
      <a href="servicios.php">Servicios</a>
      <a href="planes.php">Planes</a>
      <a href="trabaja-con-nosotros.php">Trabaja con nosotros</a>
      <a href="cobertura.php">Cobertura</a>
      <a href="sobre-nosotros.php">Sobre nosotros</a>
      <a href="contacto.php">Contacto</a>
    </nav>

    <a href="#" class="btn-whatsapp" data-whatsapp-message="Hola TelcoSur SPA, quisiera postular o consultar oportunidades comerciales.">WhatsApp</a>
  </header>

  <main>
    <section class="page-hero talent-hero">
      <div class="page-hero-inner">
        <span class="badge">Talento comercial</span>
        <h1>Construye ingresos vendiendo con respaldo, orden y acompañamiento</h1>
        <p>Buscamos personas con actitud comercial, comunicación clara y ganas de crecer. En TelcoSur SPA tu postulación queda registrada, revisada y disponible para seguimiento interno.</p>
        <div class="hero-buttons">
          <a href="#postulacion" class="btn-primary">Postular ahora</a>
          <a href="#cargos" class="btn-secondary">Ver cargos disponibles</a>
        </div>
      </div>
    </section>

    <section class="journey-strip" aria-label="Indicadores del proceso de postulación">
      <article>
        <strong>Postulación segura</strong>
        <span>Datos guardados en MySQL</span>
      </article>
      <article>
        <strong>CV adjunto</strong>
        <span>PDF, DOC o DOCX hasta 5 MB</span>
      </article>
      <article>
        <strong>Estado inicial</strong>
        <span>Recibida para revisión</span>
      </article>
    </section>

    <section id="cargos" class="role-board anchor-section">
      <div class="section-title compact">
        <span>Cargos disponibles</span>
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
          <a href="#postulacion" class="btn-primary" data-role-select="Ejecutivo comercial terreno">Postular a este cargo</a>
        </article>

        <article class="role-card highlighted">
          <span>Atención</span>
          <h3>Asesor de planes hogar</h3>
          <p>Ideal para perfiles con buen trato, orden y capacidad de explicar opciones de internet, TV y entretenimiento.</p>
          <ul>
            <li>Orientación comercial clara</li>
            <li>Comunicación con clientes interesados</li>
            <li>Apoyo para cierre y seguimiento</li>
          </ul>
          <a href="#postulacion" class="btn-primary" data-role-select="Asesor de planes hogar">Postular a este cargo</a>
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
          <a href="#postulacion" class="btn-primary" data-role-select="Supervisor en venta">Postular a este cargo</a>
        </article>
      </div>
    </section>

    <section class="process-section">
      <div class="section-title compact">
        <span>Proceso</span>
        <h2>Un flujo claro para postular sin fricción</h2>
      </div>

      <div class="process-timeline">
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

    <section id="postulacion" class="application-section anchor-section">
      <div class="section-title compact">
        <span>Postulación laboral</span>
        <h2>Completa tus datos y adjunta tu CV</h2>
        <p>La información se guardará para seguimiento interno. Para más seguridad, evita enviar datos sensibles que no sean necesarios para postular.</p>
      </div>

      <form class="application-form" id="postulacion-form" action="postular.php" method="post" enctype="multipart/form-data">
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
            <input type="text" name="comuna" autocomplete="address-level2" placeholder="Ej: Puerto Montt" required>
          </label>

          <label>
            Cargo de interés
            <select name="cargo" id="cargo-interes" required>
              <option value="">Selecciona un cargo</option>
              <option value="Ejecutivo comercial terreno">Ejecutivo comercial terreno</option>
              <option value="Asesor de planes hogar">Asesor de planes hogar</option>
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

        <div class="form-actions">
          <button type="submit" class="btn-primary" name="canal" value="correo">Enviar postulación</button>
          <button type="submit" class="btn-outline dark-outline" name="canal" value="whatsapp">Enviar por WhatsApp</button>
        </div>

        <p class="form-success" id="postulacion-success" hidden>Se abrió el canal de contacto con tu postulación lista para enviar.</p>
      </form>
    </section>

    <section class="secure-note">
      <div>
        <span class="section-tag">Datos y privacidad</span>
        <h2>Recomendación para producción</h2>
        <p>Cuando el sitio esté en hosting, usa HTTPS, limita acceso al panel administrativo y guarda los CV fuera de carpetas públicas si manejas información sensible de candidatos.</p>
      </div>
      <a href="contacto.php" class="btn-secondary">Hablar con TelcoSur SPA</a>
    </section>
  </main>

  <footer class="footer">
    <p><strong>TelcoSur SPA</strong> - Servicios de telecomunicaciones para hogares y oportunidades comerciales</p>
    <p>Atención personalizada • Todos los derechos reservados © 2026</p>
  </footer>

  <div class="mobile-action-bar" aria-label="Acciones rápidas móviles">
    <a class="mobile-action-primary" href="planes.php#consulta-plan">Consultar plan</a>
    <a href="#" class="mobile-action-whatsapp" data-whatsapp-message="Hola TelcoSur SPA, quisiera hacer una consulta rápida."><img src="assets/logo-whatsapp.jpeg" alt="" aria-hidden="true">WhatsApp</a>
  </div>
  <a href="#" class="floating-whatsapp" aria-label="Contactar a TelcoSur SPA por WhatsApp" data-whatsapp-message="Hola TelcoSur SPA, quisiera postular o consultar oportunidades comerciales.">WhatsApp</a>
  <script src="js/main.js"></script>
</body>
</html>
