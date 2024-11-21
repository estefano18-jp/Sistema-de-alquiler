USE SISTEMACAMPOALQUILER;

DELIMITER $$
CREATE PROCEDURE spu_registrar_persona(
    IN _nombre VARCHAR(100),
    IN _apellido VARCHAR(100),
    IN _telefono VARCHAR(15),
    IN _nrodocumento CHAR(8)
)
BEGIN
    INSERT INTO personas (nombre, apellido, telefono, nrodocumento) VALUES
        (_nombre, _apellido, NULLIF(_telefono, ''), _nrodocumento);
    SELECT LAST_INSERT_ID() AS idpersona;
END $$
DELIMITER ;

-- PROCEDIMIENTO spu_usuarios_buscar_dni ---------
DELIMITER $$
CREATE PROCEDURE spu_usuarios_buscar_dni(IN _nrodocumento CHAR(8))
BEGIN
    -- Existe USUARIO + Existe PERSONA        = 1
    -- Existe PERSONA, No Existe Usuario      = 2
    -- No Existe PERSONA, No existe USUARIO   = 3
    SELECT 
        PER.idpersona,
        USU.idusuario,
        PER.apellido, 
        PER.nombre, 
        PER.telefono
    FROM personas PER
    LEFT JOIN usuarios USU ON USU.idpersona = PER.idpersona
    WHERE PER.nrodocumento = _nrodocumento;
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE spu_actualizar_persona(
    IN p_idpersona INT,
    IN p_nombre VARCHAR(100),
    IN p_apellido VARCHAR(100),
    IN p_telefono VARCHAR(20),
    IN p_nroDocumento VARCHAR(50)
)
BEGIN
    UPDATE personas
    SET nombre = p_nombre, apellido = p_apellido, telefono = p_telefono, nroDocumento = p_nroDocumento
    WHERE idpersona = p_idpersona;
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE spu_listar_persona()
BEGIN
    SELECT * FROM personas;
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE spu_eliminar_persona(
    IN p_idpersona INT
)
BEGIN
    DELETE FROM personas WHERE idpersona = p_idpersona;
END $$
DELIMITER ;

CALL spu_listar_persona();

-- Llamadas a procedimientos
CALL spu_registrar_persona('Jose', 'Marques Matrix', '956111111', '42349078');
CALL spu_registrar_persona('Carmen','Ortega Bautista', '978222222', '47689321');

CALL spu_usuarios_buscar_dni('42345678');
CALL spu_listar_persona();

SELECT * FROM personas;
SELECT * FROM usuarios;