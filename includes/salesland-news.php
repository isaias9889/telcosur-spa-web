<?php require __DIR__ . '/salesland-blocks.php'; ?>

<section class="sl-news anim-section reveal-on-scroll" aria-labelledby="sl-novedades">
  <div class="corp-section-head sl-news-head">
    <span class="eyebrow">Actualidad</span>
    <h2 id="sl-novedades">Novedades</h2>
  </div>
  <div class="sl-news-grid anim-stagger">
    <?php foreach ($novedadesTelcosur as $nota): ?>
      <article class="sl-news-card reveal-on-scroll">
        <span class="sl-news-tag"><?php echo htmlspecialchars($nota['tag'], ENT_QUOTES, 'UTF-8'); ?></span>
        <?php if (!empty($nota['date'])): ?>
          <time class="sl-news-date" datetime="<?php echo htmlspecialchars($nota['date'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($nota['date'], ENT_QUOTES, 'UTF-8'); ?></time>
        <?php endif; ?>
        <h3><?php echo htmlspecialchars($nota['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
        <p><?php echo htmlspecialchars($nota['excerpt'], ENT_QUOTES, 'UTF-8'); ?></p>
        <a href="<?php echo htmlspecialchars($nota['href'], ENT_QUOTES, 'UTF-8'); ?>">Leer más</a>
      </article>
    <?php endforeach; ?>
  </div>
</section>
