<?php

require __DIR__ . '/admin-auth.php';

adminRequireLogin();

require __DIR__ . '/db.php';

require __DIR__ . '/includes/schema.php';



ensurePostulacionesSchema($pdo);



$registros = $pdo->query('SELECT * FROM postulaciones ORDER BY fecha_postulacion DESC')->fetchAll();



$pageTitle = 'Postulaciones | TelcoSur SPA';

require __DIR__ . '/includes/admin-layout-start.php';

?>



  <main class="application-section">

    <div class="section-title compact">

      <span>Registros</span>

      <h1>Postulaciones recibidas</h1>

      <p>Total: <?php echo count($registros); ?> · Sesión: <?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'admin', ENT_QUOTES, 'UTF-8'); ?></p>

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

                  <a href="ver-cv.php?f=<?php echo rawurlencode($fila['cv_archivo']); ?>" target="_blank" rel="noopener">Ver CV</a>

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

        <a class="btn-primary" href="index.php">Volver al sitio</a>

        <a class="btn-secondary" href="consultas-planes.php">Ver consultas de planes</a>

        <a class="btn-secondary" href="exportar-postulaciones.php">Exportar CSV</a>

        <a class="btn-secondary" href="admin-logout.php">Cerrar sesión</a>

      </div>

    </div>

  </main>



<?php require __DIR__ . '/includes/admin-layout-end.php'; ?>

