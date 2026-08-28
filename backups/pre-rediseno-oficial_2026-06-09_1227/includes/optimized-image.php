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
?>
<picture>
  <source srcset="<?php echo htmlspecialchars($jpgPath, ENT_QUOTES, 'UTF-8'); ?>" type="image/jpeg">
  <img src="<?php echo htmlspecialchars($pngPath, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($imageAlt, ENT_QUOTES, 'UTF-8'); ?>" loading="<?php echo htmlspecialchars($imageLoading, ENT_QUOTES, 'UTF-8'); ?>"<?php echo $dimensions . $imageClass . $imageDraggable; ?>>
</picture>
