USE SISTEMACAMPOALQUILER;

DELIMITER $$
CREATE PROCEDURE registrar_Complejo (
    IN p_nombreComplejo VARCHAR(100),
    IN p_direccion VARCHAR(100),
    IN p_descripcion TEXT
)
BEGIN
    INSERT INTO complejos_deportivos (nombreComplejo, direccion, descripcion)
    VALUES (p_nombreComplejo, p_direccion, p_descripcion);
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE actualizar_Complejo (
    IN p_idcomplejo INT,
    IN p_nombreComplejo VARCHAR(100),
    IN p_direccion VARCHAR(100),
    IN p_descripcion TEXT
)
BEGIN
    UPDATE complejos_deportivos
    SET nombreComplejo = p_nombreComplejo,
        direccion = p_direccion,
        descripcion = p_descripcion
    WHERE idcomplejo = p_idcomplejo;
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE listar_Complejo()
BEGIN
    SELECT 
        idcomplejo, 
        nombreComplejo, 
        direccion, 
        descripcion
    FROM 
        complejos_deportivos;
END $$
DELIMITER ;

-- Procedimiento para ver (obtener) un complejo deportivo por su ID
DELIMITER $$
CREATE PROCEDURE ver_Complejo (
    IN p_idcomplejo INT
)
BEGIN
    SELECT 
        idcomplejo, 
        nombreComplejo, 
        direccion, 
        descripcion
    FROM 
        complejos_deportivos
    WHERE 
        idcomplejo = p_idcomplejo;
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE eliminar_Complejo (
    IN p_idcomplejo INT
)
BEGIN
    -- Comenzar una transacción para asegurar la integridad de los datos
    START TRANSACTION;
    
    -- Eliminar todos los campos asociados al complejo
    DELETE FROM campos WHERE idcomplejo = p_idcomplejo;
    
    -- Eliminar el complejo deportivo
    DELETE FROM complejos_deportivos WHERE idcomplejo = p_idcomplejo;
    
    -- Confirmar la transacción
    COMMIT;
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE cambiar_Estado_Campo (
    IN p_idcampo INT,
    IN p_estado ENUM('activo', 'inactivo')
)
BEGIN
    UPDATE campos
    SET estado = p_estado
    WHERE idcampo = p_idcampo;
END $$
DELIMITER ;




-- Registrar Complejos Deportivos
CALL registrar_Complejo('San Martín', 'Av. San Martín 123, Chincha Alta', 'Complejo moderno con diversas áreas deportivas.');
CALL registrar_Complejo('La Estrella', 'Av. Estrella 456, Grocio Prado', 'Centro deportivo de gran capacidad.');
CALL registrar_Complejo('El Sol', 'Av. Sol Radiante 789, Pueblo Nuevo', 'Instalaciones deportivas con amplio estacionamiento.');

