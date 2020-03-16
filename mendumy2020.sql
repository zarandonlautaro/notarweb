-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-03-2020 a las 17:10:53
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.3

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `auth`
--

INSERT INTO `auth` (`id_auth`, `idusr`, `last_auth`) VALUES
(1, 1, '2019-11-26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Contaduría');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `commentscourse`
--

CREATE TABLE `commentscourse` (
  `id` int(10) UNSIGNED NOT NULL,
  `idvideo` varchar(50) DEFAULT NULL,
  `comment` varchar(100) DEFAULT NULL,
  `commentdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `course`
--

CREATE TABLE `course` (
  `id` int(10) UNSIGNED NOT NULL,
  `price` float DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `creationdate` datetime NOT NULL,
  `modificationdate` datetime DEFAULT NULL,
  `imgname` varchar(100) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(7, 100, 'Curso 7', 'Lorem Imptun Inspute Ashen', 1, '0000-00-00 00:00:00', NULL, 'default.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `courseuser`
--

CREATE TABLE `courseuser` (
  `id` int(10) UNSIGNED NOT NULL,
  `idcourse` int(11) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `courseuser`
--

INSERT INTO `courseuser` (`id`, `idcourse`, `iduser`) VALUES
(1, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recover`
--

CREATE TABLE `recover` (
  `id_recover` int(10) UNSIGNED NOT NULL,
  `idusr` int(10) UNSIGNED NOT NULL,
  `password_request` tinyint(10) NOT NULL DEFAULT 0,
  `token_password` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `last_modification` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `rol` int(11) DEFAULT 1,
  `name` tinytext CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `lastname` tinytext CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `legajo` varchar(11) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `dni` varchar(11) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `active` tinyint(4) DEFAULT 0,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `creation_date` datetime NOT NULL,
  `date_birth` date DEFAULT NULL,
  `token` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `rol`, `name`, `lastname`, `legajo`, `dni`, `active`, `password`, `username`, `creation_date`, `date_birth`, `token`) VALUES
(1, 1, 'Nicol?s', 'Lefeld', '112269', NULL, 0, '', '', '0000-00-00 00:00:00', NULL, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videoscourse`
--

CREATE TABLE `videoscourse` (
  `id` int(10) UNSIGNED NOT NULL,
  `idcourse` varchar(50) DEFAULT NULL,
  `videofile` varchar(100) DEFAULT NULL,
  `uploaddate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `courseuser`
--
ALTER TABLE `courseuser`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recover`
--
ALTER TABLE `recover`
  ADD PRIMARY KEY (`id_recover`),
  ADD KEY `idusr` (`idusr`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `videoscourse`
--
ALTER TABLE `videoscourse`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auth`
--
ALTER TABLE `auth`
  MODIFY `id_auth` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `commentscourse`
--
ALTER TABLE `commentscourse`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `course`
--
ALTER TABLE `course`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `courseuser`
--
ALTER TABLE `courseuser`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `recover`
--
ALTER TABLE `recover`
  MODIFY `id_recover` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- Filtros para la tabla `recover`
--
ALTER TABLE `recover`
  ADD CONSTRAINT `recover_ibfk_1` FOREIGN KEY (`idusr`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
