CREATE DATABASE IF NOT EXISTS telcosurspa
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE telcosurspa;

CREATE TABLE IF NOT EXISTS postulaciones (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  rut VARCHAR(20) NOT NULL,
  telefono VARCHAR(30) NOT NULL,
  correo VARCHAR(120) NOT NULL,
  comuna VARCHAR(100) NOT NULL,
  experiencia VARCHAR(80) NOT NULL,
  disponibilidad VARCHAR(80) NOT NULL,
  cargo VARCHAR(120) DEFAULT 'Ejecutivo comercial',
  cv_archivo VARCHAR(255),
  estado VARCHAR(40) DEFAULT 'Recibida',
  mensaje TEXT,
  fecha_postulacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS consultas_planes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  telefono VARCHAR(30) NOT NULL,
  comuna VARCHAR(100) NOT NULL,
  plan_interes VARCHAR(160) NOT NULL,
  mensaje TEXT,
  fecha_consulta TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
