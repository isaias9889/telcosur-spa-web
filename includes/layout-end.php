  <footer class="footer footer-corporate">

    <div class="footer-grid">

      <div class="footer-brand">

        <img src="assets/logo.png" alt="TelcoSur" class="footer-logo" width="140" height="64" loading="lazy">

        <strong>TelcoSur</strong>

        <p><em>Cerca de ti, cerca de todos.</em> Empresa regional de telecomunicaciones con presencia en el sur de Chile.</p>

      </div>



      <nav class="footer-nav" aria-label="Enlaces del sitio">

        <strong>Empresa</strong>

        <a href="<?php echo htmlspecialchars($homeUrl, ENT_QUOTES, 'UTF-8'); ?>">Inicio</a>

        <a href="sobre-nosotros.php">Nosotros</a>

        <a href="servicios.php">Servicios</a>

        <a href="cobertura.php">Cobertura</a>

        <a href="trabaja-con-nosotros.php">Talento</a>

        <a href="contacto.php">Contacto</a>

        <a href="planes.php" class="footer-link-secondary">Catálogo hogar</a>

      </nav>



      <div class="footer-talent">

        <strong>Talento TelcoSur</strong>

        <p>Desarrollamos equipos comerciales con formación, acompañamiento y presencia regional en el sur de Chile.</p>

        <a href="trabaja-con-nosotros.php" class="footer-cta">Ver oportunidades</a>

      </div>

    </div>

    <div class="footer-partners-band" aria-label="Distribuidor autorizado Claro y VTR">
      <span class="footer-partners-label">Distribuidor autorizado</span>
      <div class="footer-partners">
        <img class="brand-partner-logo brand-partner-logo--on-dark" src="<?php echo htmlspecialchars(brandLogoSrc('logo-claro.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="Claro Chile" width="160" height="56" loading="lazy">
        <img class="brand-partner-logo brand-partner-logo--on-dark" src="<?php echo htmlspecialchars(brandLogoSrc('logo-vtr.png'), ENT_QUOTES, 'UTF-8'); ?>" alt="VTR" width="160" height="56" loading="lazy">
      </div>
    </div>

    <p class="footer-legal">TelcoSur SPA es distribuidor independiente. Claro y VTR son marcas de sus respectivos titulares. Precios referenciales sujetos a factibilidad técnica y condiciones vigentes. <a href="privacidad.php">Privacidad</a> · <a href="terminos.php">Términos</a> · © 2026</p>

  </footer>

  <a href="#" class="floating-whatsapp contact-link" aria-label="Contactar a TelcoSur por WhatsApp" data-whatsapp-message="<?php echo htmlspecialchars($floatingWhatsappMessage, ENT_QUOTES, 'UTF-8'); ?>">WhatsApp</a>

  <button type="button" class="back-to-top" aria-label="Volver arriba" hidden>
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 19V5M5 12l7-7 7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
  </button>

  <?php require __DIR__ . '/cookie-banner.php'; ?>

  <div class="mobile-action-bar" aria-label="Acciones rápidas móviles">

    <a class="mobile-action-primary" href="<?php echo htmlspecialchars($mobilePrimaryHref, ENT_QUOTES, 'UTF-8'); ?>">

      <?php echo htmlspecialchars($mobilePrimaryLabel, ENT_QUOTES, 'UTF-8'); ?>

    </a>

    <a href="contacto.php" class="mobile-action-secondary contact-link">Contacto</a>

  </div>

  <?php $jsBundle = __DIR__ . '/../js/bundle.min.js'; if (is_file($jsBundle)): ?>
  <script defer src="js/bundle.min.js?v=<?php echo filemtime($jsBundle); ?>"></script>
  <?php else: ?>
  <script defer src="js/animations.js?v=<?php echo filemtime(__DIR__ . '/../js/animations.js'); ?>"></script>
  <script defer src="js/main.js?v=<?php echo filemtime(__DIR__ . '/../js/main.js'); ?>"></script>
  <?php endif; ?>

</body>

</html>

