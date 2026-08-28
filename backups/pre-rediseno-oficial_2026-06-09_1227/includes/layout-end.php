  <footer class="footer">
    <p><strong>TelcoSur SPA</strong> - Servicios de telecomunicaciones para hogares y oportunidades comerciales</p>
    <p>Atención personalizada • Todos los derechos reservados © 2026</p>
  </footer>

  <div class="mobile-action-bar" aria-label="Acciones rápidas móviles">
    <a class="mobile-action-primary" href="<?php echo htmlspecialchars($mobilePrimaryHref, ENT_QUOTES, 'UTF-8'); ?>">
      <?php echo htmlspecialchars($mobilePrimaryLabel, ENT_QUOTES, 'UTF-8'); ?>
    </a>
    <a href="#" class="mobile-action-whatsapp" data-whatsapp-message="<?php echo htmlspecialchars($mobileWhatsappMessage, ENT_QUOTES, 'UTF-8'); ?>">
      <img src="assets/logo-whatsapp.jpeg" alt="" aria-hidden="true">WhatsApp
    </a>
  </div>
  <a href="#" class="floating-whatsapp" aria-label="Contactar a TelcoSur SPA por WhatsApp" data-whatsapp-message="<?php echo htmlspecialchars($floatingWhatsappMessage, ENT_QUOTES, 'UTF-8'); ?>">WhatsApp</a>
  <script src="js/main.js"></script>
</body>
</html>
