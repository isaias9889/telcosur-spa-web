<?php
/**
 * Beneficios hogar — animación escalonada al scroll
 */
$beneficiosTelcosur = [
    ['icon' => '⚡', 'title' => 'Fibra óptica estable', 'desc' => 'Conexión confiable para navegación, estudios y teletrabajo.'],
    ['icon' => '🛠', 'title' => 'Instalación coordinada', 'desc' => 'Proceso asistido según factibilidad técnica y cobertura.'],
    ['icon' => '📞', 'title' => 'Soporte cercano', 'desc' => 'Orientación comercial y seguimiento durante tu consulta.'],
    ['icon' => '🏠', 'title' => 'Planes para hogar', 'desc' => 'Internet, TV y streaming con marcas Claro y VTR.'],
    ['icon' => '🚀', 'title' => 'Alta velocidad', 'desc' => 'Alternativas de hasta 940 Megas según disponibilidad.'],
];
?>
<section class="corp-benefits anim-section reveal-on-scroll" aria-labelledby="beneficios-telcosur">
  <div class="corp-section-head">
    <span class="eyebrow">Beneficios</span>
    <h2 id="beneficios-telcosur">Conectividad pensada para tu hogar</h2>
    <p>Servicios hogar con enfoque regional, asesoría clara y respaldo de marcas líderes.</p>
  </div>
  <div class="corp-benefits-grid anim-stagger">
    <?php foreach ($beneficiosTelcosur as $beneficio): ?>
      <article class="corp-benefit-card reveal-on-scroll">
        <span class="corp-benefit-icon" aria-hidden="true"><?php echo $beneficio['icon']; ?></span>
        <h3><?php echo htmlspecialchars($beneficio['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
        <p><?php echo htmlspecialchars($beneficio['desc'], ENT_QUOTES, 'UTF-8'); ?></p>
      </article>
    <?php endforeach; ?>
  </div>
</section>
