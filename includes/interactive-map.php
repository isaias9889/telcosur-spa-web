<?php
/**
 * Mapa interactivo de plazas comerciales.
 *
 * Variables opcionales:
 *   $mapVariant  'full' | 'compact'
 */
require_once __DIR__ . '/map-offices.php';

$mapVariant = $mapVariant ?? 'full';
$mapIsCompact = $mapVariant === 'compact';
$mapRootClass = 'interactive-map' . ($mapIsCompact ? ' interactive-map--compact' : '');

// Puntos de la ruta norte → sur (porcentajes sobre el canvas del mapa rotado).
$mapRoutePoints = array_map(static function (array $office): string {
    $left = rtrim($office['left'], '%');
    $top = rtrim($office['top'], '%');
    return $left . ',' . $top;
}, $mapOffices);
$mapRoutePath = implode(' ', $mapRoutePoints);
?>
<div class="<?php echo htmlspecialchars($mapRootClass, ENT_QUOTES, 'UTF-8'); ?> reveal-on-scroll reveal-scale" aria-label="Mapa interactivo de cobertura regional TelcoSur">
  <div class="map-layout map-layout--vertical<?php echo $mapIsCompact ? ' map-layout--compact' : ''; ?>">
    <div class="map-stage map-stage-portrait" data-map-stage>
      <div class="map-toolbar" aria-label="Controles del mapa">
        <button type="button" class="map-control" data-map-zoom="in" aria-label="Acercar mapa">+</button>
        <button type="button" class="map-control" data-map-zoom="out" aria-label="Alejar mapa">−</button>
        <button type="button" class="map-control map-control--text" data-map-reset aria-label="Restablecer mapa">Centrar</button>
      </div>
      <div class="map-portrait-frame">
        <div class="map-canvas map-canvas-portrait" data-map-canvas>
          <div class="map-live-badge">
            <span class="map-live-dot" aria-hidden="true"></span>
            8 plazas · Sur de Chile
          </div>

          <svg class="map-route" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
            <polyline points="<?php echo htmlspecialchars($mapRoutePath, ENT_QUOTES, 'UTF-8'); ?>" vector-effect="non-scaling-stroke"></polyline>
          </svg>

          <?php
          $imageBase = 'assets/mapa-regional-sur';
          $imageAlt = 'Mapa regional del sur de Chile con oficinas TelcoSur';
          $imageWidth = 1024;
          $imageHeight = 1536;
          $imageDraggable = 'false';
          require __DIR__ . '/optimized-image.php';
          ?>

          <?php foreach ($mapOffices as $i => $office): ?>
            <button
              class="map-marker"
              type="button"
              style="left: <?php echo htmlspecialchars($office['left'], ENT_QUOTES, 'UTF-8'); ?>; top: <?php echo htmlspecialchars($office['top'], ENT_QUOTES, 'UTF-8'); ?>;"
              data-city="<?php echo htmlspecialchars($office['city'], ENT_QUOTES, 'UTF-8'); ?>"
              data-address="<?php echo htmlspecialchars($office['address'], ENT_QUOTES, 'UTF-8'); ?>"
              data-detail="<?php echo htmlspecialchars($mapOfficeDetail, ENT_QUOTES, 'UTF-8'); ?>"
              data-index="<?php echo (int) ($i + 1); ?>"
              aria-label="<?php echo htmlspecialchars('Oficina TelcoSur en ' . $office['city'], ENT_QUOTES, 'UTF-8'); ?>"
            >
              <span class="map-marker-pin" aria-hidden="true">
                <span class="map-marker-num"><?php echo (int) ($i + 1); ?></span>
              </span>
              <span class="map-marker-label"><?php echo htmlspecialchars($office['city'], ENT_QUOTES, 'UTF-8'); ?></span>
            </button>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <p class="map-stage-caption" aria-hidden="true">Arrastra · Rueda para zoom · Toca una ciudad</p>

    <aside class="map-info" data-map-info aria-live="polite">
      <div class="map-info-empty">
        <span class="map-info-label">Oficina seleccionada</span>
        <h3>Elige una plaza del mapa</h3>
        <p>Haz clic en un marcador o selecciona una ciudad para ver la dirección de la oficina TelcoSur.</p>
        <?php if (!$mapIsCompact): ?>
        <ul class="map-info-highlights">
          <li>8 plazas comerciales</li>
          <li>Dirección de oficina</li>
          <li>Consulta directa</li>
        </ul>
        <?php endif; ?>
      </div>
    </aside>
  </div>

  <div class="city-quick-panel" aria-label="Selección rápida de oficinas">
    <div class="city-quick-panel-head">
      <span>Selección de plaza</span>
      <h2>Plazas comerciales TelcoSur</h2>
      <?php if (!$mapIsCompact): ?>
      <p>Selecciona una ciudad para centrar el mapa y ver la dirección correspondiente.</p>
      <?php endif; ?>
    </div>
    <div class="city-chip-list">
      <?php foreach ($mapOffices as $i => $office): ?>
        <button type="button" class="office-chip" data-office-city="<?php echo htmlspecialchars($office['city'], ENT_QUOTES, 'UTF-8'); ?>">
          <span class="office-chip-num"><?php echo (int) ($i + 1); ?></span>
          <?php echo htmlspecialchars($office['city'], ENT_QUOTES, 'UTF-8'); ?>
        </button>
      <?php endforeach; ?>
    </div>
  </div>
</div>
