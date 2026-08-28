# TelcoSur SPA - Sitio Web

Sitio web de TelcoSur SPA con formularios conectados a MySQL para:

- Consultas de planes.
- Postulaciones de vendedores.

## Requisitos para usar en local

- XAMPP instalado.
- Apache encendido.
- MySQL encendido.

## Instalación local

1. Copiar esta carpeta dentro de:

```text
C:\xampp\htdocs\telcosur-spa-web
```

2. Crear archivos de configuración desde las plantillas:

```text
admin-config.example.php  ->  admin-config.php
db.example.php            ->  db.php
```

3. Abrir phpMyAdmin:

```text
http://localhost/phpmyadmin
```

4. Crear una base de datos llamada:

```text
telcosurspa
```

5. Importar el archivo:

```text
database.sql
```

6. Abrir el sitio:

```text
http://localhost/telcosur-spa-web/
```

La página principal vive en `index.php`. Si alguien entra por `index.html`, se redirige automáticamente.

## Panel administrativo

Las páginas de postulaciones y consultas requieren login.

1. Abre el login:

```text
http://localhost/telcosur-spa-web/admin-login.php
```

2. Credenciales por defecto en local (cámbialas en producción):

```text
Usuario: admin
Contraseña: TelcoSur2026!
```

3. Páginas protegidas:

```text
http://localhost/telcosur-spa-web/postulaciones.php
http://localhost/telcosur-spa-web/consultas-planes.php
```

Los CV solo se pueden ver desde el panel autenticado (`ver-cv.php`).

## Seguridad (Fase 1)

- Token CSRF en consultas, postulaciones y login admin.
- Rate limiting por IP (consultas, postulaciones, login).
- Validación en servidor de teléfono, correo y RUT.
- Headers de seguridad en endpoints sensibles.

## Arquitectura (Fase 2)

- `includes/layout-start.php` / `layout-end.php` — páginas públicas.
- `includes/admin-layout-start.php` / `admin-layout-end.php` — panel admin.
- `includes/schema.php` — migraciones de `postulaciones`.
- `css/admin.css` — estilos del panel.

## Rendimiento (Fase 3)

- `assets/fibra.jpg` y `assets/mapa-regional-sur.jpg` optimizados.
- `<picture>` con JPEG preferido (`includes/optimized-image.php`).
- Originales en `assets/original/`.

Regenerar imágenes:

```powershell
powershell -ExecutionPolicy Bypass -File scripts/optimize-images.ps1
```

## Despliegue y producción (Fase 4)

Documentación completa para publicar en hosting real:

- **[DEPLOYMENT.md](DEPLOYMENT.md)** — guía paso a paso (cPanel, DNS, SSL, backups, SEO).
- **[CHECKLIST-PRODUCCION.md](CHECKLIST-PRODUCCION.md)** — lista rápida pre-lanzamiento.
- **[NOTAS-OPERACION.md](NOTAS-OPERACION.md)** — uso diario del panel y flujos de trabajo.
- **[docs/CONFIGURACION-PHP.md](docs/CONFIGURACION-PHP.md)** — límites PHP del hosting.

### SEO y archivos públicos

| Archivo | Función |
|---------|---------|
| `robots.txt` | Indica a buscadores qué indexar; bloquea panel admin |
| `sitemap.xml` | Mapa de URLs para Google Search Console |

Antes de publicar, reemplaza `telcosurspa.cl` por tu dominio real en `index.php`, `robots.txt` y `sitemap.xml`.

### Configuración en producción

| Archivo | Plantilla | Contiene |
|---------|-----------|----------|
| `db.php` | `db.example.php` | Host, base de datos, usuario y contraseña MySQL |
| `admin-config.php` | `admin-config.example.php` | Usuario y hash de contraseña del panel |

Generar hash de contraseña admin:

```bash
php -r "echo password_hash('tu_contraseña', PASSWORD_DEFAULT);"
```

### HTTPS

Cuando tengas SSL en el hosting, descomenta la redirección HTTPS en `.htaccess`.

### Archivos que no deben subirse a Git

- `admin-config.php`
- `db.php` (si tiene credenciales reales)
- `uploads/cv/*`
- `storage/rate-limit/*`
