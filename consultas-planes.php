<?php

require __DIR__ . '/admin-auth.php';

adminRequireLogin();

require __DIR__ . '/db.php';



$registros = $pdo->query('SELECT * FROM consultas_planes ORDER BY fecha_consulta DESC')->fetchAll();



$pageTitle = 'Consultas de planes | TelcoSur SPA';

require __DIR__ . '/includes/admin-layout-start.php';

?>



  <main class="application-section">

    <div class="section-title compact">

      <span>Registros</span>

      <h1>Consultas de planes</h1>

      <p>Total: <?php echo count($registros); ?> · Sesión: <?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'admin', ENT_QUOTES, 'UTF-8'); ?></p>

    </div>

    <div class="application-form admin-wrap">

      <table class="admin-table">

        <thead>

          <tr>

            <th>Fecha</th>

            <th>Nombre</th>

            <th>Teléfono</th>

            <th>Comuna</th>

            <th>Plan de interés</th>

            <th>Mensaje</th>

          </tr>

        </thead>

        <tbody>

          <?php foreach ($registros as $fila): ?>

            <tr>

              <td><?php echo htmlspecialchars($fila['fecha_consulta'], ENT_QUOTES, 'UTF-8'); ?></td>

              <td><?php echo htmlspecialchars($fila['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>

              <td><?php echo htmlspecialchars($fila['telefono'], ENT_QUOTES, 'UTF-8'); ?></td>

              <td><?php echo htmlspecialchars($fila['comuna'], ENT_QUOTES, 'UTF-8'); ?></td>

              <td><?php echo htmlspecialchars($fila['plan_interes'], ENT_QUOTES, 'UTF-8'); ?></td>

              <td><?php echo htmlspecialchars($fila['mensaje'], ENT_QUOTES, 'UTF-8'); ?></td>

            </tr>

          <?php endforeach; ?>

        </tbody>

      </table>

      <div class="form-actions">

        <a class="btn-primary" href="index.php">Volver al sitio</a>

        <a class="btn-secondary" href="postulaciones.php">Ver postulaciones</a>

        <a class="btn-secondary" href="exportar-consultas.php">Exportar CSV</a>

        <a class="btn-secondary" href="admin-logout.php">Cerrar sesión</a>

      </div>

    </div>

  </main>



<?php require __DIR__ . '/includes/admin-layout-end.php'; ?>

