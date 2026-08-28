<?php
require __DIR__ . '/security.php';
$csrfToken = csrfToken();

$pageTitle = 'Oficinas y Cobertura | TelcoSur SPA';
$pageDescription = 'Revisa las oficinas TelcoSur SPA para trabajadores y usa el mapa interactivo para consultar plazas, direcciones y cobertura.';
$activeNav = 'cobertura';
$whatsappMessage = 'Hola TelcoSur SPA, quisiera consultar cobertura.';

require __DIR__ . '/includes/layout-start.php';
?>

  <main>
    <section class="page-hero">
      <div class="page-hero-inner">
        <span class="badge">Oficinas TelcoSur</span>
        <h1>Explora las oficinas disponibles para trabajadores</h1>
        <p>Usa el mapa para acercar, desplazar y seleccionar una plaza. Cada marcador muestra dirección y ciudad de oficina.</p>
        <div class="coverage-hero-stats" aria-label="Resumen de cobertura TelcoSur">
          <article><strong>8</strong><span>plazas activas</span></article>
          <article><strong>Sur</strong><span>zona prioritaria</span></article>
          <article><strong>24/7</strong><span>consulta digital</span></article>
        </div>
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
            <div class="map-live-badge">Mapa interactivo</div>
            <?php
            $imageBase = 'assets/mapa-regional-sur';
            $imageAlt = 'Mapa regional del sur de Chile con zonas de atencion de TelcoSur SPA';
            $imageWidth = 1024;
            $imageHeight = 1536;
            $imageDraggable = 'false';
            require __DIR__ . '/includes/optimized-image.php';
            ?>

            <button class="map-marker" type="button" style="left: 72.5%; top: 8.2%;" data-city="Santiago" data-address="Av Irarrázaval 2821 A Of 1110" data-detail="Oficina TelcoSur para trabajadores y coordinación comercial.">
              <span></span>
              Santiago
            </button>

            <button class="map-marker" type="button" style="left: 64.6%; top: 27%;" data-city="Talca" data-address="1 Norte 931 Of 605" data-detail="Oficina TelcoSur para trabajadores y coordinación comercial.">
              <span></span>
              Talca
            </button>

            <button class="map-marker" type="button" style="left: 58.6%; top: 37.4%;" data-city="Chillán" data-address="El Roble 627 Of 2, 3er piso" data-detail="Oficina TelcoSur para trabajadores y coordinación comercial.">
              <span></span>
              Chillán
            </button>

            <button class="map-marker" type="button" style="left: 48%; top: 45.6%;" data-city="Concepción" data-address="Portales 530 Of 31" data-detail="Oficina TelcoSur para trabajadores y coordinación comercial.">
              <span></span>
              Concepción
            </button>
            <button class="map-marker" type="button" style="left: 51%; top: 58.1%;" data-city="Temuco" data-address="Manuel Bulnes 815 Of 402" data-detail="Oficina TelcoSur para trabajadores y coordinación comercial.">
              <span></span>
              Temuco
            </button>

            <button class="map-marker" type="button" style="left: 48.9%; top: 67.9%;" data-city="Valdivia" data-address="Independencia 630 Of 304, 3er piso" data-detail="Oficina TelcoSur para trabajadores y coordinación comercial.">
              <span></span>
              Valdivia
            </button>

            <button class="map-marker" type="button" style="left: 48.9%; top: 77%;" data-city="Osorno" data-address="Conrrado Anthauer 1190 Of D, 2do piso" data-detail="Oficina TelcoSur para trabajadores y coordinación comercial.">
              <span></span>
              Osorno
            </button>

            <button class="map-marker" type="button" style="left: 49%; top: 87.2%;" data-city="Puerto Montt" data-address="Benavente N°540" data-detail="Oficina TelcoSur para trabajadores y coordinación comercial.">
              <span></span>
              Puerto Montt
            </button>
          </div>
        </div>

        <aside class="map-info" id="coverage-map-info" aria-live="polite">
          <span>Oficina seleccionada</span>
          <h3>Elige una oficina del mapa</h3>
          <p>Haz clic en un marcador para ver la plaza y dirección de la oficina TelcoSur correspondiente.</p>
          <div class="map-info-highlights"><b>Respuesta guiada</b><b>Datos de oficina</b><b>Consulta directa</b></div>
          <a href="contacto.php" class="btn-primary">Consultar oficina</a>
        </aside>
        <div class="city-quick-panel" aria-label="Seleccion rapida de oficinas">
          <div>
            <span>Seleccion rapida</span>
            <h2>Encuentra tu plaza en un clic</h2>
            <p>Elige una ciudad para activar su marcador, ver la direccion y completar el formulario de cobertura.</p>
          </div>
          <div class="city-chip-list">
            <button type="button" class="office-chip" data-office-city="Santiago">Santiago</button>
            <button type="button" class="office-chip" data-office-city="Talca">Talca</button>
            <button type="button" class="office-chip" data-office-city="Chillán">Chillan</button>
            <button type="button" class="office-chip" data-office-city="Concepción">Concepcion</button>
            <button type="button" class="office-chip" data-office-city="Temuco">Temuco</button>
            <button type="button" class="office-chip" data-office-city="Valdivia">Valdivia</button>
            <button type="button" class="office-chip" data-office-city="Osorno">Osorno</button>
            <button type="button" class="office-chip" data-office-city="Puerto Montt">Puerto Montt</button>
          </div>
        </div>
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
        <?php require __DIR__ . '/includes/csrf-input.php'; ?>
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

<?php require __DIR__ . '/includes/layout-end.php'; ?>
