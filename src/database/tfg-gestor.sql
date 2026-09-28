-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 14-06-2025 a las 19:46:53
-- Versión del servidor: 10.11.13-MariaDB-0ubuntu0.24.04.1
-- Versión de PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tfg-gestor`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivosproyectos`
--

CREATE TABLE `archivosproyectos` (
  `id_archivosproyectos` int(11) NOT NULL,
  `id_proyecto_archivosproyectos` int(11) DEFAULT NULL,
  `nombre_archivosproyectos` varchar(255) NOT NULL,
  `tipo_archivosproyectos` varchar(50) NOT NULL,
  `creacion_archivosproyectos` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivostareas`
--

CREATE TABLE `archivostareas` (
  `id_archivoTarea` int(11) NOT NULL,
  `id_tarea_archivoTarea` int(11) DEFAULT NULL,
  `nombre_archivoTarea` varchar(255) NOT NULL,
  `tipo_archivoTarea` varchar(50) NOT NULL,
  `creacion_archivoTarea` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `id_proyecto` int(11) NOT NULL,
  `nombre_proyecto` varchar(255) NOT NULL,
  `descripcion_proyecto` text DEFAULT NULL,
  `prioridad_proyecto` enum('baja','media','alta','') NOT NULL DEFAULT 'media',
  `estado_proyecto` enum('activo','pendiente','completado','') NOT NULL DEFAULT 'activo',
  `codigo_proyecto` varchar(10) NOT NULL,
  `creacion_proyecto` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id_tarea` int(11) NOT NULL,
  `id_usuario_tareas` int(11) NOT NULL,
  `titulo_tarea` varchar(150) NOT NULL,
  `descripcion_tarea` text DEFAULT NULL,
  `prioridad_tarea` enum('baja','media','alta') NOT NULL DEFAULT 'media',
  `estado_tarea` enum('suspendida','progresando','finalizada') NOT NULL DEFAULT 'suspendida',
  `creacion_tarea` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(20) NOT NULL,
  `email_usuario` varchar(40) NOT NULL,
  `password_usuario` varchar(255) NOT NULL,
  `avatar_usuario` varchar(255) DEFAULT NULL,
  `rol_usuario` enum('admin','user') NOT NULL DEFAULT 'user',
  `creacion_usuario` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariosproyectos`
--

CREATE TABLE `usuariosproyectos` (
  `id_usuariosproyecto` int(11) NOT NULL,
  `id_usuario_usuariosproyectos` int(11) DEFAULT NULL,
  `id_proyecto_usuariosproyectos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;



--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivosproyectos`
--
ALTER TABLE `archivosproyectos`
  ADD PRIMARY KEY (`id_archivosproyectos`),
  ADD KEY `proyecto_archivoproyecto` (`id_proyecto_archivosproyectos`);

--
-- Indices de la tabla `archivostareas`
--
ALTER TABLE `archivostareas`
  ADD PRIMARY KEY (`id_archivoTarea`),
  ADD KEY `archivoTarea_tareas` (`id_tarea_archivoTarea`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id_proyecto`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id_tarea`),
  ADD KEY `tareas_usuarios` (`id_usuario_tareas`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `usuariosproyectos`
--
ALTER TABLE `usuariosproyectos`
  ADD PRIMARY KEY (`id_usuariosproyecto`),
  ADD KEY `id_usuario_usuariosproyectos` (`id_usuario_usuariosproyectos`),
  ADD KEY `id_proyecto_usuariosproyectos` (`id_proyecto_usuariosproyectos`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivosproyectos`
--
ALTER TABLE `archivosproyectos`
  MODIFY `id_archivosproyectos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `archivostareas`
--
ALTER TABLE `archivostareas`
  MODIFY `id_archivoTarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id_proyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id_tarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `usuariosproyectos`
--
ALTER TABLE `usuariosproyectos`
  MODIFY `id_usuariosproyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `archivosproyectos`
--
ALTER TABLE `archivosproyectos`
  ADD CONSTRAINT `proyecto_archivoproyecto` FOREIGN KEY (`id_proyecto_archivosproyectos`) REFERENCES `proyectos` (`id_proyecto`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `archivostareas`
--
ALTER TABLE `archivostareas`
  ADD CONSTRAINT `archivoTarea_tareas` FOREIGN KEY (`id_tarea_archivoTarea`) REFERENCES `tareas` (`id_tarea`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_usuarios` FOREIGN KEY (`id_usuario_tareas`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuariosproyectos`
--
ALTER TABLE `usuariosproyectos`
  ADD CONSTRAINT `id_proyecto_usuariosproyectos` FOREIGN KEY (`id_proyecto_usuariosproyectos`) REFERENCES `proyectos` (`id_proyecto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_usuario_usuariosproyectos` FOREIGN KEY (`id_usuario_usuariosproyectos`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
