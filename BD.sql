
INSERT INTO `menu` (`titulo`, `enlace`, `orden`) VALUES ('Inicio', '/', '1');
INSERT INTO `menu` (`titulo`, `enlace`, `orden`) VALUES ('Cuadro médico', '/cuadro_medico', '2');
INSERT INTO `menu` (`titulo`, `enlace`, `orden`) VALUES ('Servicios', '/servicios', '3');
INSERT INTO `menu` (`titulo`, `enlace`, `orden`) VALUES ('Encuestas', '/encuestas', '4');
INSERT INTO `menu` (`titulo`, `enlace`, `orden`) VALUES ('Cita previa', '/cita_previa', '5');
INSERT INTO `menu` (`titulo`, `enlace`, `orden`) VALUES ('Bolsa trabajo', '/bolsa_trabajo', '6');
INSERT INTO `menu` (`titulo`, `enlace`, `orden`) VALUES ('Iniciar sesión', '/login', '7');
INSERT INTO `menu` (`titulo`, `enlace`, `orden`) VALUES ('Cerrar sesión', '/logout', '8');
INSERT INTO `menu` (`titulo`, `enlace`, `orden`) VALUES ('Mi perfil', '/gestion_usuarios', '9');


INSERT INTO `footer` (`titulo`, `enlace`, `fila`, `columna` ) VALUES ('Inicio', '/', '1', '1');
INSERT INTO `footer` (`titulo`, `enlace`, `fila`, `columna` ) VALUES ('Cuadro médico', '/cuadro_medico', '1', '2');
INSERT INTO `footer` (`titulo`, `enlace`, `fila`, `columna` ) VALUES ('Servicios', '/servicios', '1', '3');
INSERT INTO `footer` (`titulo`, `enlace`, `fila`, `columna`) VALUES ('Encuestas', '/encuestas', '2', '1');
INSERT INTO `footer` (`titulo`, `enlace`, `fila`, `columna`) VALUES ('Cita previa', '/cita_previa', '2', '2');
INSERT INTO `footer` (`titulo`, `enlace`, `fila`, `columna`) VALUES ('Bolsa trabajo', '/bolsa_trabajo', '2', '3');
INSERT INTO `footer` (`titulo`, `enlace`, `fila`, `columna`) VALUES ('Iniciar sesión', '/iniciar_sesion', '3', '1');
INSERT INTO `footer` (`titulo`, `enlace`, `fila`, `columna`) VALUES ('Contacto', '/', '3', '2');



INSERT INTO `especialidades` (`nombre`) VALUES
('Rehabilitación Deportiva'),
('Terapia Manual Ortopédica'),
('Kinesiotaping'),
('Readaptación Funcional'),
('Electroterapia'),
('Masoterapia'),
('Ejercicio Terapéutico'),
('Prevención de Lesiones Deportivas'),
('Fisioterapia Neuromuscular'),
('Fisioterapia Respiratoria en Deportistas'),
('Vendaje Neuromuscular'),
('Biomecánica y Análisis del Movimiento'),
('Punción Seca'),
('Crioterapia y Termoterapia'),
('Hidroterapia'),
('Entrenamiento Propioceptivo'),
('Terapia de Ondas de Choque'),
('Fisioterapia en Lesiones Tendinosas');

INSERT INTO `servicios` (`especialidad_id`, `nombre`) VALUES
(1, 'Sesión de Rehabilitación Post-Lesión'),
(1, 'Recuperación Funcional para Deportistas'),
(2, 'Terapia Manual Ortopédica para Lesiones Deportivas'),
(2, 'Liberación Miofascial en Deportistas'),
(3, 'Aplicación de Vendaje Neuromuscular (Kinesiotaping)'),
(3, 'Curso de Autovendaje Neuromuscular'),
(4, 'Programa de Readaptación Física'),
(4, 'Plan de Entrenamiento Correctivo'),
(5, 'Sesión de Electroterapia para Recuperación Muscular'),
(5, 'Terapia de Electroestimulación Neuromuscular'),
(6, 'Masaje Deportivo y Descontracturante'),
(6, 'Terapia de Masaje Miofascial'),
(7, 'Ejercicio Terapéutico para Prevención de Lesiones'),
(7, 'Entrenamiento de Fuerza para la Recuperación'),
(8, 'Evaluación y Prevención de Lesiones'),
(8, 'Estudio de Factores de Riesgo en Lesiones'),
(9, 'Fisioterapia para Recuperación Neuromuscular'),
(9, 'Tratamiento de Lesiones Neuromusculares en Atletas'),
(10, 'Tratamiento de Problemas Respiratorios en Atletas'),
(10, 'Ejercicios Respiratorios para Alto Rendimiento'),
(11, 'Vendaje Funcional para Soporte Articular'),
(11, 'Aplicación de Vendaje Rígido y Elástico'),
(12, 'Análisis Biomecánico y Corrección Postural'),
(12, 'Evaluación de Marcha y Carrera en Deportistas'),
(13, 'Punción Seca para Tratamiento de Puntos Gatillo'),
(13, 'Terapia de Punción Seca para Contracturas Musculares'),
(14, 'Terapia con Frío y Calor para Recuperación'),
(14, 'Crioterapia para Desinflamación Muscular'),
(15, 'Hidroterapia para Recuperación Muscular'),
(15, 'Sesión de Hidroterapia para Lesiones Deportivas'),
(16, 'Entrenamiento Propioceptivo para Estabilidad'),
(16, 'Terapia de Estabilidad y Equilibrio en Deportistas'),
(17, 'Terapia con Ondas de Choque para Tendinopatías'),
(17, 'Tratamiento de Fascitis Plantar con Ondas de Choque'),
(18, 'Fisioterapia para Lesiones Tendinosas'),
(18, 'Terapia de Recuperación en Tendinitis y Bursitis');

INSERT INTO `medicos` (`nombre`, `apellido`) VALUES
('Carlos', 'Gómez'),
('Ana', 'Fernández'),
('Luis', 'Martínez'),
('Elena', 'Ramírez'),
('Javier', 'López');

INSERT INTO `medicos_especialidades` (`medicos_id`, `especialidades_id`) VALUES
(1, 1), 
(1, 5),
(2, 3),
(2, 7), 
(3, 2), 
(3, 6), 
(4, 8), 
(4, 9), 
(5, 10),
(5, 13);



UPDATE `especialidades` SET `categoria` = 'Rehabilitación' WHERE `nombre` IN (
    'Rehabilitación Deportiva',
    'Readaptación Funcional',
    'Fisioterapia en Lesiones Tendinosas'
);

UPDATE `especialidades` SET `categoria` = 'Terapias Manuales' WHERE `nombre` IN (
    'Terapia Manual Ortopédica',
    'Masoterapia',
    'Ejercicio Terapéutico'
);

UPDATE `especialidades` SET `categoria` = 'Vendajes y Soportes' WHERE `nombre` IN (
    'Kinesiotaping',
    'Vendaje Neuromuscular'
);

UPDATE `especialidades` SET `categoria` = 'Electroterapia' WHERE `nombre` IN (
    'Electroterapia',
    'Terapia de Ondas de Choque'
);

UPDATE `especialidades` SET `categoria` = 'Prevención y Evaluación' WHERE `nombre` IN (
    'Prevención de Lesiones Deportivas',
    'Biomecánica y Análisis del Movimiento'
);

UPDATE `especialidades` SET `categoria` = 'Terapias Avanzadas' WHERE `nombre` IN (
    'Punción Seca',
    'Crioterapia y Termoterapia',
    'Hidroterapia',
    'Entrenamiento Propioceptivo'
);

UPDATE `especialidades` SET `categoria` = 'Fisioterapia Especializada' WHERE `nombre` IN (
    'Fisioterapia Neuromuscular',
    'Fisioterapia Respiratoria en Deportistas'
);


INSERT INTO `puesto_trabajo` (`nombre`, `activo`) VALUES
('Fisioterapeuta Deportivo', 1),
('Terapeuta Manual', 1),
('Especialista en Rehabilitación Neuromuscular', 0),
('Técnico en Masoterapia', 1),
('Especialista en Kinesiotaping', 1),
('Fisioterapeuta Respiratorio', 1),
('Instructor de Hidroterapia', 0),
('Especialista en Terapia de Ondas de Choque', 1),
('Biomecánico en Análisis del Movimiento', 1),
('Fisioterapeuta en Lesiones Tendinosas', 1),
('Técnico en Vendaje Neuromuscular', 1),
('Experto en Readaptación Funcional', 0),
('Técnico en Crioterapia y Termoterapia', 1),
('Entrenador en Prevención de Lesiones', 1),
('Fisioterapeuta General', 1);


// Usuarios
INSERT INTO `user` (`email`, `roles`, `password`) VALUES
('admin@admin.com', '["ROLE_ADMIN"]', 'admin'),
('user@user.com', '["ROLE_USER"]', 'user'),
('medico@medico.com', '["ROLE_MEDICO"]', 'medico');

UPDATE `user` SET `password` = '$2y$13$NUJSuvFpVgWwry7w9Bxca.lTl4fG6sf28OFlZHjS7PmspzRYtm4wO' WHERE `email` = 'admin@admin.com';
UPDATE `user` SET `password` = '$2y$13$FO8vxjeanp5MAX2V.6EV6OWsUjLw.GPkPBceTL75xjDRuMTOCcxPe' WHERE `email` = 'user@user.com';
UPDATE `user` SET `password` = '$2y$13$oOVXx0WCIEL3adLAWGzheeJ32.Ts/f9uEeixlLghHrVgqVxCfa2lK' WHERE `email` = 'medico@medico.com';

INSERT INTO `tipo_encuesta` (`nombre`) VALUES
('Encuesta satisfacción usuario'),
('Encuesta calidad servicio general'),
('Encuesta satisfacción medicos')

INSERT INTO `preguntas` (`titulo`, `descripcion`, `tipo`, `valoracion`, `encuesta_id`) VALUES
-- Preguntas para "Satisfacción usuario" (id: 1)
('¿Cómo calificaría su experiencia con nuestro servicio?', 'Valore del 1 al 5', 'valoracion', 5, 1),
('¿Le resultó fácil acceder a nuestros servicios?', 'Responda sí o no', 'booleano', NULL, 1),
('¿Qué aspecto cree que podríamos mejorar?', 'Explique brevemente', 'texto', NULL, 1),

-- Preguntas para "Calidad servicio general" (id: 2)
('¿Cómo calificaría la limpieza y el ambiente de nuestras instalaciones?', 'Valore del 1 al 5', 'valoracion', 5, 2),
('¿Recibió la información que necesitaba de manera clara?', 'Seleccione sí o no', 'booleano', NULL, 2),
('¿Cuánto tiempo esperó para ser atendido?', 'Escriba en minutos', 'texto', NULL, 2),

-- Preguntas para "Encuesta satisfacción médicos" (id: 3)
('¿Cómo calificaría la atención del personal médico?', 'Valore del 1 al 5', 'valoracion', 5, 3),
('¿El médico explicó claramente su diagnóstico y tratamiento?', 'Seleccione sí o no', 'booleano', NULL, 3),
('¿Recomendaría este servicio médico a otras personas?', 'Seleccione sí o no', 'booleano', NULL, 3);
