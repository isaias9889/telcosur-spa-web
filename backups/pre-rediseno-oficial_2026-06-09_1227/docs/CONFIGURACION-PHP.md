# Configuración PHP recomendada — TelcoSur SPA

Valores sugeridos para `php.ini` o el selector de PHP del hosting (cPanel → Select PHP Version → Options).

## Valores mínimos

| Directiva | Valor recomendado | Motivo |
|-----------|-------------------|--------|
| `upload_max_filesize` | `8M` | CVs hasta 5 MB |
| `post_max_size` | `10M` | Formulario + archivo adjunto |
| `max_execution_time` | `60` | Subida de archivos |
| `memory_limit` | `128M` | Suficiente para este proyecto |
| `session.gc_maxlifetime` | `1440` | Sesión admin (~24 min por defecto) |

## Extensiones requeridas

- `pdo_mysql`
- `session`
- `fileinfo`
- `json`
- `mbstring` (recomendada para textos UTF-8)

## Verificar en el servidor

Crea un archivo temporal `info.php`:

```php
<?php phpinfo();
```

Ábrelo en el navegador, revisa extensiones y límites, y **elimínalo después** por seguridad.

## Errores en producción

En hosting real conviene:

```ini
display_errors = Off
log_errors = On
```

Los errores deben ir al log del hosting, no mostrarse al visitante.

## Zona horaria

Si las fechas de postulaciones/consultas no coinciden con Chile:

```ini
date.timezone = America/Santiago
```
