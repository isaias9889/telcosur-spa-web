<?php
require __DIR__ . '/security.php';
$csrfToken = csrfToken();

$pageTitle = 'Catálogo de referencia | TelcoSur';
$pageDescription = 'Referencia de alternativas hogar Claro y VTR. TelcoSur orienta según cobertura y disponibilidad técnica en el sur de Chile.';
$activeNav = 'servicios';
$whatsappMessage = 'Hola TelcoSur, quisiera recibir información sobre servicios hogar.';
$mobilePrimaryHref = '#consulta-plan';
$mobilePrimaryLabel = 'Consultar disponibilidad';

require __DIR__ . '/includes/layout-start.php';
?>

  <main id="contenido" class="corp-plans-page">
    <?php
    $breadcrumbItems = [
        ['label' => 'Inicio', 'href' => 'index.php'],
        ['label' => 'Servicios', 'href' => 'servicios.php'],
        ['label' => 'Catálogo', 'href' => 'planes.php'],
    ];
    $heroEyebrow = 'Referencia de servicios';
    $heroTitle = 'Catálogo orientativo Claro y VTR';
    $heroLead = 'Valores y alternativas de referencia para hogares del sur. La contratación se orienta con validación de cobertura y consulta asistida por nuestro equipo.';
    $heroStats = [
        ['value' => '3', 'label' => 'líneas de servicio'],
        ['value' => 'Sur', 'label' => 'zona de operación'],
        ['value' => 'Asesoría', 'label' => 'consulta guiada'],
    ];
    require __DIR__ . '/includes/corp-page-hero.php';
    ?>

    <section class="corp-section alt" aria-label="Categorías de servicio">
      <div class="corp-section-head">
        <span class="eyebrow">Categorías</span>
        <h2>Líneas disponibles para hogares</h2>
      </div>
      <div class="corp-pillars corp-pillars--3">
        <article class="corp-pillar">
          <span class="corp-pillar-icon">01</span>
          <h3>Solo internet</h3>
          <p>Alternativas de 600 a 940 Megas para navegación, teletrabajo, estudios y uso familiar.</p>
          <a href="#solo-internet" data-plan-jump="solo-internet" class="sl-btn-outline">Ver alternativas</a>
        </article>
        <article class="corp-pillar">
          <span class="corp-pillar-icon">02</span>
          <h3>Internet + TV</h3>
          <p>Conectividad y televisión en un solo servicio para hogares que buscan una solución integral.</p>
          <a href="#internet-tv" data-plan-jump="internet-tv" class="sl-btn-outline">Ver alternativas</a>
        </article>
        <article class="corp-pillar">
          <span class="corp-pillar-icon">03</span>
          <h3>Streaming</h3>
          <p>Opciones orientadas a contenido digital, series, gaming y múltiples dispositivos conectados.</p>
          <a href="#streaming" data-plan-jump="streaming" class="sl-btn-outline">Ver alternativas</a>
        </article>
      </div>
    </section>

    <section class="corp-process-section" aria-label="Proceso de consulta">
      <div class="corp-section-head">
        <span class="eyebrow">Proceso</span>
        <h2>Consulta asistida con validación previa</h2>
        <p>Antes de avanzar, confirmamos cobertura y disponibilidad técnica para orientar con información clara.</p>
      </div>
      <div class="corp-process-steps">
        <article>
          <strong>01</strong>
          <h3>Selección de alternativa</h3>
          <p>Elige la categoría y referencia de servicio que deseas consultar.</p>
        </article>
        <article>
          <strong>02</strong>
          <h3>Validación territorial</h3>
          <p>Revisamos comuna, sector y factibilidad técnica según la operación regional.</p>
        </article>
        <article>
          <strong>03</strong>
          <h3>Orientación comercial</h3>
          <p>Un ejecutivo confirma condiciones, pasos siguientes y alternativas disponibles.</p>
        </article>
      </div>
    </section>

    <section id="planes" class="corp-plans-section anchor-section anim-section reveal-on-scroll">
      <div class="corp-section-head">
        <span class="eyebrow">Referencia de servicios</span>
        <h2>Alternativas por categoría</h2>
        <p>Valores referenciales sujetos a factibilidad técnica, comuna y condiciones vigentes de cada marca.</p>
      </div>

      <div class="plan-tabs corp-plan-tabs" role="tablist" aria-label="Categorías de servicios">
        <button class="tab active" type="button" role="tab" aria-selected="true" aria-controls="solo-internet" data-target="solo-internet">Solo Internet</button>
        <button class="tab" type="button" role="tab" aria-selected="false" aria-controls="internet-tv" data-target="internet-tv">Internet + TV</button>
        <button class="tab" type="button" role="tab" aria-selected="false" aria-controls="streaming" data-target="streaming">Streaming</button>
      </div>

      <div class="plan-category active" id="solo-internet" role="tabpanel">
        <h3 class="category-title">Solo Internet</h3>
        <div class="plans-grid corp-plans-grid anim-stagger">
          <article class="plan-card corp-plan-card reveal-on-scroll">
            <span class="corp-plan-tier">Básico</span>
            <h3>Fibra Hogar</h3>
            <strong>600</strong>
            <span>Megas</span>
            <ul>
              <li>Navegación y uso cotidiano</li>
              <li>Estudios y teletrabajo</li>
              <li>Varios dispositivos en el hogar</li>
            </ul>
            <p class="corp-plan-price">Desde <b>$14.990</b> /mes</p>
            <a href="#consulta-plan" class="plan-btn sl-btn-primary">Solicitar información</a>
          </article>
          <article class="plan-card corp-plan-card corp-plan-card--featured reveal-on-scroll">
            <span class="corp-plan-badge">Más popular</span>
            <span class="corp-plan-tier">Recomendado</span>
            <h3>Fibra Avanzado</h3>
            <strong>800</strong>
            <span>Megas</span>
            <ul>
              <li>Familias con alto consumo</li>
              <li>Streaming y videollamadas</li>
              <li>Mayor estabilidad de conexión</li>
            </ul>
            <p class="corp-plan-price">Desde <b>$15.990</b> /mes</p>
            <a href="#consulta-plan" class="plan-btn sl-btn-primary">Solicitar información</a>
          </article>
          <article class="plan-card corp-plan-card reveal-on-scroll">
            <span class="corp-plan-tier">Premium</span>
            <h3>Fibra Experto</h3>
            <strong>940</strong>
            <span>Megas</span>
            <ul>
              <li>Máximo rendimiento disponible</li>
              <li>Teletrabajo y contenido 4K</li>
              <li>Hogares con demanda elevada</li>
            </ul>
            <p class="corp-plan-price">Desde <b>$19.990</b> /mes</p>
            <a href="#consulta-plan" class="plan-btn sl-btn-primary">Solicitar información</a>
          </article>
        </div>
      </div>

      <div class="plan-category" id="internet-tv" role="tabpanel" hidden>
        <h3 class="category-title">Internet + TV</h3>
        <div class="plans-grid corp-plans-grid anim-stagger">
          <article class="plan-card corp-plan-card reveal-on-scroll">
            <span class="corp-plan-tier">Integrado</span>
            <h3>Fibra 600 + TV</h3>
            <strong>600</strong>
            <span>Megas + TV</span>
            <ul>
              <li>Internet para uso familiar</li>
              <li>Televisión incluida</li>
              <li>Solución hogar unificada</li>
            </ul>
            <p class="corp-plan-price">Desde <b>$31.990</b> /mes</p>
            <a href="#consulta-plan" class="plan-btn sl-btn-primary">Solicitar información</a>
          </article>
          <article class="plan-card corp-plan-card reveal-on-scroll">
            <span class="corp-plan-tier">Integrado</span>
            <h3>Fibra 800 + TV</h3>
            <strong>800</strong>
            <span>Megas + TV</span>
            <ul>
              <li>Mayor velocidad para el hogar</li>
              <li>TV e internet combinados</li>
              <li>Uso simultáneo estable</li>
            </ul>
            <p class="corp-plan-price">Desde <b>$33.990</b> /mes</p>
            <a href="#consulta-plan" class="plan-btn sl-btn-primary">Solicitar información</a>
          </article>
          <article class="plan-card corp-plan-card reveal-on-scroll">
            <span class="corp-plan-tier">Integrado</span>
            <h3>Fibra 940 + TV</h3>
            <strong>940</strong>
            <span>Megas + TV</span>
            <ul>
              <li>Máxima velocidad con TV</li>
              <li>Trabajo y entretenimiento</li>
              <li>Alto rendimiento hogar</li>
            </ul>
            <p class="corp-plan-price">Desde <b>$38.990</b> /mes</p>
            <a href="#consulta-plan" class="plan-btn sl-btn-primary">Solicitar información</a>
          </article>
        </div>
      </div>

      <div class="plan-category" id="streaming" role="tabpanel" hidden>
        <h3 class="category-title">Internet + Streaming</h3>
        <div class="plans-grid corp-plans-grid anim-stagger">
          <article class="plan-card corp-plan-card reveal-on-scroll">
            <span class="corp-plan-tier">Digital</span>
            <h3>Fibra 600 Stream</h3>
            <strong>600</strong>
            <span>Megas</span>
            <ul>
              <li>Series y plataformas digitales</li>
              <li>Uso diario de entretenimiento</li>
              <li>Conexión estable</li>
            </ul>
            <p class="corp-plan-price">Desde <b>$20.990</b> /mes</p>
            <a href="#consulta-plan" class="plan-btn sl-btn-primary">Solicitar información</a>
          </article>
          <article class="plan-card corp-plan-card reveal-on-scroll">
            <span class="corp-plan-tier">Digital</span>
            <h3>Fibra 800 Stream</h3>
            <strong>800</strong>
            <span>Megas</span>
            <ul>
              <li>Varios equipos conectados</li>
              <li>Streaming fluido</li>
              <li>Hogares conectados</li>
            </ul>
            <p class="corp-plan-price">Desde <b>$21.990</b> /mes</p>
            <a href="#consulta-plan" class="plan-btn sl-btn-primary">Solicitar información</a>
          </article>
          <article class="plan-card corp-plan-card reveal-on-scroll">
            <span class="corp-plan-tier">Digital</span>
            <h3>Fibra 940 Stream</h3>
            <strong>940</strong>
            <span>Megas</span>
            <ul>
              <li>Streaming 4K y gaming</li>
              <li>Teletrabajo exigente</li>
              <li>Máximo rendimiento</li>
            </ul>
            <p class="corp-plan-price">Desde <b>$25.990</b> /mes</p>
            <a href="#consulta-plan" class="plan-btn sl-btn-primary">Solicitar información</a>
          </article>
        </div>
      </div>

      <p class="corp-price-note">Valores referenciales. Sujetos a factibilidad técnica, disponibilidad territorial y condiciones comerciales vigentes de Claro y VTR.</p>
    </section>

    <section id="consulta-plan" class="application-section anchor-section anim-section reveal-on-scroll">
      <div class="corp-section-head">
        <span class="eyebrow">Consulta</span>
        <h2>Solicita orientación sobre servicios hogar</h2>
        <p>Completa tus datos para que nuestro equipo revise cobertura y alternativas disponibles en tu comuna.</p>
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
            <input type="text" name="comuna" autocomplete="address-level2" placeholder="Ej: Puerto Montt" required>
          </label>
          <label>
            Servicio de interés
            <input type="text" name="plan_interes" id="plan-interes" placeholder="Ej: Fibra Avanzado 800 Megas" required>
          </label>
        </div>
        <label class="full-field">
          Mensaje opcional
          <textarea name="mensaje" rows="4" placeholder="Indica dirección o sector para revisar factibilidad."></textarea>
        </label>
        <?php require __DIR__ . '/includes/turnstile-field.php'; ?>
        <div class="form-actions">
          <button type="submit" class="sl-btn-primary">Enviar consulta</button>
          <a href="#" class="sl-btn-outline contact-link" data-whatsapp-message="Hola TelcoSur, quiero consultar un servicio hogar. Mi teléfono es:">Consultar por WhatsApp</a>
        </div>
        <p class="corp-form-note">Tu consulta queda registrada para validación de cobertura antes de confirmar cualquier contratación.</p>
      </form>
    </section>

    <?php require_once __DIR__ . '/includes/salesland-brands.php'; ?>
  </main>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
