SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `kenollega`
--

CREATE DATABASE `kenollega`;
USE `kenollega`;

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
  `estado` enum('P','E','D') NOT NULL,
  `fecha_creacion` date NOT NULL,
  `fecha_entrega` date NOT NULL,
  `observaciones` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

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
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `envios`
--
ALTER TABLE `envios`
 ADD PRIMARY KEY (`codigo`), ADD KEY `provincia` (`provincia`);

--
-- Indices de la tabla `provincias`
--
ALTER TABLE `provincias`
 ADD PRIMARY KEY (`codigo`);

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
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `envios`
--
ALTER TABLE `envios`
ADD CONSTRAINT `envios_ibfk_1` FOREIGN KEY (`provincia`) REFERENCES `provincias` (`codigo`);
