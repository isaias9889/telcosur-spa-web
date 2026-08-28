<?php
require __DIR__ . '/security.php';
csrfToken();
require_once __DIR__ . '/includes/equipo-data.php';
require_once __DIR__ . '/includes/brand-assets.php';

$pageTitle = 'TelcoSur | Distribuidor Claro y VTR en el Sur de Chile';
$pageDescription = 'TelcoSur impulsa la conectividad hogar y el desarrollo comercial en el sur de Chile como distribuidor autorizado Claro y VTR.';
$activeNav = 'inicio';
$bodyClass = 'corp-site sl-home';
$headerClass = 'header header--sl';
$hidePartnerStrip = true;
$logoHeight = 86;
$canonicalUrl = 'https://telcosurspa.cl/';
$ogImage = 'https://telcosurspa.cl/assets/og/og-home.jpg';
$heroPath = equipoPhotoPath($equipoHero['src']);
$heroVersion = equipoPhotoVersion($heroPath);
$heroAvif = preg_replace('/\.(jpe?g|png)$/i', '.avif', $heroPath);
$heroWebp = preg_replace('/\.(jpe?g|png)$/i', '.webp', $heroPath);
$heroSrc = equipoPhotoUrl($heroPath);
$heroPreload = is_file(__DIR__ . '/' . $heroAvif) ? $heroAvif . '?v=' . $heroVersion : (is_file(__DIR__ . '/' . $heroWebp) ? $heroWebp . '?v=' . $heroVersion : $heroSrc);
$heroPreloadType = is_file(__DIR__ . '/' . $heroAvif) ? 'image/avif' : (is_file(__DIR__ . '/' . $heroWebp) ? 'image/webp' : '');
$extraHead = '<link rel="preload" as="image" href="' . htmlspecialchars($heroPreload, ENT_QUOTES, 'UTF-8') . '"' . ($heroPreloadType !== '' ? ' type="' . $heroPreloadType . '"' : '') . ' fetchpriority="high">';
$mobilePrimaryHref = 'sobre-nosotros.php';
$mobilePrimaryLabel = 'Conocer TelcoSur';

require __DIR__ . '/includes/layout-start.php';
?>

  <main id="contenido">
    <section id="inicio" class="sl-hero anchor-section anim-hero">
      <div class="sl-hero-media" aria-hidden="true">
        <picture>
          <?php if (is_file(__DIR__ . '/' . $heroAvif)): ?>
          <source srcset="<?php echo htmlspecialchars($heroAvif . '?v=' . $heroVersion, ENT_QUOTES, 'UTF-8'); ?>" type="image/avif">
          <?php endif; ?>
          <?php if (is_file(__DIR__ . '/' . $heroWebp)): ?>
          <source srcset="<?php echo htmlspecialchars($heroWebp . '?v=' . $heroVersion, ENT_QUOTES, 'UTF-8'); ?>" type="image/webp">
          <?php endif; ?>
          <img src="<?php echo htmlspecialchars($heroSrc, ENT_QUOTES, 'UTF-8'); ?>" alt="" width="552" height="335" fetchpriority="high" decoding="async">
        </picture>
      </div>
      <div class="sl-hero-overlay" aria-hidden="true"></div>
      <div class="sl-hero-inner">
        <div class="sl-hero-content">
          <div class="sl-hero-eyebrow-row anim-hero__item" style="--anim-i: 0">
            <p class="sl-hero-eyebrow">Distribuidor autorizado Claro y VTR</p>
            <div class="sl-hero-brands" aria-hidden="true">
              <img class="brand-partner-logo sl-hero-brand" src="<?php echo htmlspecialchars(brandLogoSrc('logo-claro.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="" width="72" height="28" loading="eager" decoding="async">
              <img class="brand-partner-logo sl-hero-brand" src="<?php echo htmlspecialchars(brandLogoSrc('logo-vtr.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="" width="72" height="28" loading="eager" decoding="async">
            </div>
          </div>
          <h1 class="anim-hero__item" style="--anim-i: 1">Impulsamos <span class="sl-hero-accent">conectividad</span> y desarrollo comercial en el sur de Chile</h1>
          <p class="sl-hero-lead anim-hero__item" style="--anim-i: 2">TelcoSur es una empresa regional con equipos en terreno, presencia territorial y respaldo de marcas líderes. <em>Cerca de ti, cerca de todos.</em></p>
          <div class="sl-hero-actions anim-hero__item" style="--anim-i: 3">
            <a href="sobre-nosotros.php" class="sl-btn-primary sl-btn-primary--hero">Conocer la empresa</a>
            <a href="servicios.php" class="sl-btn-ghost">Nuestra operación</a>
          </div>
          <p class="sl-hero-meta anim-hero__item" style="--anim-i: 4">
            <a href="contacto.php">Contacto institucional</a>
          </p>
        </div>
      </div>
      <a href="#quienes-somos" class="sl-hero-scroll" aria-label="Desplazarse al contenido">
        <span class="sl-hero-scroll-icon" aria-hidden="true"></span>
        <span class="sl-hero-scroll-label">Explorar</span>
      </a>
    </section>

    <?php require __DIR__ . '/includes/corp-highlight-strip.php'; ?>

    <section id="quienes-somos" class="sl-about anim-section reveal-on-scroll">
      <div class="sl-about-copy reveal-on-scroll">
        <span class="eyebrow sl-about-eyebrow">Quiénes somos</span>
        <h2>Una empresa regional con equipos en terreno</h2>
        <p>Somos una empresa de telecomunicaciones con operación regional, equipos comerciales en terreno y respaldo de marcas líderes. Llevamos conectividad hogar a familias del sur con procesos ordenados y presencia local.</p>
        <a href="sobre-nosotros.php" class="sl-btn-outline">Nuestra historia</a>
      </div>
    </section>

    <?php require __DIR__ . '/includes/corp-institutional-pillars.php'; ?>

    <?php require __DIR__ . '/includes/salesland-sections.php'; ?>

    <?php require __DIR__ . '/includes/corp-process.php'; ?>

    <section class="corp-section sl-team-preview anim-section reveal-on-scroll" aria-labelledby="equipo-home-titulo">
      <div class="corp-section-head">
        <span class="eyebrow">Nuestro equipo</span>
        <h2 id="equipo-home-titulo">Personas que impulsan la conectividad regional</h2>
        <p>Colaboradores comprometidos con la operación territorial y el desarrollo comercial en el sur de Chile. Haz clic en cada imagen para conocer más.</p>
      </div>
      <div class="corp-team-gallery corp-team-gallery--compact anim-stagger">
        <?php foreach (array_slice($equipoGaleriaVisible, 0, 3) as $foto): ?>
          <?php require __DIR__ . '/includes/equipo-card.php'; ?>
        <?php endforeach; ?>
      </div>
      <p class="sl-team-preview-cta">
        <a href="sobre-nosotros.php" class="sl-btn-outline">Conocer al equipo</a>
      </p>
    </section>

    <section class="corp-section alt anim-section reveal-on-scroll" id="presencia-regional">
      <div class="corp-section-head">
        <span class="eyebrow">Presencia regional</span>
        <h2>Operamos donde nuestros clientes y equipos nos necesitan</h2>
        <p>Plazas comerciales desde Santiago hasta Puerto Montt para coordinar operaciones, talento y atención territorial.</p>
      </div>
      <?php
      $mapVariant = 'compact';
      require __DIR__ . '/includes/interactive-map.php';
      ?>
      <p class="corp-presence-cta">
        <a href="cobertura.php" class="sl-btn-outline">Ver detalle de oficinas y cobertura</a>
      </p>
    </section>

    <section class="corp-talent anim-section reveal-on-scroll" aria-labelledby="talento-telcosur">
      <div class="corp-talent-inner">
        <div>
          <span class="corp-hero-kicker">Talento</span>
          <h2 id="talento-telcosur">Construimos equipos comerciales con proyección</h2>
          <p>Formación en productos Claro y VTR, acompañamiento en terreno y cultura de equipo en el sur de Chile.</p>
          <a href="trabaja-con-nosotros.php" class="sl-btn-primary">Oportunidades laborales</a>
        </div>
        <aside class="corp-talent-card">
          <h3>¿Por qué TelcoSur?</h3>
          <ul>
            <li>8 plazas comerciales en el sur</li>
            <li>Capacitación y acompañamiento profesional</li>
            <li>Cultura de equipo y proyección regional</li>
          </ul>
        </aside>
      </div>
    </section>

    <?php require __DIR__ . '/includes/salesland-news.php'; ?>

    <?php require __DIR__ . '/includes/corp-hogar-secondary.php'; ?>

    <?php
    $ctaTitle = 'Hablemos de TelcoSur';
    $ctaLead = 'Consultas institucionales sobre nuestra empresa, operación regional y canales de contacto.';
    $ctaHref = 'contacto.php';
    $ctaLabel = 'Contacto institucional';
    $ctaSecondaryHref = 'sobre-nosotros.php';
    $ctaSecondaryLabel = 'Conocer la empresa';
    require __DIR__ . '/includes/corp-cta-band.php';
    ?>
  </main>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
