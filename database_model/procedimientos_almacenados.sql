DROP PROCEDURE IF EXISTS punto_circulo;
DELIMITER $$
CREATE PROCEDURE punto_circulo(lat1 FLOAT, lng1 FLOAT, lat2 FLOAT, lng2 FLOAT, radio INT)
BEGIN
	SET @distancia = 0;
	SET @distancia = (acos(sin(radians(lat1)) * sin(radians(lat2)) + 
	cos(radians(lat1)) * cos(radians(lat2)) * 
	cos(radians(lng1) - radians(lng2))) * 6378);

	SET @distancia = @distancia * 1000;
	IF( @distancia <= radio ) THEN
		select '1' as consulta;
	ELSE
		select '0' as consulta;
	END IF;

END




call punto_circulo(-0.20171607191966104, -78.49248932150044, -0.20177373905600135, -78.49259795096555, 800);
call pruebas_variables(-0.20171607191966104, -78.49248932150044, -0.20164499382111453, -78.49253223684468, 8);