<?php
require __DIR__ . '/admin-auth.php';

if (adminIsLoggedIn()) {
    header('Location: postulaciones.php');
    exit;
}

$error = '';
$redirect = adminSafeRedirect($_GET['redirect'] ?? 'postulaciones.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $redirect = adminSafeRedirect($_POST['redirect'] ?? $redirect);

    if (!csrfValidate($_POST['csrf_token'] ?? null)) {
        $error = 'La sesión expiró. Intenta nuevamente.';
    } elseif (!rateLimitAllow('admin-login', 5, 900)) {
        $error = 'Demasiados intentos. Espera unos minutos e inténtalo otra vez.';
    } elseif ($username === '' || $password === '') {
        $error = 'Ingresa usuario y contraseña.';
    } elseif (adminAttemptLogin($username, $password)) {
        header('Location: ' . $redirect);
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos.';
    }
}

$csrfToken = csrfToken();
?>
<!DOCTYPE html>
<html lang="es-CL">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Acceso administrador | TelcoSur SPA</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
  <main class="application-section">
    <div class="admin-login-wrap">
      <h1>Panel administrador</h1>
      <p>Ingresa tus credenciales para ver postulaciones y consultas de planes.</p>

      <?php if ($error !== ''): ?>
        <div class="admin-login-error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
      <?php endif; ?>

      <form method="post" action="admin-login.php">
        <?php require __DIR__ . '/includes/csrf-input.php'; ?>
        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect, ENT_QUOTES, 'UTF-8'); ?>">

        <div class="admin-login-field">
          <label for="username">Usuario</label>
          <input id="username" name="username" type="text" autocomplete="username" required>
        </div>

        <div class="admin-login-field">
          <label for="password">Contraseña</label>
          <input id="password" name="password" type="password" autocomplete="current-password" required>
        </div>

        <div class="form-actions">
          <button class="btn-primary" type="submit">Ingresar</button>
          <a class="btn-secondary" href="index.php">Volver al sitio</a>
        </div>
      </form>
    </div>
  </main>
</body>
</html>
