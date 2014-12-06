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
-- Estructura de tabla para la tabla `provincias`
--
CREATE TABLE IF NOT EXISTS `provincias` (
`codigo` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;
--
-- Volcado de datos para la tabla `provincias`
--
INSERT INTO `provincias` (`nombre`) VALUES
('Alava'),
('Albacete'),
('Alicante'),
('Almera'),
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
-- Estructura de tabla para la tabla `envios`
--
CREATE TABLE IF NOT EXISTS `envios` (
`codigo` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
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
  FOREIGN KEY (`provincia`) REFERENCES `provincias` (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;
--
-- Volcado de datos para la tabla `envios`
--
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `usuarios`
--
CREATE TABLE IF NOT EXISTS `usuarios` (
`codigo` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL UNIQUE,
  `clave` varchar(100) NOT NULL,
  `rol` enum('Administrador','Usuario','','') NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;
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
`codigo` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL UNIQUE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;
--
-- Volcado de datos para la tabla `zonas`
--
INSERT INTO `zonas` (`nombre`) VALUES
('Por defecto');