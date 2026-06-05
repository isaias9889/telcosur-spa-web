<?php
require __DIR__ . '/db.php';

$columnas = $pdo->query("SHOW COLUMNS FROM postulaciones")->fetchAll(PDO::FETCH_COLUMN);
$columnasExistentes = array_flip($columnas);

if (!isset($columnasExistentes['cargo'])) {
    $pdo->exec("ALTER TABLE postulaciones ADD cargo VARCHAR(120) DEFAULT 'Ejecutivo comercial' AFTER disponibilidad");
}

if (!isset($columnasExistentes['cv_archivo'])) {
    $pdo->exec("ALTER TABLE postulaciones ADD cv_archivo VARCHAR(255) NULL AFTER cargo");
}

if (!isset($columnasExistentes['estado'])) {
    $pdo->exec("ALTER TABLE postulaciones ADD estado VARCHAR(40) DEFAULT 'Recibida' AFTER cv_archivo");
}

$registros = $pdo->query('SELECT * FROM postulaciones ORDER BY fecha_postulacion DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="es-CL">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Postulaciones | TelcoSur SPA</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    .admin-table { width: 100%; border-collapse: collapse; background: #fff; }
    .admin-table th, .admin-table td { border: 1px solid #e2eaf5; padding: 10px; text-align: left; vertical-align: top; }
    .admin-table th { background: #f6f9ff; color: #071a3d; }
    .admin-wrap { overflow-x: auto; }
  </style>
</head>
<body>
  <main class="application-section">
    <div class="section-title compact">
      <span>Registros</span>
      <h1>Postulaciones recibidas</h1>
      <p>Total: <?php echo count($registros); ?></p>
    </div>
    <div class="application-form admin-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Nombre</th>
            <th>RUT</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Comuna</th>
            <th>Cargo</th>
            <th>Experiencia</th>
            <th>Disponibilidad</th>
            <th>Estado</th>
            <th>CV</th>
            <th>Mensaje</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($registros as $fila): ?>
            <tr>
              <td><?php echo htmlspecialchars($fila['fecha_postulacion'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($fila['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($fila['rut'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($fila['telefono'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($fila['correo'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($fila['comuna'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($fila['cargo'] ?? 'Ejecutivo comercial', ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($fila['experiencia'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($fila['disponibilidad'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($fila['estado'] ?? 'Recibida', ENT_QUOTES, 'UTF-8'); ?></td>
              <td>
                <?php if (!empty($fila['cv_archivo'])): ?>
                  <a href="uploads/cv/<?php echo rawurlencode($fila['cv_archivo']); ?>" target="_blank" rel="noopener">Ver CV</a>
                <?php else: ?>
                  Sin archivo
                <?php endif; ?>
              </td>
              <td><?php echo htmlspecialchars($fila['mensaje'], ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <div class="form-actions">
        <a class="btn-primary" href="index.html">Volver al sitio</a>
        <a class="btn-secondary" href="consultas-planes.php">Ver consultas de planes</a>
        <a class="btn-secondary" href="exportar-postulaciones.php">Exportar CSV</a>
      </div>
    </div>
  </main>
</body>
</html>
