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
C:\xampp\htdocs\Telcosur
```

2. Abrir phpMyAdmin:

```text
http://localhost/phpmyadmin
```

3. Crear una base de datos llamada:

```text
telcosurspa
```

4. Importar el archivo:

```text
database.sql
```

5. Abrir el sitio:

```text
http://localhost/Telcosur/
```

## Páginas administrativas

Ver postulaciones:

```text
http://localhost/Telcosur/postulaciones.php
```

Ver consultas de planes:

```text
http://localhost/Telcosur/consultas-planes.php
```

## Importante para hosting

En hosting real se debe editar `db.php` con los datos MySQL del servidor.
No subas contraseñas reales a un repositorio público.
