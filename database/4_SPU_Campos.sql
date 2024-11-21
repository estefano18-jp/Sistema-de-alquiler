USE SISTEMACAMPOALQUILER;

-- Procedimiento registrar Campo
DELIMITER $$
CREATE PROCEDURE registrar_Campo (
    IN p_idcomplejo INT,
    IN p_tipoDeporte VARCHAR(50),
    IN p_nombreCampo VARCHAR(100),
    IN p_capacidad INT,
    IN p_precioHora DECIMAL(10, 2),
    IN p_imagenCampo VARCHAR(255)
)
BEGIN
    INSERT INTO campos (idcomplejo, tipoDeporte, nombreCampo, capacidad, precioHora, imagenCampo, estado)
    VALUES (p_idcomplejo, p_tipoDeporte, p_nombreCampo, p_capacidad, p_precioHora, p_imagenCampo, 'activo');
END $$
DELIMITER ;

-- Procedimiento listar Campo
DELIMITER $$
CREATE PROCEDURE listar_Campo()
BEGIN
    SELECT 
        idcampo, 
        idcomplejo, 
        tipoDeporte, 
        nombreCampo, 
        capacidad, 
        precioHora, 
        imagenCampo, 
        estado
    FROM 
        campos;
END $$
DELIMITER ;


-- Procedimiento actualizar Campo
DELIMITER $$
CREATE PROCEDURE actualizar_Campo (
    IN p_idcampo INT,
    IN p_idcomplejo INT,
    IN p_tipoDeporte VARCHAR(50),
    IN p_nombreCampo VARCHAR(100),
    IN p_capacidad INT,
    IN p_precioHora DECIMAL(10, 2),
    IN p_imagenCampo VARCHAR(255),
    IN p_estado ENUM('activo', 'inactivo')
)
BEGIN
    UPDATE campos
    SET 
        idcomplejo = p_idcomplejo,
        tipoDeporte = p_tipoDeporte,
        nombreCampo = p_nombreCampo,
        capacidad = p_capacidad,
        precioHora = p_precioHora,
        imagenCampo = p_imagenCampo,
        estado = p_estado
    WHERE 
        idcampo = p_idcampo;
END $$
DELIMITER ;


-- Procedimiento eliminar Campo
DELIMITER $$
CREATE PROCEDURE eliminar_Campo (
    IN p_idcampo INT
)
BEGIN
    DECLARE rutaImagen VARCHAR(255);

    -- Obtener la ruta de la imagen del campo
    SELECT imagenCampo INTO rutaImagen FROM campos WHERE idcampo = p_idcampo;

    -- Eliminar el campo de la base de datos
    DELETE FROM campos WHERE idcampo = p_idcampo;

    -- (Opcional) Puedes manejar la eliminación del archivo de la imagen en tu aplicación utilizando 'rutaImagen'
END $$
DELIMITER ;

-- Procedimiento Ver Campo
DELIMITER $$
CREATE PROCEDURE ver_Campo (
    IN p_idcampo INT
)
BEGIN
    SELECT 
        idcampo, 
        idcomplejo, 
        tipoDeporte, 
        nombreCampo, 
        capacidad, 
        precioHora, 
        imagenCampo, 
        estado
    FROM 
        campos
    WHERE 
        idcampo = p_idcampo;
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE seleccionar_Campo (
    IN p_tipoDeporte VARCHAR(50),
    IN p_nombreCampo VARCHAR(100)
)
BEGIN
    SELECT 
        idcampo, 
        idcomplejo, 
        tipoDeporte, 
        nombreCampo, 
        capacidad, 
        precioHora, 
        imagenCampo, 
        estado
    FROM 
        campos
    WHERE 
        (p_tipoDeporte IS NULL OR tipoDeporte = p_tipoDeporte) AND
        (p_nombreCampo IS NULL OR nombreCampo LIKE CONCAT('%', p_nombreCampo, '%'));
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE listar_Campos_Por_Complejo(IN p_idcomplejo INT)
BEGIN
    SELECT 
        idcampo, 
        idcomplejo, 
        tipoDeporte, 
        nombreCampo, 
        capacidad, 
        precioHora, 
        imagenCampo, 
        estado
    FROM 
        campos
    WHERE 
        idcomplejo = p_idcomplejo;
END $$
DELIMITER ;

-- Registrar Campos para "Complejo Deportivo San Martín"
CALL registrar_Campo(1, 'Fútbol', 'Campo Fútbol San Martín', 22, 55.00, '../img/Campo_Futbol_CampoA.jpg');
CALL registrar_Campo(1, 'Voleibol', 'Cancha Voleibol San Martín', 12, 25.00, '../img/Campo_Voleibol_CampoA.jpg');
CALL registrar_Campo(1, 'Baloncesto', 'Cancha Baloncesto San Martín', 15, 35.00, '../img/Campo_Baloncesto_CampoA.jpg');
CALL registrar_Campo(1, 'Piscina', 'Piscina San Martín', 30, 50.00, '../img/Piscina_CampoA.jpg');

-- Registrar Campos para "Complejo Deportivo La Estrella"
CALL registrar_Campo(2, 'Fútbol', 'Campo Fútbol La Estrella', 20, 50.00, '../img/Campo_Futbol_CampoB.jpg');
CALL registrar_Campo(2, 'Voleibol', 'Cancha Voleibol La Estrella', 10, 22.00, '../img/Campo_Voleibol_CampoB.jpg');
CALL registrar_Campo(2, 'Baloncesto', 'Cancha Baloncesto La Estrella', 14, 30.00, '../img/Campo_Baloncesto_CampoB.jpg');
CALL registrar_Campo(2, 'Piscina', 'Piscina La Estrella', 28, 45.00, '../img/Piscina_CampoB.jpg');

-- Registrar Campos para "Complejo Deportivo El Sol"
CALL registrar_Campo(3, 'Fútbol', 'Campo Fútbol El Sol', 18, 45.00, '../img/Campo_Futbol_CampoC.jpg');
CALL registrar_Campo(3, 'Voleibol', 'Cancha Voleibol El Sol', 8, 20.00, '../img/Campo_Voleibol_CampoC.jpg');
CALL registrar_Campo(3, 'Baloncesto', 'Cancha Baloncesto El Sol', 16, 40.00, '../img/Campo_Baloncesto_CampoC.jpg');
CALL registrar_Campo(3, 'Piscina', 'Piscina El Sol', 25, 40.00, '../img/Piscina_CampoC.jpg');


SELECT * FROM campos;