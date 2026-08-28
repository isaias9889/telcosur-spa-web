<?php
/**
 * Proceso "Cómo trabajamos" — timeline de pasos con íconos SVG inline.
 */
require_once __DIR__ . '/icon.php';
$procesoPasos = [
    ['icon' => 'phone-call', 'title' => 'Contacto y evaluación', 'desc' => 'Recibimos tu consulta y revisamos cobertura y necesidades en tu comuna.'],
    ['icon' => 'users-round', 'title' => 'Asesoría personalizada', 'desc' => 'Un ejecutivo te orienta sobre las alternativas Claro y VTR disponibles.'],
    ['icon' => 'clipboard-check', 'title' => 'Gestión y coordinación', 'desc' => 'Coordinamos la activación con la marca correspondiente y sus tiempos.'],
    ['icon' => 'headset', 'title' => 'Acompañamiento', 'desc' => 'Seguimiento cercano y canales de contacto tras la activación del servicio.'],
];
?>
<section class="corp-process anim-section reveal-on-scroll" aria-labelledby="proceso-telcosur">
  <div class="corp-section-head">
    <span class="eyebrow">Cómo trabajamos</span>
    <h2 id="proceso-telcosur">Un proceso ordenado y cercano</h2>
    <p>Acompañamos cada etapa con presencia territorial y procesos transparentes.</p>
  </div>
  <ol class="corp-process-track anim-stagger">
    <?php foreach ($procesoPasos as $i => $paso): ?>
      <li class="corp-process-step reveal-on-scroll">
        <span class="corp-process-num" aria-hidden="true"><?php echo str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT); ?></span>
        <span class="corp-process-icon" aria-hidden="true"><?php telcosurIcon($paso['icon']); ?></span>
        <h3><?php echo htmlspecialchars($paso['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
        <p><?php echo htmlspecialchars($paso['desc'], ENT_QUOTES, 'UTF-8'); ?></p>
      </li>
    <?php endforeach; ?>
  </ol>
</section>
