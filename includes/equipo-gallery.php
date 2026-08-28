<?php require_once __DIR__ . '/equipo-data.php'; ?>

<section class="corp-section corp-team-section anim-section reveal-on-scroll" aria-labelledby="equipo-telcosur-titulo">
  <div class="corp-section-head">
    <span class="eyebrow">Nuestro equipo</span>
    <h2 id="equipo-telcosur-titulo">Las personas que hacen posible TelcoSur</h2>
    <p>Colaboradores comprometidos con la conectividad hogar y el desarrollo comercial en el sur de Chile. Haz clic en cada imagen para conocer más.</p>
  </div>
  <div class="corp-team-gallery anim-stagger">
    <?php foreach ($equipoGaleriaVisible as $foto): ?>
      <?php require __DIR__ . '/equipo-card.php'; ?>
    <?php endforeach; ?>
  </div>
</section>
