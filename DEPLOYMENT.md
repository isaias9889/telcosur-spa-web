# Despliegue en hosting — TelcoSur SPA

Guía para publicar el sitio en un servidor real (cPanel, hosting PHP compartido, VPS con Apache, etc.).

## Requisitos del servidor

| Requisito | Mínimo recomendado |
|-----------|-------------------|
| PHP | 8.0 o superior |
| MySQL / MariaDB | 5.7+ / 10.3+ |
| Apache | Con soporte `.htaccess` |
| Extensiones PHP | `pdo_mysql`, `session`, `fileinfo` |
| HTTPS | Obligatorio en producción |
| Espacio | ~50 MB + crecimiento de CVs en `uploads/cv/` |

## Estructura del proyecto

```text
telcosur-spa-web/
├── index.php              # Página principal
├── index.html             # Redirección a index.php
├── planes.php             # Planes y formulario de consulta
├── cobertura.php          # Mapa y consulta de cobertura
├── trabaja-con-nosotros.php
├── contacto.php / servicios.php / sobre-nosotros.php
├── consulta-plan.php      # Procesa consultas (POST)
├── postular.php           # Procesa postulaciones (POST)
├── admin-login.php        # Login del panel
├── postulaciones.php      # Panel: postulaciones
├── consultas-planes.php   # Panel: consultas
├── db.php                 # Credenciales MySQL (no subir a Git)
├── admin-config.php       # Credenciales admin (no subir a Git)
├── database.sql           # Esquema de base de datos
├── includes/              # Layouts, CSRF, schema, imágenes
├── assets/                # Imágenes optimizadas + original/
├── uploads/cv/            # CVs subidos por candidatos
├── storage/rate-limit/    # Cache de rate limiting
├── css/ / js/
├── robots.txt / sitemap.xml
└── docs/                  # Documentación técnica
```

## Endpoints PHP del sistema

| Archivo | Tipo | Descripción |
|---------|------|-------------|
| `index.php` | Público | Home con formularios |
| `consulta-plan.php` | POST | Guarda consulta de plan |
| `postular.php` | POST | Guarda postulación + CV |
| `resultado.php` | Público | Mensaje ok/error |
| `admin-login.php` | Público | Login admin |
| `postulaciones.php` | Admin | Lista postulaciones |
| `consultas-planes.php` | Admin | Lista consultas |
| `exportar-*.php` | Admin | Descarga CSV |
| `ver-cv.php` | Admin | Ver CV con sesión |
| `csrf-token.php` | API | Token JSON para formularios |

## 1. Subir archivos

1. Sube todo el proyecto al directorio público del hosting (`public_html`, `www` o subcarpeta).
2. Verifica que estas carpetas existan y sean escribibles por PHP:
   - `uploads/cv/`
   - `storage/rate-limit/`
3. **No subas** archivos sensibles desde tu PC si contienen datos reales de prueba con contraseñas distintas al entorno final.

### Métodos de subida

| Método | Cuándo usarlo |
|--------|---------------|
| **Administrador de archivos (cPanel)** | Pocos archivos o primera vez |
| **FTP / FileZilla** | Subida completa del proyecto |
| **Git + deploy** | Si tu hosting permite `git pull` en el servidor |

### Despliegue en cPanel (paso a paso)

1. Entra a **cPanel** de tu hosting.
2. Abre **Administrador de archivos** → `public_html`.
3. Sube un ZIP del proyecto y extráelo, o conecta por FTP.
4. Ve a **Bases de datos MySQL** → crea BD y usuario → asigna permisos.
5. Abre **phpMyAdmin** → importa `database.sql`.
6. En el servidor, copia `db.example.php` → `db.php` y edítalo.
7. Copia `admin-config.example.php` → `admin-config.php` y edítalo.
8. En **SSL/TLS** activa Let's Encrypt para tu dominio.
9. Prueba `https://tudominio.cl/` y `https://tudominio.cl/admin-login.php`.

## 2. Base de datos

1. Crea una base de datos MySQL, por ejemplo `telcosurspa`.
2. Crea un usuario MySQL con permisos solo sobre esa base.
3. Importa el esquema:

```text
database.sql
```

Desde phpMyAdmin o consola:

```bash
mysql -u usuario -p telcosurspa < database.sql
```

## 3. Configurar conexión MySQL

1. En el servidor, crea `db.php` a partir de la plantilla:

```text
db.example.php  ->  db.php
```

2. Edita `db.php` con los datos que te entregue el hosting:

```php
$host = 'localhost';        // o el host remoto del proveedor
$dbname = 'telcosurspa';
$user = 'usuario_mysql';
$password = 'contraseña_segura';
```

3. Prueba la conexión enviando un formulario de consulta o postulación.

## 4. Configurar panel administrador

1. Crea `admin-config.php` desde la plantilla:

```text
admin-config.example.php  ->  admin-config.php
```

2. Genera un hash de contraseña **nueva** (no uses la de local):

```bash
php -r "echo password_hash('tu_contraseña_fuerte', PASSWORD_DEFAULT);"
```

3. Pega el hash en `admin-config.php` junto con tu usuario admin.
4. Accede al login:

```text
https://tudominio.cl/admin-login.php
```

## 5. Permisos de carpetas

En Linux, permisos típicos:

```bash
chmod 755 uploads uploads/cv storage storage/rate-limit
```

Si el hosting lo permite, el propietario debe ser el usuario con el que corre Apache/PHP.

## 5.1 Configuración PHP del hosting

Revisa límites de subida y extensiones. Guía detallada: [docs/CONFIGURACION-PHP.md](docs/CONFIGURACION-PHP.md).

Mínimo necesario:

- `upload_max_filesize` ≥ 8M
- `post_max_size` ≥ 10M
- Extensiones: `pdo_mysql`, `session`, `fileinfo`

## 6. Dominio y DNS

1. En tu proveedor de dominio, apunta el dominio al hosting:
   - **Registro A** → IP del servidor, o
   - **Nameservers** del hosting (si gestionas DNS allí).
2. Espera propagación DNS (puede tardar hasta 24–48 h).
3. En cPanel, asigna el dominio a `public_html` o a la carpeta del proyecto.
4. Activa SSL cuando el dominio ya resuelva al servidor.

## 7. Activar HTTPS

1. Instala un certificado SSL (Let's Encrypt suele ser gratuito).
2. Descomenta la redirección HTTPS en `.htaccess` si tu hosting usa Apache.
3. Verifica que el sitio abra solo con `https://`.

## 8. SEO técnico

1. Actualiza el dominio en estos archivos si no es `telcosurspa.cl`:
   - `index.php` (canonical, Open Graph, Twitter, JSON-LD)
   - `robots.txt` (línea `Sitemap:`)
   - `sitemap.xml` (todas las URLs `<loc>`)
2. Sube `robots.txt` y `sitemap.xml` a la raíz pública.
3. En Google Search Console, envía el sitemap:
   `https://tudominio.cl/sitemap.xml`
4. Verifica que el panel admin **no** esté indexado (`robots.txt` ya lo bloquea).

## 9. Dominio y página de inicio

- La home principal es `index.php`.
- `index.html` redirige a `index.php`.
- `.htaccess` define `DirectoryIndex index.php index.html`.

URL esperada:

```text
https://tudominio.cl/
```

## 10. Entorno de prueba (staging)

Antes de tocar producción:

1. Crea un subdominio, por ejemplo `staging.tudominio.cl`.
2. Sube una copia del sitio y usa otra base de datos (`telcosurspa_staging`).
3. Prueba formularios, login y subida de CV.
4. Solo después replica cambios en producción.

## 11. Variables y archivos que no van al repositorio

Mantén fuera de Git (y revisa antes de cada deploy):

| Archivo / carpeta | Motivo |
|-------------------|--------|
| `admin-config.php` | Credenciales del panel |
| `db.php` | Credenciales MySQL (si usas valores reales) |
| `uploads/cv/*` | CVs de candidatos |
| `storage/rate-limit/*` | Cache temporal de rate limiting |
| `*.csv` | Exportaciones descargadas |

Plantillas seguras en el repo:

- `admin-config.example.php`
- `db.example.php`

## Checklist antes de publicar

### Seguridad

- [ ] Cambiaste la contraseña por defecto `TelcoSur2026!`
- [ ] `admin-config.php` existe en el servidor y no está en Git público
- [ ] `db.php` usa usuario MySQL dedicado (no `root`)
- [ ] HTTPS activo y funcionando
- [ ] Probaste login en `admin-login.php`
- [ ] Confirmaste que `postulaciones.php` y `consultas-planes.php` piden login
- [ ] Confirmaste que los CV no son públicos por URL directa (`uploads/cv/.htaccess`)

### Funcionalidad

- [ ] Formulario de consulta de planes guarda en MySQL
- [ ] Formulario de postulación guarda en MySQL
- [ ] Subida de CV funciona (PDF, DOC, DOCX, máx. 5 MB)
- [ ] Exportar CSV funciona desde el panel admin
- [ ] WhatsApp abre con mensaje correcto
- [ ] Mapa interactivo carga en `index.php` y `cobertura.php`

### Rendimiento

- [ ] Imágenes optimizadas presentes (`fibra.jpg`, `mapa-regional-sur.jpg`)
- [ ] Si reemplazaste imágenes, ejecutaste `scripts/optimize-images.ps1` o subiste las versiones comprimidas

### SEO y marca

- [ ] Actualizaste URLs en `index.php` si cambió el dominio (`canonical`, Open Graph)
- [ ] Actualizaste `robots.txt` y `sitemap.xml` con tu dominio real
- [ ] Enviaste sitemap a Google Search Console
- [ ] Favicon y logos se ven correctamente
- [ ] Revisaste textos de planes y precios referenciales
- [ ] Número WhatsApp correcto (`+56 9 6371 9919` en `js/main.js`)

### PHP y servidor

- [ ] `upload_max_filesize` y `post_max_size` suficientes (ver `docs/CONFIGURACION-PHP.md`)
- [ ] Zona horaria `America/Santiago` si las fechas se ven mal
- [ ] Eliminaste `info.php` si lo creaste para pruebas

## Checklist después de publicar

- [ ] Hacer una consulta de prueba desde el sitio público
- [ ] Hacer una postulación de prueba y borrarla del panel si no es real
- [ ] Guardar backup de la base de datos
- [ ] Guardar copia de `admin-config.php` y `db.php` en lugar seguro (gestor de contraseñas / bóveda)
- [ ] Si el repo es público, confirmar que no se subieron secretos

## Copias de seguridad (backup)

### Base de datos desde phpMyAdmin

1. Selecciona la base `telcosurspa`.
2. Pestaña **Exportar** → método rápido → SQL → Continuar.
3. Guarda el archivo con fecha: `telcosurspa_2026-06-09.sql`.

### Base de datos por consola

```bash
mysqldump -u usuario -p telcosurspa > backup_telcosurspa.sql
```

### Restaurar backup

```bash
mysql -u usuario -p telcosurspa < backup_telcosurspa.sql
```

### Archivos a respaldar además de la BD

- `uploads/cv/` (CVs de candidatos)
- `admin-config.php` y `db.php` (en gestor de contraseñas, no en Git)
- Exportaciones CSV descargadas del panel

## Actualizar el sitio en producción

1. Backup de BD y `uploads/cv/`.
2. Sube archivos nuevos por FTP o Git.
3. **No reemplaces** `db.php`, `admin-config.php` ni `uploads/cv/`.
4. Prueba: home, un formulario, login admin, ver un CV.
5. Si algo falla, restaura el backup y revisa el log de errores PHP del hosting.

## Documentación relacionada

| Archivo | Contenido |
|---------|-----------|
| [NOTAS-OPERACION.md](NOTAS-OPERACION.md) | Uso diario del panel y flujos de trabajo |
| [CHECKLIST-PRODUCCION.md](CHECKLIST-PRODUCCION.md) | Lista rápida pre-lanzamiento |
| [docs/CONFIGURACION-PHP.md](docs/CONFIGURACION-PHP.md) | Ajustes PHP del hosting |

## Mantenimiento recomendado

| Frecuencia | Tarea |
|------------|-------|
| Semanal | Revisar postulaciones y consultas en el panel |
| Mensual | Backup de base de datos y carpeta `uploads/cv/` |
| Trimestral | Cambiar contraseña admin y revisar accesos |
| Al actualizar código | Probar formularios y login en staging antes de producción |

## Solución de problemas

### Error de base de datos

- Revisa host, usuario, contraseña y nombre de BD en `db.php`.
- Confirma que el usuario tiene permisos sobre la base.

### Formulario no guarda / error CSRF

- Asegúrate de abrir el sitio por `http://` o `https://`, no como archivo local (`file://`).
- Limpia cookies del dominio y vuelve a intentar.

### Demasiados intentos (rate limit)

- Espera 15–30 minutos o revisa archivos en `storage/rate-limit/`.

### No se pueden subir CVs

- Verifica permisos de escritura en `uploads/cv/`.
- Revisa límite `upload_max_filesize` y `post_max_size` en `php.ini` (mín. 6M).

### Página de inicio en blanco o redirección

- Confirma que `index.php` tiene el contenido completo.
- Verifica `DirectoryIndex` en `.htaccess`.

### Error 500 después de subir .htaccess

- Algunos hostings no tienen `mod_headers`. Comenta el bloque `<IfModule mod_headers.c>` si falla.
- Prueba sin la regla HTTPS hasta tener SSL activo.

### Las fechas se guardan con hora incorrecta

- Configura `date.timezone = America/Santiago` en PHP.

### El dominio no abre / muestra parking del registrador

- Espera propagación DNS o revisa registro A / nameservers.

## Contacto técnico interno

Documenta aquí los datos de tu hosting cuando despliegues:

```text
Proveedor:
Plan hosting:
Dominio principal:
Subdominio staging:
IP del servidor:
Usuario cPanel:
Usuario MySQL:
Nombre base de datos:
Ruta pública (public_html):
Versión PHP:
SSL activo (sí/no):
Fecha de despliegue:
Responsable técnico:
Responsable comercial:
Correo postulaciones:
WhatsApp atención:
Último backup BD:
```

## Tablas de la base de datos

### `consultas_planes`

| Campo | Descripción |
|-------|-------------|
| id | Identificador automático |
| nombre | Nombre del cliente |
| telefono | Teléfono de contacto |
| comuna | Comuna o ciudad |
| plan_interes | Plan consultado |
| mensaje | Mensaje opcional |
| fecha_consulta | Fecha y hora del registro |

### `postulaciones`

| Campo | Descripción |
|-------|-------------|
| id | Identificador automático |
| nombre, rut, telefono, correo | Datos del candidato |
| comuna | Ubicación |
| cargo | Cargo de interés |
| experiencia, disponibilidad | Perfil comercial |
| cv_archivo | Nombre del archivo CV |
| estado | Por defecto: Recibida |
| mensaje | Motivación |
| fecha_postulacion | Fecha y hora |
