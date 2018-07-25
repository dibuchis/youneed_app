INSERT INTO `estados` (`id`, `nombre`) VALUES (1, 'Activo'), (2, 'Inactivo');

INSERT INTO `cuentas` (`id`, `cuenta_id`, `nombre_comercial`, `nombres`, `apellidos`, `identificacion`, `direccion`, `telefonos`, `pagina_web`, `skype`, `observaciones`, `tipo`, `numero_dispositivos`, `fecha_creacion`, `fecha_actualizacion`, `estado_id`) VALUES (NULL, NULL, 'Abitmedia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1');

INSERT INTO `usuarios` (`id`, `cuenta_id`, `nombres`, `apellidos`, `email`, `clave`, `tipo`, `fecha_creacion`, `estado_id`) VALUES (NULL, '1', 'Juan Carlos', 'Cedillo Crespo', 'info@abitmedia.com', '$2y$13$yI1Tn7Z0tCCNkDX69zhB9O.Fgn43LZsjIu.axJ8/jaZF6FgeNfDxO', 'Superadmin', NULL, '1');

INSERT INTO `categorias` (`id`, `nombre`, `icono`) VALUES (NULL, 'Automóvil', 'automovil.png'), (NULL, 'Autobús', 'autobus.png'), (NULL, 'Camión', 'camion.png'), (NULL, 'Barco', 'barco.png'), (NULL, 'Avión', 'avion.png'), (NULL, 'Motocicleta', 'motocicleta.png'), (NULL, 'Bicicleta', 'bicicleta.png'), (NULL, 'Persona', 'persona.png'), (NULL, 'Animal', 'animal.png');

