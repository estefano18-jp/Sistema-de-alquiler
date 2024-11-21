USE SISTEMACAMPOALQUILER;

DELIMITER $$
CREATE PROCEDURE registrar_reserva (
    IN p_idpersona INT,
    IN p_idcampo INT,
    IN p_fechaInicio DATE,
    IN p_horaInicio VARCHAR(5),
    IN p_horaReservar INT,
    OUT p_idreserva INT
)
BEGIN
    DECLARE v_precioHoraCampo DECIMAL(10, 2);
    DECLARE v_precioReservacion DECIMAL(10,2);
    DECLARE v_fechaHoraInicio DATETIME;
    DECLARE v_fechaHoraFin DATETIME;

    -- Obtener el precio por hora del campo
    SELECT precioHora INTO v_precioHoraCampo
    FROM campos
    WHERE idcampo = p_idcampo AND estado = 'activo';

    -- Calcular el precio de la reservación
    SET v_precioReservacion = v_precioHoraCampo * p_horaReservar;

    -- Concatenar fecha y hora de inicio
    SET v_fechaHoraInicio = CONCAT(p_fechaInicio, ' ', p_horaInicio);

    -- Calcular la fecha y hora de fin
    SET v_fechaHoraFin = DATE_ADD(v_fechaHoraInicio, INTERVAL p_horaReservar HOUR);

    -- Insertar la reserva en la tabla reservas
    INSERT INTO reservas (
        idpersona, idcampo, fechaInicio, horaInicio, horaReservar, fechayHoraFin, precioReservacion, montototal, estado
    ) 
    VALUES (
        p_idpersona, p_idcampo, p_fechaInicio, p_horaInicio, p_horaReservar, v_fechaHoraFin, v_precioReservacion, v_precioReservacion, 'pendiente'
    );

    -- Obtener el idreserva generado
    SET p_idreserva = LAST_INSERT_ID();
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE listar_reserva()
BEGIN
    SELECT 
        r.idreserva,
        CONCAT(p.nombre, ' ', p.apellido) AS nombre_completo,
        p.nroDocumento,
        cd.nombreComplejo AS nombre_complejo,
        c.tipoDeporte,
        c.nombreCampo AS nombre_campo,
        r.fechaInicio,
        DATE_FORMAT(r.horaInicio, '%h:%i %p') AS horaInicio,
        DATE_FORMAT(r.fechayHoraFin, '%d-%m-%Y %h:%i %p') AS fechaFin,
        r.montototal,
        r.estado
    FROM reservas r
    JOIN personas p ON r.idpersona = p.idpersona
    JOIN campos c ON r.idcampo = c.idcampo
    JOIN complejos_deportivos cd ON c.idcomplejo = cd.idcomplejo
    ORDER BY r.idreserva ASC;
END $$
DELIMITER ;


-- ------------------
DELIMITER $$
CREATE PROCEDURE eliminar_reserva(
    IN p_idreserva INT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SELECT 'Error al eliminar la reserva.' AS mensaje;
    END;
    START TRANSACTION;
    
    -- Eliminar detalles de productos asociados a la reserva
    DELETE FROM detalle_reserva_productos WHERE idreserva = p_idreserva;
    
    -- Eliminar detalles de servicios asociados a la reserva
    DELETE FROM detalle_reserva_servicios WHERE idreserva = p_idreserva;
    
    -- Eliminar la reserva
    DELETE FROM reservas WHERE idreserva = p_idreserva;
    COMMIT;
    SELECT 'Reserva eliminada correctamente.' AS mensaje;
END $$
DELIMITER ;

-- ------------------

DELIMITER $$
CREATE PROCEDURE obtener_horas_ocupadas(
    IN p_idcampo INT,
    IN p_fecha DATE
)
BEGIN
    SELECT
        horaInicio,
        horaReservar
    FROM
        reservas
    WHERE
        idcampo = p_idcampo
        AND fechaInicio = p_fecha
        AND estado IN ('confirmada', 'pendiente'); -- Excluir reservas canceladas
END $$
DELIMITER ;
-- --------------------
DELIMITER $$
CREATE PROCEDURE obtener_tipos_de_deporte_por_complejo(
    IN p_idcomplejo INT
)
BEGIN
    SELECT DISTINCT tipoDeporte
    FROM campos
    WHERE idcomplejo = p_idcomplejo AND estado = 'activo';
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE obtener_campos_por_complejo_y_deporte(
    IN p_idcomplejo INT,
    IN p_tipoDeporte VARCHAR(50)
)
BEGIN
    SELECT idcampo, nombreCampo
    FROM campos
    WHERE idcomplejo = p_idcomplejo AND tipoDeporte = p_tipoDeporte AND estado = 'activo';
END $$
DELIMITER ;
-- --------------------
-- ---------------------
DELIMITER $$
CREATE PROCEDURE listar_reserva_por_persona(
    IN p_idpersona INT
)
BEGIN
    SELECT 
        r.idreserva,
        CONCAT(p.nombre, ' ', p.apellido) AS nombre_completo,
        p.nrodocumento,
        cd.nombreComplejo AS nombre_complejo,
        c.tipoDeporte,
        c.nombreCampo AS nombre_campo,
        r.fechaInicio,
        DATE_FORMAT(r.horaInicio, '%h:%i %p') AS horaInicio,
        DATE_FORMAT(r.fechayHoraFin, '%d-%m-%Y %h:%i %p') AS fechaFin,
        r.montototal,
        r.estado
    FROM reservas r
    JOIN personas p ON r.idpersona = p.idpersona
    JOIN campos c ON r.idcampo = c.idcampo
    JOIN complejos_deportivos cd ON c.idcomplejo = cd.idcomplejo
    WHERE p.idpersona = p_idpersona
    ORDER BY r.idreserva DESC;
END $$
DELIMITER ;




SELECT * FROM reservas;


