<?php
/**
 * Testimonios (voces del equipo TelcoSur).
 * NOTA: reemplaza estos textos por testimonios reales cuando los tengas.
 */
$testimonios = [
    [
        'quote' => 'Empecé como ejecutiva en terreno y hoy lidero un equipo. Acá se valora el esfuerzo y hay proyección real.',
        'name' => 'Camila Rodríguez',
        'role' => 'Supervisora comercial',
        'city' => 'Temuco',
    ],
    [
        'quote' => 'La capacitación en productos Claro y VTR es constante. Uno nunca se siente solo en la calle, siempre hay respaldo.',
        'name' => 'Matías Fuentes',
        'role' => 'Ejecutivo comercial',
        'city' => 'Concepción',
    ],
    [
        'quote' => 'Lo que más valoro es el compañerismo y que la empresa tiene presencia local de verdad, no solo en Santiago.',
        'name' => 'Daniela Soto',
        'role' => 'Ejecutiva de terreno',
        'city' => 'Puerto Montt',
    ],
    [
        'quote' => 'Los procesos son claros y ordenados. Eso da confianza para trabajar y para recomendar el servicio a los clientes.',
        'name' => 'Ignacio Vera',
        'role' => 'Coordinador de plaza',
        'city' => 'Valdivia',
    ],
];

$inicial = static function (string $nombre): string {
    $partes = preg_split('/\s+/', trim($nombre)) ?: [];
    $iniciales = '';
    foreach (array_slice($partes, 0, 2) as $parte) {
        $iniciales .= mb_strtoupper(mb_substr($parte, 0, 1));
    }
    return $iniciales;
};
?>
<section class="corp-testimonials anim-section reveal-on-scroll" aria-labelledby="testimonios-telcosur">
  <div class="corp-section-head">
    <span class="eyebrow">Voces del equipo</span>
    <h2 id="testimonios-telcosur">Lo que dicen quienes forman TelcoSur</h2>
    <p>Personas que construyen día a día la operación regional en el sur de Chile.</p>
  </div>
  <div class="corp-testimonials-track" role="list">
    <?php foreach ($testimonios as $t): ?>
      <figure class="corp-testimonial-card reveal-on-scroll" role="listitem">
        <span class="corp-testimonial-quote-mark" aria-hidden="true">&ldquo;</span>
        <blockquote><?php echo htmlspecialchars($t['quote'], ENT_QUOTES, 'UTF-8'); ?></blockquote>
        <figcaption class="corp-testimonial-author">
          <span class="corp-testimonial-avatar" aria-hidden="true"><?php echo htmlspecialchars($inicial($t['name']), ENT_QUOTES, 'UTF-8'); ?></span>
          <span class="corp-testimonial-meta">
            <strong><?php echo htmlspecialchars($t['name'], ENT_QUOTES, 'UTF-8'); ?></strong>
            <span><?php echo htmlspecialchars($t['role'] . ' · ' . $t['city'], ENT_QUOTES, 'UTF-8'); ?></span>
          </span>
        </figcaption>
      </figure>
    <?php endforeach; ?>
  </div>
</section>
