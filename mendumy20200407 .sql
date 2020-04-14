-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-04-2020 a las 18:31:36
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mendumy`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth`
--

DROP TABLE IF EXISTS `auth`;
CREATE TABLE `auth` (
  `id_auth` int(10) UNSIGNED NOT NULL,
  `idusr` int(10) UNSIGNED NOT NULL,
  `last_auth` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `auth`
--

INSERT INTO `auth` (`id_auth`, `idusr`, `last_auth`) VALUES
(2, 2, '2020-04-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Contabilidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `commentscourse`
--

DROP TABLE IF EXISTS `commentscourse`;
CREATE TABLE `commentscourse` (
  `id` int(10) UNSIGNED NOT NULL,
  `idvideo` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `comment` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `commentdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE `course` (
  `id` int(10) UNSIGNED NOT NULL,
  `price` float DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8_spanish_ci DEFAULT NULL,
  `category` int(10) UNSIGNED DEFAULT NULL,
  `creationdate` datetime NOT NULL,
  `modificationdate` datetime DEFAULT NULL,
  `imgname` varchar(100) COLLATE utf8_spanish_ci DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `course`
--

INSERT INTO `course` (`id`, `price`, `name`, `description`, `category`, `creationdate`, `modificationdate`, `imgname`) VALUES
(1, 50, 'Curso 1', 'Lorem Imptun Inspute Ashen', 1, '0000-00-00 00:00:00', NULL, 'default.jpg'),
(2, 100, 'Curso 2', 'Lorem Imptun Inspute Ashen', 1, '0000-00-00 00:00:00', NULL, 'default.jpg'),
(3, 135, 'Curso 3', 'Lorem Imptun Inspute Ashen', 1, '0000-00-00 00:00:00', NULL, 'default.jpg'),
(4, 300, 'Curso 4', 'Lorem Imptun Inspute Ashen', 1, '0000-00-00 00:00:00', NULL, 'default.jpg'),
(5, 100, 'Curso 5', 'Lorem Imptun Inspute Ashen', 1, '0000-00-00 00:00:00', NULL, 'default.jpg'),
(6, 50, 'Curso 6', 'Lorem Imptun Inspute Ashen', 1, '0000-00-00 00:00:00', NULL, 'default.jpg'),
(7, 100, 'Curso 7', 'Lorem Imptun Inspute Ashen', 1, '0000-00-00 00:00:00', NULL, 'default.jpg'),
(33, 100000, 'Contabilidad', 'Curso destinado a contadores', 1, '2020-04-03 06:01:45', NULL, '48abd8296adb3ee59f235ea91f287f15.jpeg'),
(34, 10000, 'Contabilidad1', 'Curso inicial de contabilidad', 1, '2020-04-03 13:31:30', NULL, '3b70dca90db8ccf9f53e7380b0a4b3ff.jpeg'),
(37, 0, 'Matematica Financiera', 'Curso de mate', 1, '2020-04-03 13:51:03', NULL, '98d176d7692b4a2f66f77f3ae709fbc8.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `courseuser`
--

DROP TABLE IF EXISTS `courseuser`;
CREATE TABLE `courseuser` (
  `id` int(10) UNSIGNED NOT NULL,
  `idcourse` int(11) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `courseuser`
--

INSERT INTO `courseuser` (`id`, `idcourse`, `iduser`) VALUES
(1, 1, 2),
(2, 2, 2),
(18, 37, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesion`
--

DROP TABLE IF EXISTS `profesion`;
CREATE TABLE `profesion` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf32 COLLATE utf32_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `profesion`
--

INSERT INTO `profesion` (`id`, `nombre`) VALUES
(1, 'Estudiante de Derecho'),
(2, 'Abogado'),
(3, 'Escribano'),
(4, 'Escribano Novel'),
(5, 'Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recover`
--

DROP TABLE IF EXISTS `recover`;
CREATE TABLE `recover` (
  `id_recover` int(10) UNSIGNED NOT NULL,
  `idusr` int(10) UNSIGNED NOT NULL,
  `password_request` tinyint(10) NOT NULL DEFAULT 0,
  `token_password` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `last_modification` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `recover`
--

INSERT INTO `recover` (`id_recover`, `idusr`, `password_request`, `token_password`, `last_modification`) VALUES
(9, 2, 0, 'a5ef1e82f18c058117bd50f374e7cbf9', '2020-03-14 16:24:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `themes`
--

DROP TABLE IF EXISTS `themes`;
CREATE TABLE `themes` (
  `id` int(10) UNSIGNED NOT NULL,
  `idcourse` int(10) UNSIGNED NOT NULL,
  `name` int(11) NOT NULL,
  `description` varchar(500) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `rol` int(11) DEFAULT 1,
  `name` tinytext COLLATE utf8_spanish_ci DEFAULT NULL,
  `lastname` tinytext COLLATE utf8_spanish_ci DEFAULT NULL,
  `idprofesion` int(10) UNSIGNED NOT NULL,
  `dni` varchar(11) COLLATE utf8_spanish_ci DEFAULT NULL,
  `active` tinyint(4) DEFAULT 0,
  `password` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `creation_date` datetime NOT NULL,
  `date_birth` date DEFAULT NULL,
  `token` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `rol`, `name`, `lastname`, `idprofesion`, `dni`, `active`, `password`, `username`, `creation_date`, `date_birth`, `token`) VALUES
(2, 0, 'Bruno', 'Di Giorgio', 1, '33443123', 1, '8bb0cf6eb9b17d0f7d22b456f121257dc1254e1f01665370476383ea776df414', 'brunobocalomejor@gmail.com', '2020-03-14 13:16:31', '2020-03-04', '517c3ffaa85c03ecd9dc67fc4603fc70');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videoscourse`
--

DROP TABLE IF EXISTS `videoscourse`;
CREATE TABLE `videoscourse` (
  `id` int(10) UNSIGNED NOT NULL,
  `idcourse` int(10) UNSIGNED DEFAULT NULL,
  `videofile` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `uploaddate` datetime DEFAULT NULL,
  `idtheme` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auth`
--
ALTER TABLE `auth`
  ADD PRIMARY KEY (`id_auth`) USING BTREE,
  ADD KEY `idusr` (`idusr`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `commentscourse`
--
ALTER TABLE `commentscourse`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`);

--
-- Indices de la tabla `courseuser`
--
ALTER TABLE `courseuser`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `profesion`
--
ALTER TABLE `profesion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recover`
--
ALTER TABLE `recover`
  ADD PRIMARY KEY (`id_recover`),
  ADD KEY `idusr` (`idusr`);

--
-- Indices de la tabla `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcourse` (`idcourse`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idprofesion` (`idprofesion`) USING BTREE;

--
-- Indices de la tabla `videoscourse`
--
ALTER TABLE `videoscourse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcourse` (`idcourse`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auth`
--
ALTER TABLE `auth`
  MODIFY `id_auth` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `commentscourse`
--
ALTER TABLE `commentscourse`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `course`
--
ALTER TABLE `course`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `courseuser`
--
ALTER TABLE `courseuser`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `profesion`
--
ALTER TABLE `profesion`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `recover`
--
ALTER TABLE `recover`
  MODIFY `id_recover` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `themes`
--
ALTER TABLE `themes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `videoscourse`
--
ALTER TABLE `videoscourse`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `auth`
--
ALTER TABLE `auth`
  ADD CONSTRAINT `auth_ibfk_1` FOREIGN KEY (`idusr`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`id`);

--
-- Filtros para la tabla `recover`
--
ALTER TABLE `recover`
  ADD CONSTRAINT `recover_ibfk_1` FOREIGN KEY (`idusr`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `themes`
--
ALTER TABLE `themes`
  ADD CONSTRAINT `themes_ibfk_1` FOREIGN KEY (`idcourse`) REFERENCES `course` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`idprofesion`) REFERENCES `profesion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `videoscourse`
--
ALTER TABLE `videoscourse`
  ADD CONSTRAINT `videoscourse_ibfk_1` FOREIGN KEY (`idcourse`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
