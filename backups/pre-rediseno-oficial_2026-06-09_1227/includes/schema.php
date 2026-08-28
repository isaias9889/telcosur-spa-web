<?php
function ensurePostulacionesSchema(PDO $pdo): void
{
    $columnas = $pdo->query('SHOW COLUMNS FROM postulaciones')->fetchAll(PDO::FETCH_COLUMN);
    $columnasExistentes = array_flip($columnas);

    if (!isset($columnasExistentes['cargo'])) {
        $pdo->exec("ALTER TABLE postulaciones ADD cargo VARCHAR(120) DEFAULT 'Ejecutivo comercial' AFTER disponibilidad");
    }

    if (!isset($columnasExistentes['cv_archivo'])) {
        $pdo->exec('ALTER TABLE postulaciones ADD cv_archivo VARCHAR(255) NULL AFTER cargo');
    }

    if (!isset($columnasExistentes['estado'])) {
        $pdo->exec("ALTER TABLE postulaciones ADD estado VARCHAR(40) DEFAULT 'Recibida' AFTER cv_archivo");
    }
}
