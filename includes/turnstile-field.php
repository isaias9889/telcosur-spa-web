<?php
require_once __DIR__ . '/site-config.php';

if (!turnstileEnabled()) {
    return;
}

static $turnstileScriptLoaded = false;
if (!$turnstileScriptLoaded) {
    $turnstileScriptLoaded = true;
    echo '<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>' . "\n";
}
?>
<div class="turnstile-field" data-turnstile>
  <div class="cf-turnstile" data-sitekey="<?php echo htmlspecialchars(turnstileSiteKey(), ENT_QUOTES, 'UTF-8'); ?>" data-theme="light"></div>
</div>
