<?php
require_once __DIR__ . '/includes/equipo-data.php';

$slug = isset($_GET['tema']) ? trim((string) $_GET['tema']) : '';
$tema = $slug !== '' ? equipoTemaPorSlug($slug) : null;

if ($tema === null) {
    header('Location: sobre-nosotros.php', true, 302);
    exit;
}

$pageTitle = $tema['title'] . ' | Equipo TelcoSur';
$pageDescription = $tema['lead'];
$activeNav = 'sobre';
$mobilePrimaryHref = 'sobre-nosotros.php';
$mobilePrimaryLabel = 'Volver al equipo';

require __DIR__ . '/includes/layout-start.php';
?>

  <main id="contenido" class="corp-equipo-tema-page">
    <?php
    $breadcrumbItems = [
        ['label' => 'Inicio', 'href' => 'index.php#inicio'],
        ['label' => 'Nosotros', 'href' => 'sobre-nosotros.php'],
        ['label' => $tema['title'], 'href' => 'equipo-tema.php?tema=' . rawurlencode($slug)],
    ];
    require __DIR__ . '/includes/corp-breadcrumb.php';
    ?>

    <section class="corp-equipo-tema-hero anim-hero">
      <div class="corp-equipo-tema-hero-media" aria-hidden="true">
        <img
          src="<?php echo htmlspecialchars(equipoPhotoUrl($tema['src']), ENT_QUOTES, 'UTF-8'); ?>"
          alt=""
          style="object-position: <?php echo htmlspecialchars($tema['position'] ?? 'center center', ENT_QUOTES, 'UTF-8'); ?>"
        >
      </div>
      <div class="corp-equipo-tema-hero-overlay" aria-hidden="true"></div>
      <div class="corp-equipo-tema-hero-content">
        <p class="corp-equipo-tema-kicker anim-hero__item" style="--anim-i: 0">Cultura TelcoSur</p>
        <h1 class="anim-hero__item" style="--anim-i: 1"><?php echo htmlspecialchars($tema['title'], ENT_QUOTES, 'UTF-8'); ?></h1>
        <p class="corp-equipo-tema-lead anim-hero__item" style="--anim-i: 2"><?php echo htmlspecialchars($tema['lead'], ENT_QUOTES, 'UTF-8'); ?></p>
        <div class="corp-equipo-tema-actions anim-hero__item" style="--anim-i: 3">
          <a href="sobre-nosotros.php" class="sl-btn-ghost">Volver al equipo</a>
        </div>
      </div>
    </section>

    <section class="corp-section anim-section reveal-on-scroll">
      <blockquote class="corp-pullquote reveal-on-scroll">
        <p><?php echo htmlspecialchars($tema['intro'], ENT_QUOTES, 'UTF-8'); ?></p>
      </blockquote>
      <div class="corp-equipo-tema-copy">
        <?php foreach ($tema['paragraphs'] as $paragraph): ?>
          <p><?php echo htmlspecialchars($paragraph, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="corp-section alt anim-section reveal-on-scroll">
      <div class="corp-section-head">
        <span class="eyebrow">En la práctica</span>
        <h2>Qué significa en TelcoSur</h2>
      </div>
      <ul class="corp-equipo-tema-highlights anim-stagger">
        <?php foreach ($tema['highlights'] as $highlight): ?>
          <li class="reveal-on-scroll"><?php echo htmlspecialchars($highlight, ENT_QUOTES, 'UTF-8'); ?></li>
        <?php endforeach; ?>
      </ul>
    </section>

    <?php require __DIR__ . '/includes/equipo-extra-gallery.php'; ?>

    <section class="corp-section alt anim-section reveal-on-scroll">
      <div class="corp-section-head">
        <span class="eyebrow">Conoce más valores</span>
        <h2>Otras dimensiones de nuestro equipo</h2>
      </div>
      <div class="corp-team-gallery corp-team-gallery--compact anim-stagger">
        <?php foreach ($equipoGaleriaVisible as $otroTema): ?>
          <?php if (($otroTema['slug'] ?? '') === $slug) { continue; } ?>
          <?php $foto = $otroTema; require __DIR__ . '/includes/equipo-card.php'; ?>
        <?php endforeach; ?>
      </div>
    </section>

    <?php
    $ctaTitle = '¿Quieres conocer más sobre TelcoSur?';
    $ctaLead = 'Descubre nuestra historia, operación regional y el equipo detrás de la empresa.';
    $ctaHref = 'sobre-nosotros.php';
    $ctaLabel = 'Ir a Nosotros';
    $ctaSecondaryHref = 'trabaja-con-nosotros.php';
    $ctaSecondaryLabel = 'Oportunidades laborales';
    require __DIR__ . '/includes/corp-cta-band.php';
    ?>
  </main>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
