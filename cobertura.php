<!DOCTYPE html>
<html lang="es-CL">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Oficinas y Cobertura | TelcoSur SPA</title>
  <meta name="description" content="Revisa las oficinas TelcoSur SPA para trabajadores y usa el mapa interactivo para consultar plazas, direcciones y cobertura.">
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
      <a href="servicios.php">Servicios</a>
      <a href="planes.php">Planes</a>
      <a href="index.html#vende">Vende con nosotros</a>
      <a href="cobertura.php">Cobertura</a>
      <a href="sobre-nosotros.php">Sobre nosotros</a>
      <a href="contacto.php">Contacto</a>
    </nav>

    <a href="#" class="btn-whatsapp" data-whatsapp-message="Hola TelcoSur SPA, quisiera consultar cobertura.">WhatsApp</a>
  </header>

  <main>
    <section class="page-hero">
      <div class="page-hero-inner">
        <span class="badge">Oficinas TelcoSur</span>
        <h1>Explora las oficinas disponibles para trabajadores</h1>
        <p>Usa el mapa para acercar, desplazar y seleccionar una plaza. Cada marcador muestra dirección y ciudad de oficina.</p>
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

            <button class="map-marker" type="button" style="left: 57%; top: 8%;" data-city="Santiago" data-address="Av Irarrázaval 2821 A Of 1110" data-detail="Oficina TelcoSur para trabajadores y coordinación comercial.">
              <span></span>
              Santiago
            </button>

            <button class="map-marker" type="button" style="left: 55%; top: 14%;" data-city="Talca" data-address="1 Norte 931 Of 605" data-detail="Oficina TelcoSur para trabajadores y coordinación comercial.">
              <span></span>
              Talca
            </button>

            <button class="map-marker" type="button" style="left: 53%; top: 20%;" data-city="Chillán" data-address="El Roble 627 Of 2, 3er piso" data-detail="Oficina TelcoSur para trabajadores y coordinación comercial.">
              <span></span>
              Chillán
            </button>

            <button class="map-marker" type="button" style="left: 49%; top: 26%;" data-city="Concepción" data-address="Portales 530 Of 31" data-detail="Oficina TelcoSur para trabajadores y coordinación comercial.">
              <span></span>
              Concepción
            </button>

            <button class="map-marker" type="button" style="left: 52%; top: 31%;" data-city="Los Ángeles" data-address="Edificio del Desarrollo Lautaro 268 Of 303" data-detail="Oficina TelcoSur para trabajadores y coordinación comercial.">
              <span></span>
              Los Ángeles
            </button>

            <button class="map-marker" type="button" style="left: 54%; top: 38%;" data-city="Temuco" data-address="Manuel Bulnes 815 Of 402" data-detail="Oficina TelcoSur para trabajadores y coordinación comercial.">
              <span></span>
              Temuco
            </button>

            <button class="map-marker" type="button" style="left: 48%; top: 51%;" data-city="Valdivia" data-address="Independencia 630 Of 304, 3er piso" data-detail="Oficina TelcoSur para trabajadores y coordinación comercial.">
              <span></span>
              Valdivia
            </button>

            <button class="map-marker" type="button" style="left: 44%; top: 63%;" data-city="Osorno" data-address="Conrrado Anthauer 1190 Of D, 2do piso" data-detail="Oficina TelcoSur para trabajadores y coordinación comercial.">
              <span></span>
              Osorno
            </button>

            <button class="map-marker" type="button" style="left: 39%; top: 78%;" data-city="Puerto Montt" data-address="Benavente N°540" data-detail="Oficina TelcoSur para trabajadores y coordinación comercial.">
              <span></span>
              Puerto Montt
            </button>
          </div>
        </div>

        <aside class="map-info" id="coverage-map-info" aria-live="polite">
          <span>Oficina seleccionada</span>
          <h3>Elige una oficina del mapa</h3>
          <p>Haz clic en un marcador para ver la plaza y dirección de la oficina TelcoSur correspondiente.</p>
          <a href="contacto.php" class="btn-primary">Consultar oficina</a>
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
