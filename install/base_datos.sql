-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-12-2014 a las 01:59:07
-- Versión del servidor: 5.6.20
-- Versión de PHP: 5.5.15
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
--
-- Base de datos: `kenollega`
--
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `envios`
--
CREATE TABLE IF NOT EXISTS `envios` (
`codigo` int(11) NOT NULL,
  `destinatario` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `poblacion` varchar(50) NOT NULL,
  `cod_postal` char(5) NOT NULL,
  `provincia` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `estado` enum('Pendiente','Entregado','Devuelto') NOT NULL,
  `fecha_creacion` date NOT NULL,
  `fecha_entrega` date DEFAULT NULL,
  `observaciones` text,
  `zona_envio` int(11) DEFAULT NULL,
  `zona_recepcion` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;
--
-- Volcado de datos para la tabla `envios`
--
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `provincias`
--
CREATE TABLE IF NOT EXISTS `provincias` (
`codigo` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;
--
-- Volcado de datos para la tabla `provincias`
--
INSERT INTO `provincias` (`codigo`, `nombre`) VALUES
(1, 'Alava'),
(2, 'Albacete'),
(3, 'Alicante'),
(4, 'Almera'),
(5, 'Avila'),
(6, 'Badajoz'),
(7, 'Illes Balears'),
(8, 'Barcelona'),
(9, 'Burgos'),
(10, 'Cáceres'),
(11, 'Cádiz'),
(12, 'Castellón'),
(13, 'Ciudad Real'),
(14, 'Córdoba'),
(15, 'A Coruña'),
(16, 'Cuenca'),
(17, 'Girona'),
(18, 'Granada'),
(19, 'Guadalajara'),
(20, 'Guipzcoa'),
(21, 'Huelva'),
(22, 'Huesca'),
(23, 'Jaén'),
(24, 'León'),
(25, 'Lleida'),
(26, 'La Rioja'),
(27, 'Lugo'),
(28, 'Madrid'),
(29, 'Málaga'),
(30, 'Murcia'),
(31, 'Navarra'),
(32, 'Ourense'),
(33, 'Asturias'),
(34, 'Palencia'),
(35, 'Las Palmas'),
(36, 'Pontevedra'),
(37, 'Salamanca'),
(38, 'Santa Cruz de Tenerife'),
(39, 'Cantabria'),
(40, 'Segovia'),
(41, 'Sevilla'),
(42, 'Soria'),
(43, 'Tarragona'),
(44, 'Teruel'),
(45, 'Toledo'),
(46, 'Valencia'),
(47, 'Valladolid'),
(48, 'Vizcaya'),
(49, 'Zamora'),
(50, 'Zaragoza'),
(51, 'Ceuta'),
(52, 'Melilla');
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `usuarios`
--
CREATE TABLE IF NOT EXISTS `usuarios` (
`codigo` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `rol` enum('Administrador','Usuario','','') NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
--
-- Volcado de datos para la tabla `usuarios`
--
INSERT INTO `usuarios` (`codigo`, `nombre`, `clave`, `rol`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Administrador');
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `zonas`
--
CREATE TABLE IF NOT EXISTS `zonas` (
`codigo` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
--
-- Volcado de datos para la tabla `zonas`
--

INSERT INTO `zonas` (`codigo`, `nombre`) VALUES
(1, 'Por defecto');
--
-- Índices para tablas volcadas
--
--
-- Indices de la tabla `envios`
--
ALTER TABLE `envios`
 ADD PRIMARY KEY (`codigo`), ADD KEY `provincia` (`provincia`), ADD KEY `zona_envio` (`zona_envio`), ADD KEY `zona_recepcion` (`zona_recepcion`);
--
-- Indices de la tabla `provincias`
--
ALTER TABLE `provincias`
 ADD PRIMARY KEY (`codigo`);
--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
 ADD PRIMARY KEY (`codigo`), ADD UNIQUE KEY `nombre` (`nombre`);
--
-- Indices de la tabla `zonas`
--
ALTER TABLE `zonas`
 ADD PRIMARY KEY (`codigo`), ADD UNIQUE KEY `nombre` (`nombre`);
--
-- AUTO_INCREMENT de las tablas volcadas
--
--
-- AUTO_INCREMENT de la tabla `envios`
--
ALTER TABLE `envios`
MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT de la tabla `provincias`
--
ALTER TABLE `provincias`
MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `zonas`
--
ALTER TABLE `zonas`
MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--
--
-- Filtros para la tabla `envios`
--
ALTER TABLE `envios`
ADD CONSTRAINT `fk_provincia` FOREIGN KEY (`provincia`) REFERENCES `provincias` (`codigo`);