<?php
/**
 * Imagen optimizada con JPEG preferido y PNG como respaldo.
 *
 * Variables requeridas:
 * - $imageBase (ej: assets/fibra)
 * - $imageAlt
 *
 * Opcionales:
 * - $imageWidth
 * - $imageHeight
 * - $imageLoading ('lazy' por defecto, usar 'eager' en hero)
 * - $imageClass
 * - $imageDraggable ('false' para mapas)
 */
$imageLoading = $imageLoading ?? 'lazy';
$imageClass = isset($imageClass) ? ' class="' . htmlspecialchars($imageClass, ENT_QUOTES, 'UTF-8') . '"' : '';
$imageDraggable = isset($imageDraggable) ? ' draggable="' . htmlspecialchars($imageDraggable, ENT_QUOTES, 'UTF-8') . '"' : '';
$dimensions = '';

if (!empty($imageWidth) && !empty($imageHeight)) {
    $dimensions = ' width="' . (int) $imageWidth . '" height="' . (int) $imageHeight . '"';
}

$jpgPath = $imageBase . '.jpg';
$pngPath = $imageBase . '.png';
$webpPath = $imageBase . '.webp';
$avifPath = $imageBase . '.avif';
$hasAvif = is_file(__DIR__ . '/../' . $avifPath);
$hasWebp = is_file(__DIR__ . '/../' . $webpPath);
$fallbackSrc = is_file(__DIR__ . '/../' . $jpgPath) ? $jpgPath : $pngPath;
$imageStyle = $imageStyle ?? '';
$styleAttr = $imageStyle !== '' ? ' style="' . htmlspecialchars($imageStyle, ENT_QUOTES, 'UTF-8') . '"' : '';
?>
<picture>
  <?php if ($hasAvif): ?>
  <source srcset="<?php echo htmlspecialchars($avifPath, ENT_QUOTES, 'UTF-8'); ?>" type="image/avif">
  <?php endif; ?>
  <?php if ($hasWebp): ?>
  <source srcset="<?php echo htmlspecialchars($webpPath, ENT_QUOTES, 'UTF-8'); ?>" type="image/webp">
  <?php endif; ?>
  <?php if (is_file(__DIR__ . '/../' . $jpgPath)): ?>
  <source srcset="<?php echo htmlspecialchars($jpgPath, ENT_QUOTES, 'UTF-8'); ?>" type="image/jpeg">
  <?php endif; ?>
  <img src="<?php echo htmlspecialchars($fallbackSrc, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($imageAlt, ENT_QUOTES, 'UTF-8'); ?>" loading="<?php echo htmlspecialchars($imageLoading, ENT_QUOTES, 'UTF-8'); ?>"<?php echo $dimensions . $styleAttr . $imageClass . $imageDraggable; ?>>
</picture>
