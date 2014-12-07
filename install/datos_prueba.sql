
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

--
-- Volcado de datos para la tabla `envios`
--

INSERT INTO `envios` (`destinatario`, `telefono`, `direccion`, `poblacion`, `cod_postal`, `provincia`, `email`, `estado`, `fecha_creacion`, `fecha_entrega`, `observaciones`, `zona_envio`, `zona_recepcion`) VALUES
('Fer', '633838388', 'plaza huelva', 'huelva', '21003', 21, 'feer@gmail.com', 'Devuelto', '2014-11-17', '2014-11-18', '', 3, 10),
('Sara', '6333999876', 'San Sebastian 8', 'Valverde del Camino', '23009', 21, 'saraa@gm.com', 'Pendiente', '2014-12-07', NULL, '', 3, NULL),
('Juan', '6505958487', 'Calle nueva', 'sevilla', '45009', 41, 'juan@gm.com', 'Entregado', '2014-11-03', '2014-11-26', '', 3, 9),
('nacho', '6709856789', 'calle gravina', 'jaen', '45667', 23, 'nacho@gm.com', 'Pendiente', '2014-12-03', NULL, '', 3, NULL),
('Conchita', '959280956', 'calle algarve', 'malaga', '34009', 29, 'con@gm.com', 'Pendiente', '2014-12-01', NULL, '', 3, NULL),
('Francisco', '956897867', 'calle jabugo', 'Granada', '23008', 18, 'fran@gr.com', 'Entregado', '2014-11-26', '2014-12-01', '', 4, 4),
('Lola', '654778678', 'Calle huelva', 'sevilla', '45007', 41, 'lola@fr.com', 'Pendiente', '2014-10-05', NULL, '', 4, NULL),
('Maribel', '675987345', 'Calle emilio', 'cadiz', '26005', 11, 'Maribel@gr.com', 'Pendiente', '2014-11-24', NULL, '', 4, NULL),
('Isabel', '654789234', 'Calle reales', 'sevilla', '45008', 41, 'Isa@tp.com', 'Devuelto', '2014-11-20', '2014-12-02', '', 4, 10),
('Jose manuel', '645378956', 'Calle granada', 'HUELVA', '24006', 21, 'JM@gr.com', 'Pendiente', '2014-10-08', NULL, '', 4, NULL),
('Emilio', '674893214', 'Calle argantonio', 'huelva', '21002', 21, 'Emilio@gp.com', 'Pendiente', '2014-10-13', NULL, '', 5, NULL),
('Josefina', '634212876', 'Calle coquina', 'Punta umbria', '24008', 21, 'josefina@fr.com', 'Entregado', '2014-09-09', '2014-11-02', '', 5, 9),
('Kiko', '647978498', 'Calle palos', 'cadiz', '43087', 11, 'Kiko@gf.com', 'Pendiente', '2014-09-22', NULL, '', 5, NULL),
('Onuba Ink', '959863256', 'Calle Arriba', 'Valverde del camino', '34008', 21, 'onuba@fr.com', 'Devuelto', '2014-10-29', '2014-12-03', '', 5, 3),
('Matilde', '959762278', 'Santa fe', 'huelva', '21003', 21, 'matilde@hu.com', 'Pendiente', '2014-10-24', NULL, '', 6, NULL),
('Cristina', '658376523', 'Calle españa', 'Madrid', '45002', 28, 'cris@fr.com', 'Entregado', '2014-12-03', '2014-12-07', '', 6, 10),
('Ana', '696547654', 'Calle puente', 'barcelona', '34876', 33, 'ana@gh.com', 'Devuelto', '2014-12-01', '2014-12-03', '', 6, 5),
('Ana', '696547654', 'Calle puente', 'barcelona', '34876', 8, 'ana@gh.com', 'Pendiente', '2014-11-10', NULL, '', 6, NULL),
('Montemayor', '643998756', 'Plaza mayor', 'Leon', '34007', 24, 'monte@gt.com', 'Pendiente', '2014-11-26', NULL, '', 6, NULL),
('Marta', '6457783345', 'Avenida Andalucía', 'sevilla', '34219', 41, 'marta@hg.com', 'Pendiente', '2014-10-01', NULL, '', 6, NULL),
('Josue', '674987397', 'calle segovia', 'Gibraleón', '21005', 21, 'js@gm.com', 'Entregado', '2014-10-02', '2014-12-03', '', 7, 8),
('Cristian', '674928132', 'Plaza constitucion', 'Sevilla', '32996', 41, 'cris@gm.com', 'Pendiente', '2014-12-04', NULL, '', 7, NULL),
('Caleb', '645879234', 'Av Italia', 'Huelva', '21008', 21, 'caleb@gm.com', 'Pendiente', '2014-11-12', NULL, '', 7, NULL),
('Carmen', '954320823', 'Calle Asuncion', 'Sevilla', '32007', 41, 'carmen@gm.com', 'Devuelto', '2014-11-28', NULL, '', 7, NULL),
('Veronica', '654728976', 'Calle sevilla', 'Valverde de l camino', '34887', 21, 'vero@gm.com', 'Pendiente', '2014-09-02', NULL, '', 7, NULL),
('Celia', '645993856', 'Calle cortadores', 'Valverde del camino', '21600', 21, 'celia@gm.com', 'Entregado', '2014-09-04', '2014-11-25', '', 8, 6),
('Reposo', '675873429', 'Calle Cervantes', 'Huelva', '21004', 21, 'reposo@gm.com', 'Pendiente', '2014-11-17', NULL, '', 8, NULL),
('Maria Jose', '656982976', 'Plaza Castilla', 'sevilla', '21001', 41, 'jose@gm.com', 'Pendiente', '2014-11-24', NULL, '', 8, NULL),
('Maribel', '675987345', 'Calle emilio', 'cadi', '26005', 11, 'Maribel@gr.com', 'Devuelto', '2014-10-15', '2014-10-22', '', 8, 4),
('Herminia', '956897865', 'calle jabugo', 'Granada', '23008', 18, 'herminia@gr.com', 'Pendiente', '2014-10-31', NULL, '', 8, NULL),
('Ana', '696547652', 'Calle puente', 'caceres', '34876', 10, 'ana@gh.com', 'Pendiente', '2014-10-28', NULL, '', 9, NULL),
('Emilio', '664893214', 'Calle fuente', 'Aljaraque', '21002', 21, 'Emilio@gp.com', 'Devuelto', '2014-11-17', '2014-12-04', '', 9, 10),
('Matilde', '969762278', 'Santa fe', 'cadiz', '21003', 11, 'matilde@hu.com', 'Pendiente', '2014-11-19', NULL, '', 9, NULL),
('Teresa', '634873276', 'Calle botica', 'Huelva', '21002', 21, 'teresa@gm.com', 'Pendiente', '2014-08-27', NULL, '', 9, NULL),
('Antonio', '654298743', 'Avenida Andalucía', 'Almeria', '35006', 4, 'antonio@gm.com', 'Pendiente', '2014-11-23', NULL, '', 9, NULL),
('Antonio', '624298743', 'Avenida Andalucía', 'Granada', '35006', 18, 'antonio@gm.com', 'Pendiente', '2014-12-07', NULL, '', 10, NULL),
('Lola', '684778678', 'Calle huelva', 'Madrid', '45007', 28, 'lola@fr.com', 'Pendiente', '2014-11-03', NULL, '', 10, NULL),
('Fernando', '688795192', 'Quintero Baez', 'Cuenca', '32007', 16, 'fcjatlantys@gmail.com', 'Entregado', '2014-11-19', '2014-12-07', '', 10, 6),
('Teresa', '614873276', 'Calle esperanza', 'Huelva', '21003', 21, 'teresa@gm.com', 'Pendiente', '2014-10-01', NULL, '', 10, NULL),
('Marta', '634219876', 'Calle Garcia Lorca', 'Guiuzcoa', '21007', 20, 'marta@gh.com', 'Pendiente', '2014-10-02', NULL, '', 10, NULL);