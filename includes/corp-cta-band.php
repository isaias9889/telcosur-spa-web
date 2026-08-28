<?php
/**
 * Banda CTA institucional reutilizable.
 * Variables: $ctaTitle, $ctaLead, $ctaHref, $ctaLabel, $ctaSecondaryHref, $ctaSecondaryLabel
 */
$ctaTitle = $ctaTitle ?? 'Conversemos';
$ctaLead = $ctaLead ?? 'Estamos disponibles para consultas sobre nuestra operación y servicios.';
$ctaHref = $ctaHref ?? 'contacto.php';
$ctaLabel = $ctaLabel ?? 'Contactar a TelcoSur';
$ctaSecondaryHref = $ctaSecondaryHref ?? '';
$ctaSecondaryLabel = $ctaSecondaryLabel ?? '';
?>
<section class="sl-cta corp-cta-band">
  <div class="corp-cta-band-inner">
  <h2><?php echo htmlspecialchars($ctaTitle, ENT_QUOTES, 'UTF-8'); ?></h2>
  <p><?php echo htmlspecialchars($ctaLead, ENT_QUOTES, 'UTF-8'); ?></p>
  <div class="corp-cta-actions">
    <a href="<?php echo htmlspecialchars($ctaHref, ENT_QUOTES, 'UTF-8'); ?>" class="sl-btn-primary"><?php echo htmlspecialchars($ctaLabel, ENT_QUOTES, 'UTF-8'); ?></a>
    <?php if ($ctaSecondaryHref !== '' && $ctaSecondaryLabel !== ''): ?>
      <a href="<?php echo htmlspecialchars($ctaSecondaryHref, ENT_QUOTES, 'UTF-8'); ?>" class="sl-btn-ghost-on-dark"><?php echo htmlspecialchars($ctaSecondaryLabel, ENT_QUOTES, 'UTF-8'); ?></a>
    <?php endif; ?>
  </div>
  </div>
</section>
