<?php
/**
 * Migas de pan corporativas.
 * Variables: $breadcrumbItems = [['label' => '...', 'href' => '...'], ...]
 */
if (empty($breadcrumbItems)) {
    return;
}
?>
<nav class="corp-breadcrumb anim-section reveal-on-scroll" aria-label="Ruta de navegación">
  <ol>
    <?php foreach ($breadcrumbItems as $index => $item): ?>
      <li>
        <?php if ($index < count($breadcrumbItems) - 1): ?>
          <a href="<?php echo htmlspecialchars($item['href'], ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?>
          </a>
        <?php else: ?>
          <span aria-current="page"><?php echo htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?></span>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ol>
</nav>
