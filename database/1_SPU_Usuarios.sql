USE SISTEMACAMPOALQUILER;

-- Procedimiento para login de usuario
DELIMITER $$
CREATE PROCEDURE spu_usuarios_login(
    IN p_nomuser VARCHAR(100),
    IN p_passuser VARCHAR(100)
)
BEGIN
    SELECT u.idusuario, p.nombre, p.apellido, u.rol, u.passuser
    FROM usuarios u
    INNER JOIN personas p ON u.idpersona = p.idpersona
    WHERE u.nomuser = p_nomuser
    LIMIT 1;
END $$
DELIMITER ;


-- Procedimiento para registrar un usuario (general)
DELIMITER $$
CREATE PROCEDURE spu_usuarios_registrar(
    IN _idpersona INT,
    IN _nomuser VARCHAR(100),
    IN _passuser VARCHAR(255),
    IN _rol ENUM('administrador', 'cliente')
)
BEGIN
    INSERT INTO usuarios (idpersona, nomuser, passuser, rol) VALUES
        (_idpersona, _nomuser, _passuser, _rol);
    SELECT @@last_insert_id AS idusuario;
END $$
DELIMITER ;

-- Procedimiento para registrar un cliente
DELIMITER $$
CREATE PROCEDURE spu_usuarios_registrar_cliente(
    IN _idpersona INT,
    IN _nomuser VARCHAR(100),
    IN _passuser VARCHAR(255)
)
BEGIN
    INSERT INTO usuarios (idpersona, nomuser, passuser, rol) VALUES
        (_idpersona, _nomuser, _passuser, 'cliente');
    SELECT @@last_insert_id AS idusuario;
END $$
DELIMITER ;

-- Ejemplo de inserciones
INSERT INTO personas (apellido, nombre, telefono, nrodocumento) VALUES
    ('Alvarez', 'Samil', '956123456', '42345678'),
    ('Olivos', 'Edu', '956987654', '47654321');

INSERT INTO usuarios (idpersona, nomuser, passuser, rol) VALUES 
    (1, 'samil', '', 'administrador'),
    (2, 'edu', '', 'administrador');

-- Actualización de contraseñas
UPDATE usuarios SET passuser = '$2y$10$t3ZDuZSkKyIjocOXBcB.4un5Zzo0RGaFbWj3EWYcosPQG80IIbXJ.' WHERE idusuario = 1; -- SISTEMA2024 (encriptado)
UPDATE usuarios SET passuser = '$2y$10$gVtkRf.23.pqQDzwxGdx6eozL.5QoxFOfQYb9bZLIqr5ewdPFDmKK' WHERE idusuario = 2; -- SISTEMA2024 (encriptado)

SELECT * FROM usuarios;

