<?php
/**
 * Copia este archivo como site-config.php (no subir a Git).
 *
 * Turnstile (Cloudflare): https://dash.cloudflare.com/?to=/:account/turnstile
 * Crea un widget con dominio telcosurspa.cl y localhost para pruebas.
 */
return [
  // Dominios de producción (HTTPS + HSTS en .htaccess solo aplican aquí).
  'production_hosts' => [
    'telcosurspa.cl',
    'www.telcosurspa.cl',
  ],

  'turnstile' => [
    'enabled' => false,
    'site_key' => 'TU_SITE_KEY_TURNSTILE',
    'secret_key' => 'TU_SECRET_KEY_TURNSTILE',
  ],
];
