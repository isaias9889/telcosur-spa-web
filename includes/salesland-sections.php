<?php require __DIR__ . '/salesland-blocks.php'; ?>
<?php require_once __DIR__ . '/icon.php'; ?>

<section class="sl-value anim-section reveal-on-scroll" aria-labelledby="sl-propuesta-valor">
  <div class="corp-section-head sl-value-head">
    <span class="eyebrow">Operación</span>
    <h2 id="sl-propuesta-valor">Ámbitos de nuestra operación</h2>
    <p class="sl-value-lead">Cómo articulamos presencia regional, equipos comerciales y relación con clientes y aliados.</p>
  </div>
  <div class="sl-value-grid anim-stagger">
    <?php foreach ($propuestaValor as $index => $item): ?>
      <a
        href="<?php echo htmlspecialchars($item['href'], ENT_QUOTES, 'UTF-8'); ?>"
        class="sl-value-card reveal-on-scroll"
      >
        <span class="sl-value-icon" aria-hidden="true"><?php telcosurIcon($item['icon']); ?></span>
        <h3><?php echo htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
        <p><?php echo htmlspecialchars($item['desc'], ENT_QUOTES, 'UTF-8'); ?></p>
        <span class="sl-value-link">Saber más</span>
      </a>
    <?php endforeach; ?>
  </div>
</section>
