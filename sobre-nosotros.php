<?php
$pageTitle = 'Nosotros | TelcoSur';
$pageDescription = 'TelcoSur, distribuidor autorizado Claro y VTR en el sur de Chile. Conoce nuestra misión, valores, equipo y presencia regional.';
$activeNav = 'sobre';
$ogImage = 'https://telcosurspa.cl/assets/og/og-nosotros.jpg';

require __DIR__ . '/includes/layout-start.php';
require_once __DIR__ . '/includes/equipo-data.php';
?>

  <main id="contenido">
    <?php
    $breadcrumbItems = [
        ['label' => 'Inicio', 'href' => 'index.php'],
        ['label' => 'Nosotros', 'href' => 'sobre-nosotros.php'],
    ];
    $heroEyebrow = 'Nosotros';
    $heroTitle = 'Una empresa regional con visión de largo plazo';
    $heroLead = 'TelcoSur conecta hogares, impulsa equipos comerciales y representa marcas líderes con operación ordenada en el sur de Chile.';
    require __DIR__ . '/includes/corp-page-hero.php';
    ?>

    <section class="corp-section alt">
      <div class="corp-team-feature">
        <div class="corp-hero-visual corp-hero-visual--live reveal-on-scroll">
          <div class="corp-hero-frame">
            <img src="<?php echo htmlspecialchars(equipoPhotoUrl($equipoHero['src']), ENT_QUOTES, 'UTF-8'); ?>"
                 alt="<?php echo htmlspecialchars($equipoHero['alt'], ENT_QUOTES, 'UTF-8'); ?>"
                 style="object-position: <?php echo htmlspecialchars($equipoHero['position'], ENT_QUOTES, 'UTF-8'); ?>"
                 loading="eager"
                 width="760"
                 height="420">
          </div>
        </div>
        <div class="corp-team-feature-copy reveal-on-scroll">
          <span class="corp-hero-kicker">Quiénes somos</span>
          <h2>Personas comprometidas con el sur de Chile</h2>
          <p>Detrás de TelcoSur hay un equipo comercial, de coordinación y atención que trabaja cada día para acercar telecomunicaciones de calidad a hogares y comunidades.</p>
          <p>Operamos con presencia regional, cultura de equipo y el respaldo de ser distribuidor autorizado Claro y VTR.</p>
        </div>
      </div>
    </section>

    <section class="corp-brands">
      <p>Distribuidor autorizado</p>
      <div class="brand-logos">
        <img class="brand-partner-logo" src="<?php echo htmlspecialchars(brandLogoSrc('logo-claro.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="Claro Chile" width="220" height="76" loading="lazy">
        <img class="brand-partner-logo" src="<?php echo htmlspecialchars(brandLogoSrc('logo-vtr.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="VTR" width="220" height="76" loading="lazy">
      </div>
    </section>

    <section class="corp-section alt">
      <div class="corp-split">
        <div class="corp-split-copy">
          <span class="corp-hero-kicker">Nuestra misión</span>
          <h2>Cerca de ti, cerca de todos</h2>
          <p>Acercar telecomunicaciones de calidad a familias y comunidades del sur, con equipos locales, marcas confiables y una cultura de servicio responsable.</p>
          <ul class="corp-values">
            <li>Proximidad con clientes y colaboradores</li>
            <li>Transparencia en procesos comerciales</li>
            <li>Compromiso territorial sostenible</li>
          </ul>
        </div>
        <aside class="corp-panel">
          <h3>Visión</h3>
          <p>Ser referente regional en distribución de telecomunicaciones, reconocidos por nuestra operación, talento comercial y capacidad de generar valor en cada territorio donde estamos presentes.</p>
        </aside>
      </div>
    </section>

    <?php require __DIR__ . '/includes/equipo-gallery.php'; ?>

    <?php require __DIR__ . '/includes/equipo-extra-gallery.php'; ?>

    <section class="corp-section">
      <div class="corp-section-head">
        <span class="eyebrow">Cómo trabajamos</span>
        <h2>Profesionalismo con cercanía</h2>
        <p>Cada interacción refleja nuestro estándar: información clara, seguimiento ordenado y respeto por las personas con las que trabajamos.</p>
      </div>
      <div class="corp-pillars">
        <article class="corp-pillar">
          <h3>Personas</h3>
          <p>Formamos y acompañamos equipos comerciales con foco en el desarrollo profesional.</p>
        </article>
        <article class="corp-pillar">
          <h3>Territorio</h3>
          <p>Operamos con oficinas y presencia en las principales ciudades del sur.</p>
        </article>
        <article class="corp-pillar">
          <h3>Marcas</h3>
          <p>Representamos servicios hogar de Claro y VTR con respaldo de distribuidor.</p>
        </article>
        <article class="corp-pillar">
          <h3>Confianza</h3>
          <p>Construimos relaciones duraderas con clientes, colaboradores y aliados.</p>
        </article>
      </div>
    </section>

    <?php
    $ctaTitle = '¿Necesitas más información?';
    $ctaLead = 'Conoce nuestra operación regional, valores y equipo detrás de TelcoSur.';
    $ctaHref = 'contacto.php';
    $ctaLabel = 'Contactar';
    require __DIR__ . '/includes/corp-cta-band.php';
    ?>
  </main>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
