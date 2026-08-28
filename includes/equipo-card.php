<?php
/**
 * Tarjeta clicable del equipo.
 * Requiere: $foto (array desde equipo-data.php)
 */
$position = $foto['position'] ?? 'center center';
$slug = $foto['slug'] ?? '';
$href = $slug !== '' ? 'equipo-tema.php?tema=' . rawurlencode($slug) : 'sobre-nosotros.php';
$cardClass = 'corp-team-card reveal-on-scroll reveal-scale';
if (!empty($foto['card_class'])) {
    $cardClass .= ' ' . $foto['card_class'];
}
?>
<a
  href="<?php echo htmlspecialchars($href, ENT_QUOTES, 'UTF-8'); ?>"
  class="<?php echo htmlspecialchars($cardClass, ENT_QUOTES, 'UTF-8'); ?> corp-team-card--link"
  style="--img-pos: <?php echo htmlspecialchars($position, ENT_QUOTES, 'UTF-8'); ?>;"
  aria-label="Conocer más sobre <?php echo htmlspecialchars($foto['caption'], ENT_QUOTES, 'UTF-8'); ?>"
>
  <div class="corp-team-media">
    <img
      src="<?php echo htmlspecialchars(equipoPhotoUrl($foto['src']), ENT_QUOTES, 'UTF-8'); ?>"
      alt="<?php echo htmlspecialchars($foto['alt'], ENT_QUOTES, 'UTF-8'); ?>"
      loading="lazy"
      decoding="async"
      width="640"
      height="400"
    >
    <span class="corp-team-card-overlay" aria-hidden="true">Ver más</span>
  </div>
  <span class="corp-team-card-caption">
    <?php echo htmlspecialchars($foto['caption'], ENT_QUOTES, 'UTF-8'); ?>
    <svg class="corp-team-card-arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
  </span>
</a>
