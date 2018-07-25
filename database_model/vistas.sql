CREATE VIEW `vista_doctores_disponibles` AS (
	SELECT d.id, d.nombres, d.apellidos, d.identificacion, d.registro_medico, d.numero_celular, d.email, disp.traccar_id
	FROM usuarios d
	INNER JOIN dispositivos disp
	ON disp.id = d.dispositivo_id
	WHERE ( SELECT count(id) FROM atenciones a WHERE a.doctor_id = d.id AND a.estado IN (1,2) ) = 0
	AND d.tipo = "Doctor"
);


SELECT d.id, d.nombres, d.apellidos, d.identificacion, d.registro_medico, d.numero_celular, d.email, disp.traccar_id
FROM usuarios d
INNER JOIN dispositivos disp
ON disp.id = d.dispositivo_id
WHERE ( SELECT count(id) FROM atenciones a WHERE a.doctor_id = d.id AND a.estado IN (1,2) ) = 0
AND d.tipo = "Doctor"