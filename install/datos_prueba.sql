
--
-- Volcado de datos para la tabla `zonas`
--

INSERT INTO `zonas` (`nombre`) VALUES
('Almería'),
('Cádiz'),
('Córdoba'),
('Granada'),
('Huelva'),
('Jaén'),
('Málaga'),
('Sevilla');

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`nombre`, `clave`, `rol`) VALUES
('dependiente', '7361996ce599feaaf84d1fd87cff7a0be1be668e', 'Usuario'),
('técnico', '6cd723c0cbb6029804ebd3437865af8abc74ab48', 'Usuario'),
('repartidor', 'b9beb7e1dd2c0c8b793d0cda308affda94e10e0f', 'Usuario'),
('encargado', 'b36fff89e3b60ca80e12a16d70289d58f6a50f31', 'Administrador');