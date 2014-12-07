-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-12-2014 a las 21:22:59
-- Versión del servidor: 5.6.20
-- Versión de PHP: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `ke`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envios`
--

CREATE TABLE IF NOT EXISTS `envios` (
`codigo` int(11) NOT NULL AUTO_INCREMENT,
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
  `zona_recepcion` int(11) DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `zona_envio` (`zona_envio`),
  KEY `zona_recepcion` (`zona_recepcion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

CREATE TABLE IF NOT EXISTS `provincias` (
`codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `provincias`
--

INSERT INTO `provincias` (`nombre`) VALUES
('Alava'),
('Albacete'),
('Alicante'),
('Almeria'),
('Avila'),
('Badajoz'),
('Illes Balears'),
('Barcelona'),
('Burgos'),
('Cáceres'),
('Cádiz'),
('Castellón'),
('Ciudad Real'),
('Córdoba'),
('A Coruña'),
('Cuenca'),
('Girona'),
('Granada'),
('Guadalajara'),
('Guipzcoa'),
('Huelva'),
('Huesca'),
('Jaén'),
('León'),
('Lleida'),
('La Rioja'),
('Lugo'),
('Madrid'),
('Málaga'),
('Murcia'),
('Navarra'),
('Ourense'),
('Asturias'),
('Palencia'),
('Las Palmas'),
('Pontevedra'),
('Salamanca'),
('Santa Cruz de Tenerife'),
('Cantabria'),
('Segovia'),
('Sevilla'),
('Soria'),
('Tarragona'),
('Teruel'),
('Toledo'),
('Valencia'),
('Valladolid'),
('Vizcaya'),
('Zamora'),
('Zaragoza'),
('Ceuta'),
('Melilla');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
`codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `rol` enum('Administrador','Usuario') NOT NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`nombre`, `clave`, `rol`) VALUES
('admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zonas`
--

CREATE TABLE IF NOT EXISTS `zonas` (
`codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `zonas`
--

INSERT INTO `zonas` (`nombre`) VALUES
('Por defecto');

INSERT INTO `zonas` (`codigo`,`nombre`) VALUES
(0, '');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `envios`
--
ALTER TABLE `envios`
ADD CONSTRAINT `fk_provincia` FOREIGN KEY (`provincia`) REFERENCES `provincias` (`codigo`);
ALTER TABLE `envios`
ADD CONSTRAINT `fk_envio` FOREIGN KEY (`zona_envio`) REFERENCES `zonas` (`codigo`);
ALTER TABLE `envios`
ADD CONSTRAINT `fk_recepcion` FOREIGN KEY (`zona_recepcion`) REFERENCES `zonas` (`codigo`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;