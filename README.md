# ICTI - Sistema de Registro y Control de Asistencia

Este repositorio corresponde a una aplicación web desarrollada para el **Instituto de Ciencia, Tecnología e Innovación (ICTI)**. Su objetivo es facilitar el **registro, control y análisis de la asistencia** en eventos organizados por el instituto de manera ágil y segura.

## Funcionalidades principales

- **Registro de Asistencia**
  - Escaneo de códigos QR para registrar la llegada de asistentes.
  - Registro manual de asistencia introduciendo el folio de participante.
- **Gestión de Asistentes**
  - Consulta y administración de la lista completa de asistentes.
- **Administración de Eventos**
  - Creación de nuevos eventos y activación del evento actual.
  - Carga masiva de asistentes desde archivos CSV.
- **Estadísticas y Reportes**
  - Generación de estadísticas por género, escolaridad y asistencia diaria.
  - Descarga de reportes en formato CSV y PDF.
  - Visualización de KPIs como total de asistentes, asistencia efectiva y porcentaje de personas de comunidades indígenas.

## Tecnologías utilizadas

- **Backend:** PHP
- **Frontend:** JavaScript
- **Estadísticas y visualizaciones:** Chart.js
- **Estilos:** Tailwind CSS
- **Base de datos:** MySQL

## Estructura del proyecto

- `public/` - Archivos públicos y punto de entrada de la aplicación (index.php, registrar_folio.php, escanear_qr.php, etc).
- `app/controllers/` - Lógica de negocio y controladores para operaciones como registro de asistencia y carga de CSV.
- `resources/js/` - Scripts de frontend para manejo de estadísticas, escaneo de QR, y otros.
- `resources/views/` - Vistas PHP del sistema.
- `config/` - Configuración de conexión a bases de datos, etc.

## Estructura de la base de datos

El sistema utiliza dos tablas principales:

### Tabla: `asistentes_congreso`

| Campo                    | Tipo                                    | Descripción                                 |
|--------------------------|-----------------------------------------|---------------------------------------------|
| id                       | int (PK, AUTO_INCREMENT)                | Identificador único                         |
| folio                    | varchar(50), único                      | Folio asignado a cada asistente             |
| nombre                   | varchar(100)                            | Nombre(s) del asistente                     |
| apellido_paterno         | varchar(100)                            | Apellido paterno                            |
| apellido_materno         | varchar(100)                            | Apellido materno                            |
| nacionalidad             | varchar(100)                            | Nacionalidad del asistente                  |
| estado                   | varchar(100)                            | Estado de residencia                        |
| municipio                | varchar(100)                            | Municipio de residencia                     |
| edad                     | int                                     | Edad                                        |
| genero                   | enum('Hombre','Mujer','No binario',...) | Género                                      |
| estado_civil             | enum                                    | Estado civil                                |
| escolaridad              | enum                                    | Nivel de escolaridad                        |
| institucion              | varchar(150)                            | Institución de procedencia                   |
| facultad                 | varchar(150)                            | Facultad                                    |
| email                    | varchar(150)                            | Correo electrónico                          |
| comunidad_indigena       | tinyint(1)                              | 1=Sí pertenece a comunidad indígena         |
| comunidad_indigena_nombre| varchar(150)                            | Nombre de la comunidad indígena (opcional)  |
| asistencia               | tinyint(1)                              | 1=Asistió, 0=No asistió                     |
| fecha_asistencia         | datetime                                | Fecha y hora de registro de asistencia      |
| evento_id                | int (FK)                                | Relación al evento correspondiente          |

### Tabla: `eventos`

| Campo        | Tipo            | Descripción                      |
|--------------|-----------------|----------------------------------|
| id           | int (PK, AUTO_INCREMENT) | Identificador del evento         |
| nombre       | varchar(150)    | Nombre del evento                |
| fecha        | date            | Fecha del evento                 |
| lugar        | varchar(150)    | Lugar                            |
| descripcion  | text            | Descripción (opcional)           |
| creado_en    | timestamp       | Fecha de registro                |
| activo       | tinyint(1)      | 1=Evento activo, 0=Inactivo      |

#### Relaciones
- La tabla `asistentes_congreso.evento_id` es clave foránea hacia `eventos.id`.

---

### SQL para crear la base de datos

Puedes importar directamente el archivo [`icti.sql`](./icti.sql) en tu gestor MySQL favorito (como phpMyAdmin, DBeaver, consola, etc).  
Si prefieres, aquí tienes el SQL completo:

<details>
<summary>Ver SQL</summary>

```sql
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-08-2025 a las 18:34:28
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `icti`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistentes_congreso`
--

CREATE TABLE `asistentes_congreso` (
  `id` int(11) NOT NULL,
  `folio` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido_paterno` varchar(100) NOT NULL,
  `apellido_materno` varchar(100) NOT NULL,
  `nacionalidad` varchar(100) NOT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `municipio` varchar(100) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `genero` enum('Hombre','Mujer','No binario','Prefiero no decir') DEFAULT NULL,
  `estado_civil` enum('Casado (a)','Soltero (a)','Divorciado (a)','Unión Libre') DEFAULT NULL,
  `escolaridad` enum('Media Superior','Licenciatura','Maestría','Doctorado','Otra') DEFAULT NULL,
  `institucion` varchar(150) DEFAULT NULL,
  `facultad` varchar(150) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `comunidad_indigena` tinyint(1) DEFAULT 0,
  `comunidad_indigena_nombre` varchar(150) DEFAULT NULL,
  `asistencia` tinyint(1) DEFAULT 0,
  `fecha_asistencia` datetime DEFAULT NULL,
  `evento_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `fecha` date NOT NULL,
  `lugar` varchar(150) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `activo` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

ALTER TABLE `asistentes_congreso`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `folio` (`folio`),
  ADD KEY `fk_evento` (`evento_id`);

ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

ALTER TABLE `asistentes_congreso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

ALTER TABLE `asistentes_congreso`
  ADD CONSTRAINT `fk_evento` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
```
</details>

---

## Créditos

Hecho con ♥ por Cesar · 2025
