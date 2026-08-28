# Copias de seguridad — TelcoSur SPA

## Restaurar archivos

1. Identifica la carpeta de respaldo, por ejemplo `pre-rediseno-oficial_2026-06-09_1227`.
2. Copia su contenido sobre el proyecto activo, **sin** sobrescribir:
   - `db.php`
   - `admin-config.php`
   - `uploads/cv/`
3. Verifica que el sitio abra en local o producción.

## Restaurar base de datos (XAMPP)

```bash
C:\xampp\mysql\bin\mysql.exe -u root telcosurspa < ruta\al\database_backup.sql
```

Si no hay dump SQL, exporta desde phpMyAdmin antes de cambios importantes.
