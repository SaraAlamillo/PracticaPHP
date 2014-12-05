-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-12-2014 a las 16:34:19
-- Versión del servidor: 5.6.20
-- Versión de PHP: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

CREATE TABLE IF NOT EXISTS `provincias` (
`codigo` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcado de datos para la tabla `provincias`
--

INSERT INTO `provincias` (`nombre`) VALUES ('Alava');
INSERT INTO `provincias` (`nombre`) VALUES ('Albacete');
INSERT INTO `provincias` (`nombre`) VALUES ('Alicante');
INSERT INTO `provincias` (`nombre`) VALUES ('Almera');
INSERT INTO `provincias` (`nombre`) VALUES ('Avila');
INSERT INTO `provincias` (`nombre`) VALUES ('Badajoz');
INSERT INTO `provincias` (`nombre`) VALUES ('Illes Balears');
INSERT INTO `provincias` (`nombre`) VALUES ('Barcelona');
INSERT INTO `provincias` (`nombre`) VALUES ('Burgos');
INSERT INTO `provincias` (`nombre`) VALUES ('Cáceres');
INSERT INTO `provincias` (`nombre`) VALUES ('Cádiz');
INSERT INTO `provincias` (`nombre`) VALUES ('Castellón');
INSERT INTO `provincias` (`nombre`) VALUES ('Ciudad Real');
INSERT INTO `provincias` (`nombre`) VALUES ('Córdoba');
INSERT INTO `provincias` (`nombre`) VALUES ('A Coruña');
INSERT INTO `provincias` (`nombre`) VALUES ('Cuenca');
INSERT INTO `provincias` (`nombre`) VALUES ('Girona');
INSERT INTO `provincias` (`nombre`) VALUES ('Granada');
INSERT INTO `provincias` (`nombre`) VALUES ('Guadalajara');
INSERT INTO `provincias` (`nombre`) VALUES ('Guipzcoa');
INSERT INTO `provincias` (`nombre`) VALUES ('Huelva');
INSERT INTO `provincias` (`nombre`) VALUES ('Huesca');
INSERT INTO `provincias` (`nombre`) VALUES ('Jaén');
INSERT INTO `provincias` (`nombre`) VALUES ('León');
INSERT INTO `provincias` (`nombre`) VALUES ('Lleida');
INSERT INTO `provincias` (`nombre`) VALUES ('La Rioja');
INSERT INTO `provincias` (`nombre`) VALUES ('Lugo');
INSERT INTO `provincias` (`nombre`) VALUES ('Madrid');
INSERT INTO `provincias` (`nombre`) VALUES ('Málaga');
INSERT INTO `provincias` (`nombre`) VALUES ('Murcia');
INSERT INTO `provincias` (`nombre`) VALUES ('Navarra');
INSERT INTO `provincias` (`nombre`) VALUES ('Ourense');
INSERT INTO `provincias` (`nombre`) VALUES ('Asturias');
INSERT INTO `provincias` (`nombre`) VALUES ('Palencia');
INSERT INTO `provincias` (`nombre`) VALUES ('Las Palmas');
INSERT INTO `provincias` (`nombre`) VALUES ('Pontevedra');
INSERT INTO `provincias` (`nombre`) VALUES ('Salamanca');
INSERT INTO `provincias` (`nombre`) VALUES ('Santa Cruz de Tenerife');
INSERT INTO `provincias` (`nombre`) VALUES ('Cantabria');
INSERT INTO `provincias` (`nombre`) VALUES ('Segovia');
INSERT INTO `provincias` (`nombre`) VALUES ('Sevilla');
INSERT INTO `provincias` (`nombre`) VALUES ('Soria');
INSERT INTO `provincias` (`nombre`) VALUES ('Tarragona');
INSERT INTO `provincias` (`nombre`) VALUES ('Teruel');
INSERT INTO `provincias` (`nombre`) VALUES ('Toledo');
INSERT INTO `provincias` (`nombre`) VALUES ('Valencia');
INSERT INTO `provincias` (`nombre`) VALUES ('Valladolid');
INSERT INTO `provincias` (`nombre`) VALUES ('Vizcaya');
INSERT INTO `provincias` (`nombre`) VALUES ('Zamora');
INSERT INTO `provincias` (`nombre`) VALUES ('Zaragoza');
INSERT INTO `provincias` (`nombre`) VALUES ('Ceuta');
INSERT INTO `provincias` (`nombre`) VALUES ('Melilla');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
`codigo` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `rol` enum('Administrador','Usuario') NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
`codigo` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcado de datos para la tabla `zonas`
--

INSERT INTO `zonas` (`nombre`) VALUES
('Por defecto');

-- --------------------------------------------------------

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

-- --------------------------------------------------------

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `envios`
--
ALTER TABLE `envios`
MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT de la tabla `provincias`
--
ALTER TABLE `provincias`
MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT de la tabla `zonas`
--
ALTER TABLE `zonas`
MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;

-- --------------------------------------------------------

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `envios`
--
ALTER TABLE `envios`
ADD CONSTRAINT `fk_provincia` FOREIGN KEY (`provincia`) REFERENCES `provincias` (`codigo`);

--/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
--/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
--/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;