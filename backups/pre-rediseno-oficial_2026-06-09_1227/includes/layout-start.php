<?php
require __DIR__ . '/layout-vars.php';
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
  <link rel="icon" type="image/png" href="assets/logo.png">
  <link rel="stylesheet" href="css/style.css">
  <?php foreach ($extraStylesheets as $stylesheet): ?>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($stylesheet, ENT_QUOTES, 'UTF-8'); ?>">
  <?php endforeach; ?>
  <?php echo $extraHead; ?>
</head>
<body>
  <header class="header">
    <a class="logo" href="<?php echo htmlspecialchars($homeUrl, ENT_QUOTES, 'UTF-8'); ?>" aria-label="Ir al inicio de TelcoSur SPA">
      <img src="assets/logo.png" alt="Logo de TelcoSur SPA" width="82" height="82">
    </a>

    <button class="mobile-menu-toggle" type="button" aria-label="Abrir menú" aria-expanded="false" aria-controls="mobile-main-menu"><span></span><span></span><span></span></button>

    <nav class="navbar" id="mobile-main-menu" aria-label="Navegación principal">
      <?php foreach ($navItems as $key => $item): ?>
        <a href="<?php echo htmlspecialchars($item['href'], ENT_QUOTES, 'UTF-8'); ?>"<?php echo $activeNav === $key ? ' aria-current="page"' : ''; ?>>
          <?php echo htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?>
        </a>
      <?php endforeach; ?>
    </nav>

    <a href="#" class="btn-whatsapp" data-whatsapp-message="<?php echo htmlspecialchars($whatsappMessage, ENT_QUOTES, 'UTF-8'); ?>">WhatsApp</a>
  </header>
