-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2023 a las 06:32:18
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `colegio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos_padre`
--

CREATE TABLE `alumnos_padre` (
  `id` int NOT NULL,
  `id_alumno` int NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `celular` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` int NOT NULL,
  `id_usuario` int NOT NULL,
  `idnivel_academico` int NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `creditos` decimal(4,2) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_docente`
--

CREATE TABLE `curso_docente` (
  `id` int NOT NULL,
  `id_docente` int NOT NULL,
  `idcurso` int NOT NULL,
  `id_periodo` int NOT NULL,
  `id_nivel` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_examen`
--

CREATE TABLE `detalles_examen` (
  `id` int NOT NULL,
  `id_examen` int NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `opcion_1` varchar(255) NOT NULL,
  `opcion_2` varchar(255) NOT NULL,
  `opcion_3` varchar(255) NOT NULL,
  `opcion_4` varchar(255) NOT NULL,
  `respuesta` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_matricula`
--

CREATE TABLE `detalle_matricula` (
  `int` int NOT NULL,
  `id_curso_docente` int NOT NULL,
  `id_matricula` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id` int NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `celular` varchar(100) DEFAULT NULL,
  `logo` varchar(500) DEFAULT NULL,
  `foto` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen`
--

CREATE TABLE `examen` (
  `id` int NOT NULL,
  `id_curso_docente` int NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `tiempo` int NOT NULL,
  `expiracion` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matricula`
--

CREATE TABLE `matricula` (
  `id` int NOT NULL,
  `id_alumno` int NOT NULL,
  `id_usuario` int NOT NULL,
  `id_periodo_academico` int NOT NULL,
  `id_nivel` int NOT NULL,
  `fecha_matricula` timestamp NOT NULL,
  `monto_matricula` decimal(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel_academico`
--

CREATE TABLE `nivel_academico` (
  `id` int NOT NULL,
  `id_usuario` int NOT NULL,
  `nivel` varchar(60) NOT NULL,
  `numero_de_nivel` int NOT NULL,
  `fecha_de_creacion` timestamp NOT NULL,
  `estado` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo_academico`
--

CREATE TABLE `periodo_academico` (
  `id` int NOT NULL,
  `descripcion` varchar(60) NOT NULL,
  `estado` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id` int NOT NULL,
  `id_usuario` int NOT NULL,
  `id_rol` int NOT NULL,
  `dni` varchar(12) NOT NULL,
  `password` varchar(500) NOT NULL,
  `apellidos` varchar(60) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `seccion` varchar(10) NOT NULL,
  `fecha_de_creacion` timestamp NOT NULL,
  `estado` tinyint NOT NULL DEFAULT '1',
  `clave_principal` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultado_examen`
--

CREATE TABLE `resultado_examen` (
  `id` int NOT NULL,
  `id_examen` int NOT NULL,
  `id_alumno` int NOT NULL,
  `tiempo` varchar(255) NOT NULL,
  `estado` tinyint NOT NULL,
  `nota` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultado_examen_detalle`
--

CREATE TABLE `resultado_examen_detalle` (
  `id` int NOT NULL,
  `id_resultado` int NOT NULL,
  `id_detalle_examen` int NOT NULL,
  `estado` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `descripcion`) VALUES
(1, 'ADMINISTRADOR'),
(2, 'DOCENTE'),
(3, 'ALUMNO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temario`
--

CREATE TABLE `temario` (
  `id` int NOT NULL,
  `id_curso` int NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `id_rol` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `estado` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `id_rol`, `nombre`, `correo`, `usuario`, `password`, `estado`) VALUES
(1, 1, 'PEPITO', 'ddd@gg.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos_padre`
--
ALTER TABLE `alumnos_padre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ALUMNO_PADRE` (`id_alumno`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_IDUSUARIO_REGISTRA_CURSOS_idx` (`id_usuario`),
  ADD KEY `FK_IDNVELACADEMICO_CURSOS_idx` (`idnivel_academico`);

--
-- Indices de la tabla `curso_docente`
--
ALTER TABLE `curso_docente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `DK_IDCURSO_DOCENTE_CURSO_idx` (`idcurso`),
  ADD KEY `FK_IDPERIODO_CURSO_DOCENTE_idx` (`id_periodo`),
  ADD KEY `FK_IDCURSO_DOCENTE_ID_idx` (`id_docente`),
  ADD KEY `FK_IDNIVEL_CURSODOCENTE_ID_idx` (`id_nivel`);

--
-- Indices de la tabla `detalles_examen`
--
ALTER TABLE `detalles_examen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_IDEXAMEN_DETALLES_idx` (`id_examen`);

--
-- Indices de la tabla `detalle_matricula`
--
ALTER TABLE `detalle_matricula`
  ADD PRIMARY KEY (`int`),
  ADD KEY `FK_IDMATRICULA_DETALLE_idx` (`id_matricula`),
  ADD KEY `FK_IDMATRICULA_DETALLE_CURSO_idx` (`id_curso_docente`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `examen`
--
ALTER TABLE `examen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_IDCURSO_EXAMEN_idx` (`id_curso_docente`);

--
-- Indices de la tabla `matricula`
--
ALTER TABLE `matricula`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_IDALUMNO_MATRICULA_idx` (`id_alumno`),
  ADD KEY `FK_IDUSUARIO_MATRICULA_idx` (`id_usuario`),
  ADD KEY `FK_PERIODO_ACADEMICO_MATRICULA_idx` (`id_periodo_academico`),
  ADD KEY `FK_IDNNIVEL_MATRICULA_idx` (`id_nivel`);

--
-- Indices de la tabla `nivel_academico`
--
ALTER TABLE `nivel_academico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_IDUSUARIO_REGISTRA_NIVEL_idx` (`id_usuario`);

--
-- Indices de la tabla `periodo_academico`
--
ALTER TABLE `periodo_academico`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_IDUSUARIOREGISTRA_ID_idx` (`id_usuario`),
  ADD KEY `FK_IDROLALUMNOS_idx` (`id_rol`);

--
-- Indices de la tabla `resultado_examen`
--
ALTER TABLE `resultado_examen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_IDEXAMEN_RESULTADO_idx` (`id_examen`);

--
-- Indices de la tabla `resultado_examen_detalle`
--
ALTER TABLE `resultado_examen_detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_IDRESULTADO_EXAMEN_DETALLE_idx` (`id_resultado`),
  ADD KEY `FK_IDDETALLE_EXMEN_RESULTADO_DETALLE_idx` (`id_detalle_examen`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `temario`
--
ALTER TABLE `temario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_IDCURSOS_TEMARIO_idx` (`id_curso`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_IDROL_USUARIO_idx` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos_padre`
--
ALTER TABLE `alumnos_padre`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `curso_docente`
--
ALTER TABLE `curso_docente`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalles_examen`
--
ALTER TABLE `detalles_examen`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_matricula`
--
ALTER TABLE `detalle_matricula`
  MODIFY `int` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `examen`
--
ALTER TABLE `examen`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `matricula`
--
ALTER TABLE `matricula`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nivel_academico`
--
ALTER TABLE `nivel_academico`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `periodo_academico`
--
ALTER TABLE `periodo_academico`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `resultado_examen`
--
ALTER TABLE `resultado_examen`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `resultado_examen_detalle`
--
ALTER TABLE `resultado_examen_detalle`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `temario`
--
ALTER TABLE `temario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnos_padre`
--
ALTER TABLE `alumnos_padre`
  ADD CONSTRAINT `FK_ALUMNO_PADRE` FOREIGN KEY (`id_alumno`) REFERENCES `persona` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `FK_IDNVELACADEMICO_CURSOS` FOREIGN KEY (`idnivel_academico`) REFERENCES `nivel_academico` (`id`),
  ADD CONSTRAINT `FK_IDUSUARIO_REGISTRA_CURSOS` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `curso_docente`
--
ALTER TABLE `curso_docente`
  ADD CONSTRAINT `DK_IDCURSO_DOCENTE_CURSO` FOREIGN KEY (`idcurso`) REFERENCES `cursos` (`id`),
  ADD CONSTRAINT `FK_IDCURSO_DOCENTE_ID` FOREIGN KEY (`id_docente`) REFERENCES `persona` (`id`),
  ADD CONSTRAINT `FK_IDNIVEL_CURSODOCENTE_ID` FOREIGN KEY (`id_nivel`) REFERENCES `nivel_academico` (`id`),
  ADD CONSTRAINT `FK_IDPERIODO_CURSO_DOCENTE` FOREIGN KEY (`id_periodo`) REFERENCES `periodo_academico` (`id`);

--
-- Filtros para la tabla `detalles_examen`
--
ALTER TABLE `detalles_examen`
  ADD CONSTRAINT `FK_IDEXAMEN_DETALLES` FOREIGN KEY (`id_examen`) REFERENCES `examen` (`id`);

--
-- Filtros para la tabla `detalle_matricula`
--
ALTER TABLE `detalle_matricula`
  ADD CONSTRAINT `FK_IDMATRICULA_DETALLE` FOREIGN KEY (`id_matricula`) REFERENCES `matricula` (`id`),
  ADD CONSTRAINT `FK_IDMATRICULA_DETALLE_CURSO` FOREIGN KEY (`id_curso_docente`) REFERENCES `curso_docente` (`id`);

--
-- Filtros para la tabla `examen`
--
ALTER TABLE `examen`
  ADD CONSTRAINT `FK_IDCURSO_EXAMEN` FOREIGN KEY (`id_curso_docente`) REFERENCES `curso_docente` (`id`);

--
-- Filtros para la tabla `matricula`
--
ALTER TABLE `matricula`
  ADD CONSTRAINT `FK_IDALUMNO_MATRICULA` FOREIGN KEY (`id_alumno`) REFERENCES `persona` (`id`),
  ADD CONSTRAINT `FK_IDNNIVEL_MATRICULA` FOREIGN KEY (`id_nivel`) REFERENCES `nivel_academico` (`id`),
  ADD CONSTRAINT `FK_IDUSUARIO_MATRICULA` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `FK_PERIODO_ACADEMICO_MATRICULA` FOREIGN KEY (`id_periodo_academico`) REFERENCES `periodo_academico` (`id`);

--
-- Filtros para la tabla `nivel_academico`
--
ALTER TABLE `nivel_academico`
  ADD CONSTRAINT `FK_IDUSUARIO_REGISTRA_NIVEL` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `FK_IDROLALUMNOS` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `FK_IDUSUARIOREGISTRA_ID` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `resultado_examen`
--
ALTER TABLE `resultado_examen`
  ADD CONSTRAINT `FK_IDEXAMEN_RESULTADO` FOREIGN KEY (`id_examen`) REFERENCES `examen` (`id`);

--
-- Filtros para la tabla `resultado_examen_detalle`
--
ALTER TABLE `resultado_examen_detalle`
  ADD CONSTRAINT `FK_IDDETALLE_EXMEN_RESULTADO_DETALLE` FOREIGN KEY (`id_detalle_examen`) REFERENCES `detalles_examen` (`id`),
  ADD CONSTRAINT `FK_IDRESULTADO_EXAMEN_DETALLE` FOREIGN KEY (`id_resultado`) REFERENCES `resultado_examen` (`id`);

--
-- Filtros para la tabla `temario`
--
ALTER TABLE `temario`
  ADD CONSTRAINT `FK_IDCURSOS_TEMARIO` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `FK_IDROL_USUARIO` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
