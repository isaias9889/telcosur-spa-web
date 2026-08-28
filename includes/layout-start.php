<?php
require __DIR__ . '/layout-vars.php';
require_once __DIR__ . '/brand-assets.php';
?>
<!DOCTYPE html>
<html lang="es-CL">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
  <?php if ($pageDescription !== ''): ?>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8'); ?>">
  <?php endif; ?>
  <?php require __DIR__ . '/seo-head.php'; ?>
  <?php if ($canonicalUrl !== ''): ?>
    <link rel="canonical" href="<?php echo htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8'); ?>">
  <?php endif; ?>
  <?php require __DIR__ . '/json-ld.php'; ?>
  <meta name="theme-color" content="<?php echo htmlspecialchars($themeColor, ENT_QUOTES, 'UTF-8'); ?>">
  <link rel="icon" href="assets/favicon.ico" sizes="any">
  <link rel="icon" type="image/png" sizes="192x192" href="assets/icons/icon-192.png">
  <link rel="icon" type="image/png" sizes="512x512" href="assets/icons/icon-512.png">
  <link rel="apple-touch-icon" href="assets/icons/apple-touch-icon.png">
  <link rel="manifest" href="site.webmanifest">
  <link rel="preload" as="font" type="font/woff2" href="assets/fonts/inter.woff2" crossorigin>
  <link rel="preload" as="font" type="font/woff2" href="assets/fonts/plus-jakarta-sans.woff2" crossorigin>
  <?php
  $criticalCss = __DIR__ . '/../css/critical.min.css';
  if (is_file($criticalCss)) {
      echo '  <style>' . file_get_contents($criticalCss) . '</style>' . "\n";
  }
  $cssBundle = __DIR__ . '/../css/bundle.min.css';
  if (is_file($cssBundle)): ?>
  <link rel="preload" href="css/bundle.min.css?v=<?php echo filemtime($cssBundle); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="css/bundle.min.css?v=<?php echo filemtime($cssBundle); ?>"></noscript>
  <?php else: ?>
  <link rel="stylesheet" href="css/fonts.css?v=<?php echo filemtime(__DIR__ . '/../css/fonts.css'); ?>">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/corporate.css?v=<?php echo filemtime(__DIR__ . '/../css/corporate.css'); ?>">
  <link rel="stylesheet" href="css/animations.css?v=<?php echo filemtime(__DIR__ . '/../css/animations.css'); ?>">
  <link rel="stylesheet" href="css/polish.css?v=<?php echo filemtime(__DIR__ . '/../css/polish.css'); ?>">
  <link rel="stylesheet" href="css/accessibility.css?v=<?php echo filemtime(__DIR__ . '/../css/accessibility.css'); ?>">
  <?php endif; ?>
  <?php if (!empty($gaMeasurementId)): ?>
  <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo htmlspecialchars($gaMeasurementId, ENT_QUOTES, 'UTF-8'); ?>"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '<?php echo htmlspecialchars($gaMeasurementId, ENT_QUOTES, 'UTF-8'); ?>', { anonymize_ip: true });
  </script>
  <?php endif; ?>
  <?php echo $extraHead; ?>
</head>
<body class="<?php echo htmlspecialchars($bodyClass, ENT_QUOTES, 'UTF-8'); ?>">
  <a class="skip-link" href="#contenido">Saltar al contenido</a>
  <header class="<?php echo htmlspecialchars($headerClass, ENT_QUOTES, 'UTF-8'); ?>">
    <a class="logo" href="<?php echo htmlspecialchars($homeUrl, ENT_QUOTES, 'UTF-8'); ?>" aria-label="TelcoSur - Cerca de ti, cerca de todos">
      <img src="assets/logo.png" alt="TelcoSur - Cerca de ti, cerca de todos" height="<?php echo (int) $logoHeight; ?>">
    </a>

    <button class="mobile-menu-toggle" type="button" aria-label="Abrir menú" aria-expanded="false" aria-controls="mobile-main-menu"><span></span><span></span><span></span></button>

    <nav class="navbar" id="mobile-main-menu" aria-label="Navegación principal">
      <?php foreach ($navItems as $key => $item): ?>
        <a href="<?php echo htmlspecialchars($item['href'], ENT_QUOTES, 'UTF-8'); ?>"<?php echo $activeNav === $key ? ' aria-current="page"' : ''; ?>>
          <?php echo htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?>
        </a>
      <?php endforeach; ?>
    </nav>

    <a href="contacto.php" class="btn-contact">Contacto</a>
  </header>

  <?php if (empty($hidePartnerStrip)): require __DIR__ . '/partner-strip.php'; endif; ?>
