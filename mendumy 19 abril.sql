-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-04-2020 a las 04:04:04
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

CREATE TABLE `auth` (
  `id_auth` int(10) UNSIGNED NOT NULL,
  `idusr` int(10) UNSIGNED NOT NULL,
  `last_auth` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `auth`
--

INSERT INTO `auth` (`id_auth`, `idusr`, `last_auth`) VALUES
(7, 7, '2020-04-19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Contabilidad'),
(21, 'tu mama en bolas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `commentscourse`
--

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

CREATE TABLE `course` (
  `id` int(10) UNSIGNED NOT NULL,
  `price` float DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8_spanish_ci DEFAULT NULL,
  `category` int(10) UNSIGNED DEFAULT NULL,
  `creationdate` datetime NOT NULL,
  `modificationdate` datetime DEFAULT NULL,
  `imgname` varchar(100) COLLATE utf8_spanish_ci DEFAULT 'default.jpg',
  `videoname` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `course`
--

INSERT INTO `course` (`id`, `price`, `name`, `description`, `category`, `creationdate`, `modificationdate`, `imgname`, `videoname`) VALUES
(1, 50, 'Curso 1', 'Lorem Imptun Inspute Ashen', 1, '0000-00-00 00:00:00', NULL, 'be2107e9f0b4356b5d16eb3af19dd82b.jpeg', '1.mp4'),
(3, 135, 'Curso 3', 'Lorem Imptun Inspute Ashen', 1, '0000-00-00 00:00:00', NULL, 'default.jpg', ''),
(4, 300, 'Curso 4', 'Lorem Imptun Inspute Ashen', 1, '0000-00-00 00:00:00', NULL, 'default.jpg', ''),
(5, 100, 'Curso 5', 'Lorem Imptun Inspute Ashen', 1, '0000-00-00 00:00:00', NULL, 'default.jpg', ''),
(6, 50, 'Curso 6', 'Lorem Imptun Inspute Ashen', 1, '0000-00-00 00:00:00', NULL, 'default.jpg', ''),
(7, 100, 'Curso 7', 'Lorem Imptun Inspute Ashen', 1, '0000-00-00 00:00:00', NULL, 'default.jpg', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `courseuser`
--

CREATE TABLE `courseuser` (
  `id` int(10) UNSIGNED NOT NULL,
  `idcourse` int(10) UNSIGNED DEFAULT NULL,
  `iduser` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `courseuser`
--

INSERT INTO `courseuser` (`id`, `idcourse`, `iduser`) VALUES
(20, 1, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `files`
--

CREATE TABLE `files` (
  `id` int(10) UNSIGNED NOT NULL,
  `idvideo` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `uploaddate` datetime NOT NULL,
  `idcourse` int(10) UNSIGNED NOT NULL,
  `filename` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `files`
--

INSERT INTO `files` (`id`, `idvideo`, `name`, `uploaddate`, `idcourse`, `filename`) VALUES
(10, 17, '1.mp4', '2020-04-14 13:28:54', 1, '4800bc47c313728f6fc33cf6df964c3c.mp4'),
(11, 19, 'map-image.png', '2020-04-18 20:21:35', 1, 'cc1d72711d0db875e9e0018b70337644.png'),
(12, 19, 'logo.jfif', '2020-04-18 20:21:35', 1, '6a9d44f36222289937931b29b396eb8e.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesion`
--

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

CREATE TABLE `recover` (
  `id_recover` int(10) UNSIGNED NOT NULL,
  `idusr` int(10) UNSIGNED NOT NULL,
  `password_request` tinyint(10) NOT NULL DEFAULT 0,
  `token_password` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `last_modification` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `themes`
--

CREATE TABLE `themes` (
  `id` int(10) UNSIGNED NOT NULL,
  `idcourse` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `description` varchar(500) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `themes`
--

INSERT INTO `themes` (`id`, `idcourse`, `name`, `description`) VALUES
(36, 1, 'tema 1 ', NULL),
(46, 1, 'tema 2', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

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
(7, 0, 'Di Giorgio', 'Bruno', 1, '36554082', 1, '8bb0cf6eb9b17d0f7d22b456f121257dc1254e1f01665370476383ea776df414', 'digiorgiobruno92@gmail.com', '2020-04-16 13:49:42', '1992-04-02', '11483423273d257357bd6398069f411a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videoscourse`
--

CREATE TABLE `videoscourse` (
  `id` int(10) UNSIGNED NOT NULL,
  `idcourse` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `title` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `uploaddate` datetime DEFAULT NULL,
  `idtheme` int(10) UNSIGNED NOT NULL,
  `imgvideo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `description` varchar(500) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `videoscourse`
--

INSERT INTO `videoscourse` (`id`, `idcourse`, `name`, `title`, `uploaddate`, `idtheme`, `imgvideo`, `description`) VALUES
(17, 1, '8e04f8ab8491c57db3664170045ecb71.mp4', 'punto de equilibrio', '2020-04-14 13:28:54', 36, 'be2107e9f0b4356b5d16eb3af19dd82b.jpeg', 'fdfdf'),
(18, 1, 'd20441a373ae1d094cd3e47d31cbd476.mp4', 'Programación lineal', '2020-04-17 21:24:07', 36, 'de31eef1c9efce918e1b4d9f5b9b35de.jpeg', 'La ciencia de la programacion lineal es una de las grandes ramas de la investigacion operativa responsable de la toma de decisiones dentro de una empresa.'),
(19, 1, 'd805d43f47d08ee545c6504c1408637d.mp4', 'Video1', '2020-04-18 20:21:35', 46, '8cfce0c14a828653032b2c7597ad1ee1.jpeg', 'Este es el video introductorio del tema 2');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `iduser` (`iduser`),
  ADD KEY `idcourse` (`idcourse`);

--
-- Indices de la tabla `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcourse` (`idcourse`),
  ADD KEY `files_ibfk_2` (`idvideo`);

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
  MODIFY `id_auth` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `commentscourse`
--
ALTER TABLE `commentscourse`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `course`
--
ALTER TABLE `course`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `courseuser`
--
ALTER TABLE `courseuser`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `files`
--
ALTER TABLE `files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `videoscourse`
--
ALTER TABLE `videoscourse`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
-- Filtros para la tabla `courseuser`
--
ALTER TABLE `courseuser`
  ADD CONSTRAINT `courseuser_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `courseuser_ibfk_2` FOREIGN KEY (`idcourse`) REFERENCES `course` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`idcourse`) REFERENCES `course` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `files_ibfk_2` FOREIGN KEY (`idvideo`) REFERENCES `videoscourse` (`id`) ON DELETE CASCADE;

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
