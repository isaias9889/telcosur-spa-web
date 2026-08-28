<?php
/**
 * Pilares institucionales TelcoSur — enfoque empresa, no venta directa
 */
require_once __DIR__ . '/icon.php';
$pilaresInstitucionales = [
    ['icon' => 'building-2', 'title' => 'Empresa regional', 'desc' => 'Estructura comercial y operativa desde Santiago hasta Puerto Montt.'],
    ['icon' => 'badge-check', 'title' => 'Marcas de confianza', 'desc' => 'Distribuidor autorizado Claro y VTR con respaldo territorial.'],
    ['icon' => 'users-round', 'title' => 'Equipos en terreno', 'desc' => 'Fuerza comercial con formación, seguimiento y cultura de equipo.'],
    ['icon' => 'map-pin', 'title' => 'Presencia local', 'desc' => 'Ocho plazas comerciales para coordinación y atención cercana.'],
    ['icon' => 'messages-square', 'title' => 'Relación institucional', 'desc' => 'Canales claros para hogares, colaboradores y aliados comerciales.'],
];
?>
<section class="corp-benefits corp-benefits--institutional anim-section reveal-on-scroll" aria-labelledby="pilares-telcosur">
  <div class="corp-section-head">
    <span class="eyebrow">TelcoSur SPA</span>
    <h2 id="pilares-telcosur">Una operación regional con visión de largo plazo</h2>
    <p>Combinamos presencia territorial, equipos comerciales y representación de marcas líderes en el sur de Chile.</p>
  </div>
  <div class="corp-benefits-grid anim-stagger">
    <?php foreach ($pilaresInstitucionales as $pilar): ?>
      <article class="corp-benefit-card reveal-on-scroll">
        <span class="corp-benefit-icon" aria-hidden="true"><?php telcosurIcon($pilar['icon']); ?></span>
        <h3><?php echo htmlspecialchars($pilar['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
        <p><?php echo htmlspecialchars($pilar['desc'], ENT_QUOTES, 'UTF-8'); ?></p>
      </article>
    <?php endforeach; ?>
  </div>
</section>
