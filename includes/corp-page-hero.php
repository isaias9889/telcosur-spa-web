<?php
/**
 * Hero institucional para páginas internas.
 */
$heroEyebrow = $heroEyebrow ?? '';
$heroTitle = $heroTitle ?? '';
$heroLead = $heroLead ?? '';
$heroStats = $heroStats ?? [];
$heroActions = $heroActions ?? [];
$heroAnimIndex = 0;
?>
<?php if (!empty($breadcrumbItems)): ?>
  <?php require __DIR__ . '/corp-breadcrumb.php'; ?>
<?php endif; ?>
<section class="corp-page-hero anim-hero">
  <div class="corp-page-hero-glow" aria-hidden="true"></div>
  <div class="corp-page-hero-inner">
    <?php if ($heroEyebrow !== ''): ?>
      <p class="corp-page-hero-eyebrow anim-hero__item" style="--anim-i: <?php echo $heroAnimIndex++; ?>"><?php echo htmlspecialchars($heroEyebrow, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
    <h1 class="anim-hero__item" style="--anim-i: <?php echo $heroAnimIndex++; ?>"><?php echo htmlspecialchars($heroTitle, ENT_QUOTES, 'UTF-8'); ?></h1>
    <?php if ($heroLead !== ''): ?>
      <p class="corp-page-hero-lead anim-hero__item" style="--anim-i: <?php echo $heroAnimIndex++; ?>"><?php echo $heroLead; ?></p>
    <?php endif; ?>
    <?php if ($heroStats !== []): ?>
      <div class="corp-page-hero-stats anim-hero__item" style="--anim-i: <?php echo $heroAnimIndex++; ?>" aria-label="Indicadores">
        <?php foreach ($heroStats as $stat): ?>
          <article>
            <strong><?php echo htmlspecialchars($stat['value'], ENT_QUOTES, 'UTF-8'); ?></strong>
            <span><?php echo htmlspecialchars($stat['label'], ENT_QUOTES, 'UTF-8'); ?></span>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <?php if ($heroActions !== []): ?>
      <div class="corp-page-hero-actions anim-hero__item" style="--anim-i: <?php echo $heroAnimIndex++; ?>">
        <?php foreach ($heroActions as $action): ?>
          <a href="<?php echo htmlspecialchars($action['href'], ENT_QUOTES, 'UTF-8'); ?>" class="<?php echo htmlspecialchars($action['class'] ?? 'sl-btn-primary', ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo htmlspecialchars($action['label'], ENT_QUOTES, 'UTF-8'); ?>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
