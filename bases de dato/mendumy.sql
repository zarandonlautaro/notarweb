-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-07-2020 a las 02:25:39
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
(7, 7, '2020-07-07'),
(11, 11, '2020-07-17');

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
(30, 'Notarweb'),
(31, 'Edufisic');

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
  `subcategory` int(10) UNSIGNED NOT NULL,
  `credentialid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `course`
--

INSERT INTO `course` (`id`, `price`, `name`, `description`, `category`, `creationdate`, `modificationdate`, `imgname`, `subcategory`, `credentialid`) VALUES
(88, 1, 'Curso p notar', '', 30, '2020-06-23 19:42:21', '2020-07-16 15:10:32', '1f5c9683bc09b283abdacdff1aa98985.png', 18, 2),
(94, 1, 'pago', 'asd', 30, '2020-06-22 20:30:58', '2020-07-15 22:28:23', 'a9ab9026bf77daf398a288e71077bd39.png', 18, 2),
(95, 0, 'curso 1 fis', '', 30, '2020-06-21 12:42:06', '2020-06-23 12:02:33', 'a36b45ad279776f439462cb3c08859c6.jpeg', 18, 1),
(117, 1, 'Daniel', 'ssss', 30, '2020-07-17 19:11:00', '2020-07-17 19:40:20', 'bbc7353331747cc6253bfd33638e0497.jpeg', 18, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `courseuser`
--

CREATE TABLE `courseuser` (
  `id` int(10) UNSIGNED NOT NULL,
  `idcourse` int(10) UNSIGNED DEFAULT NULL,
  `iduser` int(10) UNSIGNED DEFAULT NULL,
  `saledate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `courseuser`
--

INSERT INTO `courseuser` (`id`, `idcourse`, `iduser`, `saledate`) VALUES
(1346, 95, 11, '2020-07-16 03:16:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `credentials`
--

CREATE TABLE `credentials` (
  `id` int(11) NOT NULL,
  `credential` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `name` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `modificationdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `credentials`
--

INSERT INTO `credentials` (`id`, `credential`, `name`, `modificationdate`) VALUES
(1, 'APP_USR-2242931866985656-051120-c6aa618ca1695edb68ff8b1d5b4a2276-566667855', 'Sandbox', '2020-07-17 19:40:39'),
(2, 'APP_USR-8032873146845911-021319-999c3a72233fc67a25d325d517c6bf88-164497255', 'producción', '2020-07-17 19:56:46');

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
(108, 191, '1era.png', '2020-06-20 20:05:01', 88, '42122db061d3471ee5f415ab3bc6f20a.png');

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

--
-- Volcado de datos para la tabla `recover`
--

INSERT INTO `recover` (`id_recover`, `idusr`, `password_request`, `token_password`, `last_modification`) VALUES
(10, 11, 1, '63ab5bc975ae8305858f5a129d5ee1b3', '2020-06-03 19:01:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `idcategory` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `subcategories`
--

INSERT INTO `subcategories` (`id`, `name`, `idcategory`) VALUES
(12, 'Fisica', 31),
(18, 'cat1', 30);

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
(65, 88, 'u1', NULL),
(66, 94, 'a', NULL),
(67, 95, 'sdfdf', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `rol` int(11) DEFAULT 1,
  `name` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `lastname` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
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
(7, 1, 'Di Giorgio', 'Bruno', 1, '36554082', 1, '8bb0cf6eb9b17d0f7d22b456f121257dc1254e1f01665370476383ea776df414', 'digiorgiobruno92@gmail.com', '2020-04-16 13:49:42', '1992-04-02', '11483423273d257357bd6398069f411a'),
(11, 0, 'Bruno', 'Di Giorgio', 1, '36554081', 1, '8bb0cf6eb9b17d0f7d22b456f121257dc1254e1f01665370476383ea776df414', 'brunobocalomejor@gmail.com', '2020-05-08 13:00:35', '2020-05-08', 'b706faa92f5c59cb77f7e156fcc26bef'),
(486, 1, 'Eduardo J', 'Casado', 2, '26779111', 1, 'e2bffe1f64d49e57698b92fbcf8e5fd2dd2fded8b2da17ae0e6bb2413af1bf9c', 'eduksado@hotmail.com', '2020-05-09 19:47:39', '1978-12-09', '436ffde5f3517efe8088306da983c6b5'),
(487, 1, 'Lourdes', 'Caggiano', 3, '28341679', 1, 'a81df2657ed9dd6efd8ecf696d5addd59dec556c18cef68d573d43e6094491c2', 'lourdes@escri.com.ar', '2020-05-11 09:44:07', '1980-03-10', '4f6511686bd00c5ea3efc6a35ef6106f'),
(488, 1, 'Mario Sebastián', 'Felici', 3, '26016570', 1, '6e8e38af1b3203092e40e72365ef26f16599bcb000936b1e9f70d501e4cfe4bf', 'escribanosebastianfelici@yahoo.com.ar', '2020-05-11 09:57:02', '1977-03-08', '4c3777c95bb8c0d292b17a3e25a39f56'),
(490, 1, 'Ana Carolina', 'Patti', 4, '39496095', 1, '52a0738add0b0374c2f6d7baf71762e7080bb7e09c2c7d75d22e6da60e3ff0c3', 'caro.patti@hotmail.com', '2020-05-11 12:47:47', '1996-04-03', '4cb664d98889b7e740296e3126161637'),
(491, 1, 'Pablo', 'Hidalgo', 2, '23408309', 1, '8fcd6dbeb0a027c6589bb9cec9505e053834045dd15d6f29da2a4096f6071d10', 'phidalgoarrabal@gmail.com', '2020-05-11 15:48:01', '1973-11-07', '9d24ef96e10d3568576a37e0f263ac70'),
(492, 1, 'SANDRA', 'ARGUELLO', 3, '21586723', 1, 'e8f98348b09ad5f265ec392fd780995eb6123d5ec05b038dbe9e183dad55425d', 'escribanarguello@gmail.com', '2020-05-11 18:15:05', '1970-03-12', 'baa8eb670741ac6a75d04aeec6984012'),
(493, 1, 'Florentina', 'Cucchiarelli', 4, '31284979', 1, '75b788e9ff0c9cbdb728ed084c92acfdee370db0a5a9baebd5eed90dc0c7c91d', 'florcucchiarelli@hotmail.com', '2020-05-11 19:56:18', '1984-05-12', '28ed7663de95f6da0e928dd93344bd9f'),
(494, 1, 'Carolina Alejandra', 'Kermen', 4, '30584665', 1, '9c1b31c16a7d3f1ecb655ebc4d35be1e9935abdb58991dc5e7786f1bc477ef9e', 'carolinakermen@hotmail.com', '2020-05-12 19:34:26', '1984-01-28', 'd9e34502e499de0bfbe77a5bb0c01a9c'),
(495, 1, 'Roxana', 'Alamo', 2, '23386489', 1, 'e757ddf7e75853b62851862ea2b122c640f7695ac95508a3617127eb1ce6d9bd', 'roxialamo@gmail.com', '2020-05-12 22:46:00', '1974-08-02', 'e5ef719a4636268ab5cb7fdca783cd29'),
(496, 1, 'Romanela Evelin', 'Vitaliti', 3, '32212229', 0, '578073574876ad338d4605b10b503eafc4ba203e872afef5144898725c75ce60', 'escribanavitaliti@hotmail.com', '2020-05-14 11:33:56', '1986-06-07', '3d7ed57de9c811abab188c8c2486b97f'),
(497, 1, 'Maria Paula', 'Durigutti', 3, '33890678', 1, '709ffb05166fec070900d7b2c9771ac9525c84003d2b3a36fe4aec3aa10e1111', 'pauladurigutti@hotmail.com', '2020-05-15 22:42:44', '1989-03-13', '8717eafe287e0a816e95de329a359da8'),
(498, 1, 'Felipe', 'Molina', 5, '23629808', 1, '267e44de41581481e432e49a1092d41a421bad2313278f723253c5309b706542', 'l.molina@mba-montpellier.com', '2020-05-28 19:39:02', '1984-01-01', '4f1ae53bf73f2ed89e6ea62fb4794a6c'),
(499, 1, 'Maria Mercedes', 'Fernández Lombardo', 4, '32315745', 0, '917ebb3396b2ff2e27b75e3fe421b1edc07b998f74350472f3abc5c6620a68db', 'mmercedesfl@gmail.com', '2020-05-29 01:10:00', '1986-06-04', '0892fa3b86705dd38974c8b8472c0c55'),
(500, 1, 'Claudia', 'palomo', 3, '2387659', 0, '5c168ed40309162e20a5c6dc73773f5ad66814f2798de2fd14bcb4df60272033', 'mcpalomo@live.com.ar', '2020-06-06 19:52:49', '1974-04-02', '95f9a5953c04847da1e986a08317c970'),
(501, 1, 'Carla', 'Ripoll', 1, '40766020', 0, '04397fffc69557cc8d36904b0a9912585395193a506174ef45c2b75ca399c458', 'carlaripoll22@gmail.com', '2020-06-22 17:55:15', '1997-10-22', '9d7d13c18be8c084807b6b1abff32459'),
(4294967295, 1, 'Clementina', 'Perez', 2, '36816857', 1, '4fc3ab682b4b2b4dc6c68aea5a0c4786b5ae9e44e792438968d88f36877f29aa', 'clementinaperezarias@gmail.com', '2020-05-11 11:52:07', '1992-11-03', 'ca836087c0e693ac4b7d6ca86fca11fc');

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
  `modificationdate` datetime DEFAULT NULL,
  `idtheme` int(10) UNSIGNED NOT NULL,
  `description` varchar(500) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `videoscourse`
--

INSERT INTO `videoscourse` (`id`, `idcourse`, `name`, `title`, `uploaddate`, `modificationdate`, `idtheme`, `description`) VALUES
(191, 88, '123123123', '123123', '2020-06-20 20:05:01', NULL, 65, 'asdas'),
(194, 94, '307309034', '12212121', '2020-06-20 20:31:12', '2020-07-06 22:13:23', 66, 'asds'),
(195, 95, 'sdfsdfsd', 'sdfsdfd', '2020-07-16 14:26:27', NULL, 67, 'sdfsdfs');

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
  ADD KEY `course_ibfk_1` (`category`),
  ADD KEY `subcategory` (`subcategory`),
  ADD KEY `credentialid` (`credentialid`);

--
-- Indices de la tabla `courseuser`
--
ALTER TABLE `courseuser`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcourse` (`idcourse`),
  ADD KEY `iduser` (`iduser`);

--
-- Indices de la tabla `credentials`
--
ALTER TABLE `credentials`
  ADD PRIMARY KEY (`id`);

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
-- Indices de la tabla `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcategory` (`idcategory`);

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
  MODIFY `id_auth` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=502;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `commentscourse`
--
ALTER TABLE `commentscourse`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `course`
--
ALTER TABLE `course`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT de la tabla `courseuser`
--
ALTER TABLE `courseuser`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1347;

--
-- AUTO_INCREMENT de la tabla `credentials`
--
ALTER TABLE `credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `files`
--
ALTER TABLE `files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT de la tabla `profesion`
--
ALTER TABLE `profesion`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `recover`
--
ALTER TABLE `recover`
  MODIFY `id_recover` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `themes`
--
ALTER TABLE `themes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4294967297;

--
-- AUTO_INCREMENT de la tabla `videoscourse`
--
ALTER TABLE `videoscourse`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

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
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `course_ibfk_2` FOREIGN KEY (`subcategory`) REFERENCES `subcategories` (`id`),
  ADD CONSTRAINT `course_ibfk_3` FOREIGN KEY (`credentialid`) REFERENCES `credentials` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `courseuser`
--
ALTER TABLE `courseuser`
  ADD CONSTRAINT `courseuser_ibfk_2` FOREIGN KEY (`idcourse`) REFERENCES `course` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `courseuser_ibfk_3` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Filtros para la tabla `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`idcategory`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

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
