<!DOCTYPE html>
<html lang="es-CL">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cobertura Interactiva | TelcoSur SPA</title>
  <meta name="description" content="Revisa el mapa interactivo de cobertura de TelcoSur SPA en el sur de Chile y deja tus datos para consultar factibilidad técnica.">
  <link rel="icon" type="image/png" href="assets/logo.png">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header class="header">
    <a class="logo" href="index.html#inicio" aria-label="Ir al inicio de TelcoSur SPA">
      <img src="assets/logo.png" alt="Logo de TelcoSur SPA" width="82" height="82">
    </a>

    <nav class="navbar" aria-label="Navegación principal">
      <a href="index.html#inicio">Inicio</a>
      <a href="planes.php">Planes</a>
      <a href="index.html#vende">Vende con nosotros</a>
      <a href="cobertura.php">Cobertura</a>
      <a href="index.html#preguntas">Preguntas</a>
      <a href="index.html#contacto">Contacto</a>
    </nav>

    <a href="#" class="btn-whatsapp" data-whatsapp-message="Hola TelcoSur SPA, quisiera consultar cobertura.">WhatsApp</a>
  </header>

  <main>
    <section class="page-hero">
      <div class="page-hero-inner">
        <span class="badge">Cobertura interactiva</span>
        <h1>Explora zonas de atención y consulta factibilidad por dirección</h1>
        <p>Usa el mapa para acercar, desplazar y seleccionar ciudades del sur donde se concentra la atención comercial de TelcoSur SPA.</p>
      </div>
    </section>

    <section id="cobertura" class="coverage-page-layout anchor-section">
      <div class="interactive-map" aria-label="Mapa interactivo de cobertura regional sur de TelcoSur SPA">
        <div class="map-toolbar" aria-label="Controles del mapa">
          <button type="button" class="map-control" data-map-zoom="in" aria-label="Acercar mapa">+</button>
          <button type="button" class="map-control" data-map-zoom="out" aria-label="Alejar mapa">-</button>
          <button type="button" class="map-control wide" data-map-reset aria-label="Restablecer mapa">Centrar</button>
        </div>

        <div class="map-stage" id="coverage-map-stage">
          <div class="map-canvas" id="coverage-map-canvas">
            <img src="assets/mapa-regional-sur.png" alt="Mapa regional del sur de Chile con zonas de atención de TelcoSur SPA" width="920" height="620" loading="lazy" draggable="false">

            <button class="map-marker" type="button" style="left: 54%; top: 23%;" data-city="Temuco" data-detail="Atención comercial y revisión de factibilidad para hogares de La Araucanía.">
              <span></span>
              Temuco
            </button>

            <button class="map-marker" type="button" style="left: 48%; top: 39%;" data-city="Valdivia" data-detail="Consulta de planes, cobertura y oportunidades comerciales en Los Ríos.">
              <span></span>
              Valdivia
            </button>

            <button class="map-marker" type="button" style="left: 44%; top: 56%;" data-city="Osorno" data-detail="Asesoría para internet, TV y streaming según disponibilidad del sector.">
              <span></span>
              Osorno
            </button>

            <button class="map-marker" type="button" style="left: 39%; top: 72%;" data-city="Puerto Montt" data-detail="Zona prioritaria de atención para consultas de cobertura y postulación comercial.">
              <span></span>
              Puerto Montt
            </button>
          </div>
        </div>

        <aside class="map-info" id="coverage-map-info" aria-live="polite">
          <span>Zona seleccionada</span>
          <h3>Elige una ciudad del mapa</h3>
          <p>Haz clic en un marcador para ver información de atención y consultar factibilidad en esa zona.</p>
          <a href="#consulta-plan" class="btn-primary">Consultar cobertura</a>
        </aside>
      </div>

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

    <section id="consulta-plan" class="application-section anchor-section">
      <div class="section-title compact">
        <span>Consulta de cobertura</span>
        <h2>Déjanos tu teléfono y dirección de referencia</h2>
        <p>Guardaremos tu consulta para revisar disponibilidad técnica según comuna y sector.</p>
      </div>

      <form class="application-form" id="consulta-plan-form" action="consulta-plan.php" method="post">
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
            <input type="text" name="comuna" autocomplete="address-level2" placeholder="Ej: Puerto Montt" required>
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

        <div class="form-actions">
          <button type="submit" class="btn-primary">Solicitar revisión</button>
          <a href="#" class="btn-outline dark-outline" data-whatsapp-message="Hola TelcoSur SPA, quiero consultar cobertura en mi dirección:">Consultar por WhatsApp</a>
        </div>
      </form>
    </section>
  </main>

  <footer class="footer">
    <p><strong>TelcoSur SPA</strong> - Servicios de telecomunicaciones para hogares y oportunidades comerciales</p>
    <p>Atención personalizada • Todos los derechos reservados © 2026</p>
  </footer>

  <a href="#" class="floating-whatsapp" aria-label="Contactar a TelcoSur SPA por WhatsApp" data-whatsapp-message="Hola TelcoSur SPA, quisiera hacer una consulta rápida.">WhatsApp</a>
  <script src="js/main.js"></script>
</body>
</html>
