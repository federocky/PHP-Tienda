-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2021 at 08:22 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tiendaphp`
--

-- --------------------------------------------------------

--
-- Table structure for table `cliente`
--

CREATE TABLE `cliente` (
  `id` int(3) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `contrasenia` varchar(255) NOT NULL,
  `fecha_alta` timestamp NOT NULL DEFAULT current_timestamp(),
  `activo` bit(1) DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cliente`
--

INSERT INTO `cliente` (`id`, `nombre`, `apellidos`, `email`, `contrasenia`, `fecha_alta`, `activo`) VALUES
(4, 'Federico', 'Jácome', 'calabazo@hotmail.com', '$2y$10$tZsph7MZm9jLQc.QD8fLxO63Gr./6DwShkiVImfnW84H8rq/RnJCq', '2020-12-28 21:09:09', b'0'),
(5, 'Federico', 'Jácome', 'calabazo1@hotmail.com', '$2y$10$GQd5/pNkOOZbPeEOFF.GP.aXjHeNZIgeJ7fuAUKb3r9TP42yTza3i', '2020-12-28 21:09:57', b'0'),
(6, 'Federico', 'Jácome', 'calabazo2@hotmail.com', '$2y$10$U9A/Q3X3uo0nhDncSwjhWOmvm8Kl/s2F9CUw8syJ9lpLzYJdVg5kG', '2020-12-28 21:12:27', b'0'),
(7, 'Lorena', 'Bellido', 'lorenabp2@gmail.com', '$2y$10$Q32p6/vSGfBek3Nh2wE8.uagBv6X4tngjqKKr5iHB50d.nbB.5QFu', '2021-01-02 19:27:10', b'1'),
(8, 'fede', 'Jaco', 'fede@gmail.com', '$2y$10$qF3gRBigvlWs647BlGYo.euAmS6lIME86pex1mJv3gZf2JEGR.nb2', '2021-01-05 11:33:32', b'1'),
(9, 'Calaaaaaaaa', 'faaa', 'calabazo2@gmail.com', '$2y$10$UGHAHuSengjh1mSGc.PqUehSyqWZwQWqORebVF8sBePQ.d9VdL5gK', '2021-01-05 12:23:37', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `compra`
--

CREATE TABLE `compra` (
  `id` int(10) NOT NULL,
  `id_cliente` int(3) DEFAULT NULL,
  `id_domicilio` int(3) DEFAULT NULL,
  `id_metodo_pago` int(2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_empleado_responsable` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `compra`
--

INSERT INTO `compra` (`id`, `id_cliente`, `id_domicilio`, `id_metodo_pago`, `total`, `fecha`, `id_empleado_responsable`) VALUES
(2, 5, 2, 2, '56.50', '2021-01-03 18:35:00', NULL),
(3, 4, 1, 2, '28.28', '2021-01-04 16:31:30', NULL),
(4, 4, 1, 2, '28.28', '2021-01-04 16:33:17', NULL),
(5, 5, 2, 2, '15.28', '2021-01-04 16:38:04', NULL),
(6, 6, 3, 2, '40.78', '2021-01-04 17:51:55', NULL),
(7, 6, 3, 2, '28.28', '2021-01-04 17:55:04', NULL),
(8, 8, 5, 2, '33.78', '2021-01-05 11:34:15', NULL),
(9, 8, 5, 2, '150.75', '2021-01-05 11:55:15', NULL),
(10, 8, 6, 2, '28.28', '2021-01-06 09:28:35', NULL),
(11, 8, 7, 2, '5.50', '2021-01-06 09:41:23', NULL),
(12, 8, 8, 2, '2.78', '2021-01-06 10:04:24', NULL),
(13, 8, 9, 2, '25.50', '2021-01-06 10:05:15', NULL),
(14, 8, 10, 2, '25.50', '2021-01-06 10:20:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `id` int(10) NOT NULL,
  `id_compra` int(10) DEFAULT NULL,
  `id_producto` int(4) DEFAULT NULL,
  `cantidad` int(3) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detalle_compra`
--

INSERT INTO `detalle_compra` (`id`, `id_compra`, `id_producto`, `cantidad`, `precio`) VALUES
(2, 2, 3, 2, '25.50'),
(3, 2, 4, 1, '5.50'),
(4, 2, 3, 1, '25.50'),
(5, 2, 2, 1, '2.78'),
(6, 2, 3, 1, '25.50'),
(7, 2, 2, 1, '2.78'),
(8, 2, 2, 1, '2.78'),
(9, 2, 1, 1, '12.50'),
(10, 2, 3, 1, '25.50'),
(11, 2, 2, 1, '2.78'),
(12, 2, 1, 1, '12.50'),
(13, 2, 3, 1, '25.50'),
(14, 2, 2, 1, '2.78'),
(15, 8, 2, 1, '2.78'),
(16, 8, 3, 1, '25.50'),
(17, 8, 4, 1, '5.50'),
(18, 9, 7, 1, '25.50'),
(19, 9, 11, 1, '125.25'),
(20, 10, 2, 1, '2.78'),
(21, 10, 3, 1, '25.50'),
(22, 11, 4, 1, '5.50'),
(23, 12, 2, 1, '2.78'),
(24, 13, 3, 1, '25.50'),
(25, 14, 3, 1, '25.50');

-- --------------------------------------------------------

--
-- Table structure for table `domicilio`
--

CREATE TABLE `domicilio` (
  `id` int(3) NOT NULL,
  `id_cliente` int(3) DEFAULT NULL,
  `calle` varchar(50) DEFAULT NULL,
  `provincia` varchar(50) DEFAULT NULL,
  `ciudad` varchar(50) DEFAULT NULL,
  `cp` varchar(5) DEFAULT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `escalera` varchar(10) DEFAULT NULL,
  `piso` varchar(3) DEFAULT NULL,
  `puerta` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `domicilio`
--

INSERT INTO `domicilio` (`id`, `id_cliente`, `calle`, `provincia`, `ciudad`, `cp`, `numero`, `escalera`, `piso`, `puerta`) VALUES
(1, 4, 'San Mateo', 'Málaga', 'Mijas', '29651', '3', 'izq', '3', 'A'),
(2, 5, 'Pase Maritimo', 'Málaga', 'Málaga', '29655', '2', '', '5', 'B'),
(3, 6, '', 'provincia', 'ciudad', '55555', '', '', '123', 'L'),
(4, 6, 'calle', 'provincia', 'ciudad', '55555', '', '5', '5', '5'),
(5, 8, 'nueva', 'nuev', 'nuev', '29651', '', '', '', ''),
(6, 8, 'segunda', 'direccion', 'madrid', '25655', '', '1', '1', '1'),
(7, 8, 'fede', 'fede', 'fede', '25555', '', 'fede', 'fed', 'fede'),
(8, 8, '', '', '', '', '', '', '', ''),
(9, 8, '', '', '', '', '', '', '', ''),
(10, 8, 'naranjo', 'naranjo', 'naranjo', '25655', '', '', '', ''),
(11, 8, 'aaaaa', 'aaaaa', 'aaaa', '26512', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `empleado`
--

CREATE TABLE `empleado` (
  `id` int(3) NOT NULL,
  `nombre_usuario` varchar(30) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `contrasenia` varchar(255) NOT NULL,
  `fecha_alta` timestamp NOT NULL DEFAULT current_timestamp(),
  `activo` bit(1) DEFAULT b'1',
  `administrador` enum('si','no') DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `empleado`
--

INSERT INTO `empleado` (`id`, `nombre_usuario`, `nombre`, `apellidos`, `email`, `contrasenia`, `fecha_alta`, `activo`, `administrador`) VALUES
(1, '1234', 'Federico', 'Jácome Castañeda', 'federicoandres@iesvegademijas.es', '1234', '2020-12-10 20:14:06', b'1', 'si'),
(2, '1111', 'Algoritmo', 'De las Casas', 'Algo@ritmo.es', '123456789', '2020-12-10 20:14:06', b'1', 'si'),
(3, 'fede', 'fede', 'fede', 'fede', '1234', '2021-01-06 18:30:25', b'1', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `metodo_pago`
--

CREATE TABLE `metodo_pago` (
  `id` int(3) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `activo` bit(1) DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `metodo_pago`
--

INSERT INTO `metodo_pago` (`id`, `nombre`, `activo`) VALUES
(1, 'Efectivo', b'1'),
(2, 'Tarjeta', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE `producto` (
  `id` int(4) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `marca` varchar(30) DEFAULT NULL,
  `stock` int(4) DEFAULT NULL,
  `img` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `descripcion`, `precio`, `marca`, `stock`, `img`) VALUES
(1, 'Correaaaaa', 'Una correa muy buena y estable', '12.50', 'Shock', 0, 'img/productos/correa-perro.jpg'),
(2, 'Juguete sonido ', 'Es un juguete de calidad optima y un sonido hermos', '2.78', 'Shock', 999, 'img/productos/muneco-perro.jpg'),
(3, 'Cama para perro', 'Una cama muy como y estable ideal para un perro o ', '25.50', 'Resting', 999, 'img/productos/cama-perro.jpg'),
(4, 'Gato gusanito', 'Un muñeco buenisimo que puede entrener a tu perro ', '5.50', 'Toy', 999, 'img/productos/gato-gusanito.jpg'),
(5, 'Carrito peluche', 'Uncarrito muy chulo', '30.50', 'Shock', 999, 'img/productos/carrito-peluche.jpg'),
(6, 'Gato gusanito azul', 'Es un juguete de calidad optima y un sonido hermos', '5.55', 'Neil', 999, 'img/productos/gato-gusanito-azul.jpg'),
(7, 'Manta para perro', 'Una manta suavecita y abrigada', '25.50', 'Resting', 999, 'img/productos/manta-perro.jpg'),
(8, 'Peluches para gato', 'Dos peluchitos agradables para tener ahi en casa', '13.75', 'Toy', 999, 'img/productos/peluches-gato.jpg'),
(9, 'Carrito peluche', 'Uncarrito muy chulo', '99.50', 'Shock', 999, 'img/productos/pelota-perro.jpg'),
(10, 'Gato gusanito azul', 'Es un juguete de calidad optima y un sonido hermos', '12.50', 'Neil', 999, 'img/productos/peluche.jpg'),
(11, 'Manta para perro', 'Una manta suavecita y abrigada', '125.25', 'Resting', 999, 'img/productos/peluche-perro.jpg'),
(12, 'Peluches para gato', 'Dos peluchitos agradables para tener ahi en casa', '1.00', 'Toy', 999, 'img/productos/tunel.jpg'),
(13, 'Nuevo', 'nuevo', '6.55', 'nuevo', 999, 'no');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_compra_cliente` (`id_cliente`),
  ADD KEY `fk_compra_metodo` (`id_metodo_pago`),
  ADD KEY `fk_compra_domicilio` (`id_domicilio`),
  ADD KEY `fk_compra_empleado` (`id_empleado_responsable`);

--
-- Indexes for table `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detalla` (`id_compra`),
  ADD KEY `fk_detalle_producto` (`id_producto`);

--
-- Indexes for table `domicilio`
--
ALTER TABLE `domicilio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_domicilio_cliente` (`id_cliente`);

--
-- Indexes for table `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `metodo_pago`
--
ALTER TABLE `metodo_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `domicilio`
--
ALTER TABLE `domicilio`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `metodo_pago`
--
ALTER TABLE `metodo_pago`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fk_compra_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `fk_compra_domicilio` FOREIGN KEY (`id_domicilio`) REFERENCES `domicilio` (`id`),
  ADD CONSTRAINT `fk_compra_empleado` FOREIGN KEY (`id_empleado_responsable`) REFERENCES `empleado` (`id`),
  ADD CONSTRAINT `fk_compra_metodo` FOREIGN KEY (`id_metodo_pago`) REFERENCES `metodo_pago` (`id`);

--
-- Constraints for table `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `fk_detalla` FOREIGN KEY (`id_compra`) REFERENCES `compra` (`id`),
  ADD CONSTRAINT `fk_detalle_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`);

--
-- Constraints for table `domicilio`
--
ALTER TABLE `domicilio`
  ADD CONSTRAINT `fk_domicilio_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
