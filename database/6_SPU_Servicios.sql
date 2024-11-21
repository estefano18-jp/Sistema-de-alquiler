USE SISTEMACAMPOALQUILER;

-- Procedimiento registrar Servicios
DELIMITER $$
CREATE PROCEDURE registrar_servicio (
    IN p_nombre VARCHAR(100),
    IN p_costo DECIMAL(10, 2)
)
BEGIN
    INSERT INTO servicios (nombre, costo, estado)
    VALUES (p_nombre, p_costo, 'activo');
END $$
DELIMITER ;

-- Procedimiento listar Servicios
DELIMITER $$
CREATE PROCEDURE listar_servicios ()
BEGIN
    SELECT * FROM servicios;
END $$
DELIMITER ;

-- Procedimiento actualizar Servicios
DELIMITER $$
CREATE PROCEDURE actualizar_servicio (
    IN p_idservicio INT,
    IN p_nombre VARCHAR(100),
    IN p_costo DECIMAL(10, 2),
    IN p_estado ENUM('activo', 'inactivo')
)
BEGIN
    UPDATE servicios
    SET nombre = p_nombre, costo = p_costo, estado = p_estado
    WHERE idservicio = p_idservicio;
END $$
DELIMITER ;

-- Procedimiento eliminar Servicios
DELIMITER $$
CREATE PROCEDURE eliminar_servicio (
    IN p_idservicio INT
)
BEGIN
    DELETE FROM servicios WHERE idservicio = p_idservicio;
END $$ 
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE mostrar_servicios()
BEGIN
    SELECT nombre
    FROM servicios
    WHERE estado = 'activo';
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE mostrar_detalles_servicios(IN nombre_servicio VARCHAR(100))
BEGIN
    SELECT
        nombre,
        costo,
        costo AS total
    FROM servicios
    WHERE nombre = nombre_servicio AND estado = 'activo';
END $$
DELIMITER ;

CALL mostrar_detalles_servicios('Animador');
CALL mostrar_servicios();

-- ---------------------

CALL registrar_servicio('Animador', 40.00);
CALL registrar_servicio('Médico', 30.00);
CALL registrar_servicio('Seguro Deportivo', 30.00);
CALL registrar_servicio('Árbitro', 25.00);
CALL registrar_servicio('Entrenador', 60.00);
CALL registrar_servicio('Personal de Seguridad', 50.00);

CALL listar_servicios();