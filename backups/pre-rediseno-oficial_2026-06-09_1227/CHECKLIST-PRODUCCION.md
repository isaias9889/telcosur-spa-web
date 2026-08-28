# Checklist de producción — TelcoSur SPA

Marca cada ítem antes de abrir el sitio al público.

## Seguridad

- [ ] Contraseña admin cambiada (no usar `TelcoSur2026!`)
- [ ] `admin-config.php` creado en servidor
- [ ] `db.php` con usuario MySQL dedicado
- [ ] HTTPS activo
- [ ] Login admin probado
- [ ] Panel admin protegido (`postulaciones.php`, `consultas-planes.php`)
- [ ] CVs no accesibles sin login
- [ ] Repo público sin secretos (`admin-config.php`, `db.php` fuera de Git)

## Funcionalidad

- [ ] Base `telcosurspa` importada desde `database.sql`
- [ ] Consulta de planes guarda correctamente
- [ ] Postulación guarda correctamente
- [ ] Subida de CV funciona
- [ ] Exportar CSV funciona
- [ ] WhatsApp y formularios responden bien en móvil

## Rendimiento

- [ ] `fibra.jpg` y `mapa-regional-sur.jpg` desplegados
- [ ] Home carga en menos de 3 s en móvil 4G (revisión manual)

## Contenido

- [ ] Precios y textos revisados
- [ ] Dominio y canonical actualizados en `index.php`
- [ ] `robots.txt` y `sitemap.xml` con dominio real
- [ ] Sitemap enviado a Google Search Console
- [ ] Datos de contacto correctos (WhatsApp, correo postulaciones)

## PHP y hosting

- [ ] `upload_max_filesize` ≥ 8M y `post_max_size` ≥ 10M
- [ ] Extensiones `pdo_mysql`, `session`, `fileinfo` activas
- [ ] Zona horaria `America/Santiago` si las fechas se ven mal
- [ ] Sin `info.php` u otros archivos de prueba en el servidor

## Respaldo

- [ ] Backup inicial de base de datos
- [ ] Copia de `uploads/cv/` si ya hay postulaciones
- [ ] Copia segura de credenciales (`admin-config.php`, `db.php`)

---

- Guía completa: [DEPLOYMENT.md](DEPLOYMENT.md)
- Operación diaria: [NOTAS-OPERACION.md](NOTAS-OPERACION.md)
- PHP del hosting: [docs/CONFIGURACION-PHP.md](docs/CONFIGURACION-PHP.md)
