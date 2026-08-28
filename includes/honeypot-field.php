<?php
/**
 * Campo trampa anti-spam (honeypot).
 * Está oculto para los usuarios; solo los bots lo rellenan. El handler descarta
 * silenciosamente cualquier envío que traiga este campo con contenido.
 */
?>
<div aria-hidden="true" style="position:absolute;left:-9999px;top:-9999px;width:1px;height:1px;overflow:hidden;">
  <label>No completes este campo
    <input type="text" name="sitio_web" tabindex="-1" autocomplete="off" value="">
  </label>
</div>
