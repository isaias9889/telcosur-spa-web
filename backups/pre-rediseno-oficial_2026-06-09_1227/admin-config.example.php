<?php
/**
 * Copia este archivo como admin-config.php y cambia usuario/contraseña.
 *
 * Genera un nuevo hash con:
 * php -r "echo password_hash('tu_contraseña', PASSWORD_DEFAULT);"
 */
return [
    'username' => 'admin',
    'password_hash' => '$2y$10$CAMBIA_ESTE_HASH_POR_UNO_GENERADO_CON_TU_CONTRASEÑA',
];
