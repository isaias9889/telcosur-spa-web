<?php

// Galería extra desactivada: las fotos corporativas están en la galería principal.
$equipoFotosExtra = [];

if ($equipoFotosExtra === []) {
    return;
}

?>
<section class="corp-section alt corp-team-extra anim-section reveal-on-scroll" aria-label="Galería del equipo">
  <div class="corp-section-head">
    <span class="eyebrow">En imágenes</span>
    <h2>Día a día en TelcoSur</h2>
    <p>Momentos de coordinación, trabajo en terreno y cultura de equipo en el sur de Chile. Haz clic en una foto para ampliarla.</p>
  </div>
  <div class="corp-team-extra-grid anim-stagger">
    <?php foreach ($equipoFotosExtra as $index => $foto): ?>
      <figure class="corp-team-extra-card reveal-on-scroll">
        <button
          type="button"
          class="corp-team-extra-trigger"
          data-photo-lightbox
          data-photo-index="<?php echo (int) $index; ?>"
          data-photo-src="<?php echo htmlspecialchars($foto['src'], ENT_QUOTES, 'UTF-8'); ?>"
          data-photo-alt="<?php echo htmlspecialchars($foto['alt'], ENT_QUOTES, 'UTF-8'); ?>"
          aria-label="Ampliar: <?php echo htmlspecialchars($foto['alt'], ENT_QUOTES, 'UTF-8'); ?>"
        >
          <?php
          $imageBase = preg_replace('/\.(jpe?g|png)$/i', '', $foto['src']);
          $imageAlt = $foto['alt'];
          $imageLoading = 'lazy';
          $imageStyle = 'object-position: ' . $foto['position'];
          require __DIR__ . '/optimized-image.php';
          ?>
          <span class="corp-team-extra-zoom" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M15 15l5 5M10 17a7 7 0 1 1 0-14 7 7 0 0 1 0 14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            Ampliar
          </span>
        </button>
      </figure>
    <?php endforeach; ?>
  </div>
</section>

<div id="photo-lightbox" class="photo-lightbox" hidden role="dialog" aria-modal="true" aria-label="Vista ampliada de foto">
  <button type="button" class="photo-lightbox__backdrop" data-photo-lightbox-close aria-label="Cerrar galería"></button>
  <div class="photo-lightbox__panel">
    <button type="button" class="photo-lightbox__close" data-photo-lightbox-close aria-label="Cerrar">&times;</button>
    <button type="button" class="photo-lightbox__nav photo-lightbox__nav--prev" data-photo-lightbox-prev aria-label="Foto anterior">&lsaquo;</button>
    <figure class="photo-lightbox__figure">
      <img class="photo-lightbox__img" alt="" width="1200" height="800">
      <figcaption class="photo-lightbox__caption"></figcaption>
    </figure>
    <button type="button" class="photo-lightbox__nav photo-lightbox__nav--next" data-photo-lightbox-next aria-label="Foto siguiente">&rsaquo;</button>
  </div>
</div>
