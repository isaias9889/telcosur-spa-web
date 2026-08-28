# Notas de operación — TelcoSur SPA

Guía rápida para el equipo que administra el sitio día a día.

## Rutas importantes

| Qué necesitas | URL |
|---------------|-----|
| Sitio público | `https://tudominio.cl/` |
| Login admin | `https://tudominio.cl/admin-login.php` |
| Postulaciones | `https://tudominio.cl/postulaciones.php` |
| Consultas de planes | `https://tudominio.cl/consultas-planes.php` |
| Exportar postulaciones | `https://tudominio.cl/exportar-postulaciones.php` |
| Exportar consultas | `https://tudominio.cl/exportar-consultas.php` |

## Flujo cuando llega una consulta de plan

1. El cliente completa el formulario en `index.php`, `planes.php` o `cobertura.php`.
2. Los datos se guardan en la tabla `consultas_planes`.
3. El equipo revisa en **Consultas de planes** del panel admin.
4. Se contacta al cliente por teléfono o WhatsApp (`+56 9 6371 9919`).
5. Opcional: exportar CSV para seguimiento en Excel.

Campos guardados: nombre, teléfono, comuna, plan de interés, mensaje, fecha.

## Flujo cuando llega una postulación

1. El candidato completa el formulario en `index.php` o `trabaja-con-nosotros.php`.
2. Los datos se guardan en `postulaciones` con estado **Recibida**.
3. Si adjunta CV, el archivo queda en `uploads/cv/` y solo se ve con login (`ver-cv.php`).
4. El equipo revisa en **Postulaciones recibidas**.
5. Se contacta al candidato y se actualiza el seguimiento fuera del sistema (por ahora el estado en BD queda como referencia inicial).

Campos guardados: nombre, RUT, teléfono, correo, comuna, cargo, experiencia, disponibilidad, CV, mensaje, fecha.

## Canales de contacto del sitio

| Canal | Uso |
|-------|-----|
| WhatsApp | Consultas rápidas de planes y cobertura |
| `postulaciones@telcosurspa.cl` | Postulaciones comerciales por correo |
| Formularios web | Registro ordenado en MySQL |

## Tareas diarias sugeridas

- Revisar si hay consultas nuevas en el panel.
- Revisar postulaciones con CV adjunto.
- Responder WhatsApp pendientes vinculados a formularios.

## Tareas semanales

- Exportar CSV si necesitas reporte para gerencia.
- Verificar que el sitio abre con HTTPS.
- Revisar que no haya errores visibles en formularios.

## Tareas mensuales

- Backup de base de datos desde phpMyAdmin o panel del hosting.
- Backup de carpeta `uploads/cv/` si hay CVs activos.
- Revisar precios y textos de planes publicados.

## Cómo exportar datos

1. Inicia sesión en `admin-login.php`.
2. Entra a postulaciones o consultas.
3. Haz clic en **Exportar CSV**.
4. Abre el archivo en Excel o Google Sheets (separador `;`, UTF-8 con BOM).

## Cómo cambiar contraseña del admin

```bash
php -r "echo password_hash('nueva_contraseña', PASSWORD_DEFAULT);"
```

Copia el hash en `admin-config.php` del servidor.

## Cómo actualizar el sitio sin perder datos

1. Haz backup de la base de datos y de `uploads/cv/`.
2. Sube solo los archivos de código cambiados (PHP, CSS, JS, assets).
3. **No sobrescribas** en producción:
   - `db.php`
   - `admin-config.php`
   - `uploads/cv/*`
4. Prueba formularios y login después de actualizar.

## Datos personales (Chile)

El sitio almacena datos de clientes y postulantes (nombre, teléfono, RUT, correo, etc.).

Buenas prácticas:

- Usa los datos solo para contacto comercial o gestión de postulaciones.
- No compartas CVs ni datos fuera del equipo autorizado.
- Elimina registros de prueba antes de abrir al público.
- Informa en el sitio que los datos se usan para gestionar consultas y postulaciones (ya hay texto de consentimiento en el formulario de postulación).

## Registro interno de incidencias

Usa esta tabla para anotar problemas:

| Fecha | Problema | Qué se hizo | Responsable |
|-------|----------|-------------|-------------|
| | | | |
