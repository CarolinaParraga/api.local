-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-06-2023 a las 11:21:49
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `api-rentamoto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230501172925', '2023-05-01 19:30:05', 321);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moto`
--

CREATE TABLE `moto` (
  `id` int(11) NOT NULL,
  `carregistration` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `moto`
--

INSERT INTO `moto` (`id`, `carregistration`, `color`, `brand`, `model`, `price`, `photo`, `description`) VALUES
(3, '9999BBB', 'Pistacho', 'Fantic', 'Electric L1', 15, 'http://api.local\\uploads\\imgs\\Electric L1.jpg', 'Carnet licencia ciclomotor'),
(4, '8999BBC', 'Azul', 'Ecooter', 'E2 Max', 20, 'http://api.local\\uploads\\imgs\\E2Max.jpg', 'Carnet B y A1'),
(5, '5647ADC', 'Gris', 'Ebroh', 'Strada', 20, 'http://api.local\\uploads\\imgs\\Strada.jpg', 'Carnet B y A1'),
(6, '3337AFS', 'Azul', 'Ebroh', 'Strada Li', 15, 'http://api.local\\uploads\\imgs\\Stradali.jpg\n', 'Carnet licencia ciclomotor'),
(8, '6666CFS', 'Negro', 'Yamaha', 'Neo', 15, 'http://api.local\\uploads\\imgs\\Neo.jpg', 'Carnet licencia ciclomotor'),
(9, '5555BBB', 'Azul', 'BMW', 'TX', 20, 'http://api.local\\uploads\\imgs\\TX.jpg', 'Carnet A1'),
(10, '4444CCC', 'Azul', 'Yamaha', 'GH0', 25, 'http://api.local\\uploads\\imgs\\GH0.jpg', 'Carnet A1'),
(11, '6666FFF', 'Rosa', 'Yamaha', 'TR87', 15, 'http://api.local\\uploads\\imgs\\TR87.jpg', 'Carnet ciclomotor'),
(14, '6635BBk', 'Azul', 'Honda', 'RG66', 25, 'http://api.local\\uploads\\imgs\\RG66.jpg', 'Carnet A1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `moto_id` int(11) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  `starthour` varchar(255) NOT NULL,
  `endhour` varchar(255) NOT NULL,
  `pickuplocation` varchar(255) NOT NULL,
  `returnlocation` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `reservation`
--

INSERT INTO `reservation` (`id`, `user_id`, `moto_id`, `startdate`, `enddate`, `status`, `starthour`, `endhour`, `pickuplocation`, `returnlocation`) VALUES
(6, 8, 11, '2023-07-08', '2023-07-09', 1, '10:00', '11:00', 'Aeropuerto de Alicante', 'Aeropuerto de Alicante'),
(7, 8, 3, '2023-07-10', '2023-07-21', 1, '20:00', '21:00', 'Aeropuerto de Alicante', 'Aeropuerto de Alicante'),
(8, 8, 3, '2023-08-04', '2023-08-06', 1, '21:00', '10:00', 'Hotel Meliá', 'Hotel Meliá');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `license` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `name`, `phone`, `license`) VALUES
(3, 'admin1@gmail.com', '[\"ROLE_USER\", \"ROLE_ADMIN\"]', '$2y$13$zFBCx0./HEK.sNsGEQy0v.Ic1HOFOeFsrg2y9s9dJPws9AHa/l3PK', 'admin1', 888888888, '52526565P'),
(7, 'user5@gmail.com', '[\"ROLE_USER\"]', '$2y$13$aodIhCuDNqtD5NGYaVCmX.rqTcHMB3I1dQHXjN5f.9We3Qu2fk.ri', 'user5', 626265686, '62624141B'),
(8, 'user6@gmail.com', '[\"ROLE_USER\"]', '$2y$13$Kuvwjs7R5Uc2aHCQv5497.rtqBIuud7uTvf8U7liDAeW3tQhhhZCe', 'user6', 656484895, '51426468F');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `moto`
--
ALTER TABLE `moto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_42C84955A76ED395` (`user_id`),
  ADD KEY `IDX_42C8495578B8F2AC` (`moto_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `moto`
--
ALTER TABLE `moto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `FK_42C8495578B8F2AC` FOREIGN KEY (`moto_id`) REFERENCES `moto` (`id`),
  ADD CONSTRAINT `FK_42C84955A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
