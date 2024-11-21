CREATE DATABASE SISTEMACAMPOALQUILER;

USE SISTEMACAMPOALQUILER;

-- Tabla Persona
CREATE TABLE personas (
    idpersona INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    nrodocumento 	CHAR(8) 		NOT NULL,
	create_at	DATETIME	NOT NULL DEFAULT NOW(),
    inactive_at 	DATETIME NULL,
    CONSTRAINT uk_nrodocumento_persona UNIQUE (nrodocumento)
) ENGINE = INNODB;

-- Tabla Usuarios
CREATE TABLE usuarios (
    idusuario INT AUTO_INCREMENT PRIMARY KEY,
    idpersona INT NOT NULL,
    nomuser VARCHAR(100) NOT NULL,  -- Cambiado de 'email' a 'nomuser'
    passuser VARCHAR(255) NOT NULL,  -- Cambiado de 'contraseña' a 'passuser'
    rol ENUM('administrador', 'cliente'),
    inactive_at DATETIME NULL,
    CONSTRAINT fk_usuarios_persona FOREIGN KEY (idpersona) REFERENCES personas(idpersona),
    CONSTRAINT uk_idpersona_usuario UNIQUE (idpersona),
    CONSTRAINT uk_nomuser_usuario UNIQUE (nomuser)  -- Cambiado de 'email' a 'nomuser'
) ENGINE = INNODB;

-- Tabla Productos
CREATE TABLE productos (
    idproducto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    cantidad INT NOT NULL, -- Campo para almacenar la cantidad
    imagenProducto VARCHAR(255), -- Campo para almacenar la ruta de la imagen
    estado ENUM('activo', 'inactivo') NOT NULL DEFAULT 'activo',
    create_at DATETIME	NOT NULL DEFAULT NOW()
) ENGINE = INNODB;


-- Tabla Servicios
CREATE TABLE servicios (
    idservicio INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    costo DECIMAL(10, 2) NOT NULL,
    estado ENUM('activo', 'inactivo') NOT NULL DEFAULT 'activo',
    create_at DATETIME	NOT NULL DEFAULT NOW()
) ENGINE = INNODB;

CREATE TABLE complejos_deportivos (
    idcomplejo INT AUTO_INCREMENT PRIMARY KEY,
    nombreComplejo VARCHAR(100) NOT NULL,
    direccion VARCHAR(100) NOT NULL,
    descripcion TEXT DEFAULT NULL
) ENGINE = INNODB;


/*-- Tabla Métodos de Pago
CREATE TABLE metodosPago (
    idmetodoPago INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
) ENGINE = INNODB;

-- Tabla Pagos
CREATE TABLE pagos (
    idpago INT AUTO_INCREMENT PRIMARY KEY,
    idreserva INT,
    monto DECIMAL(10, 2) NOT NULL,
    fechaPago DATE NOT NULL,
    idmetodoPago INT,
    CONSTRAINT fk_pagos_reserva FOREIGN KEY (idreserva) REFERENCES reservas(idreserva),
    CONSTRAINT fk_pagos_metodoPago FOREIGN KEY (idmetodoPago) REFERENCES metodosPago(idmetodoPago)
) ENGINE = INNODB;
*/
CREATE TABLE campos (
    idcampo INT AUTO_INCREMENT PRIMARY KEY,
    idcomplejo INT NOT NULL,
    tipoDeporte VARCHAR(50) NOT NULL,
    nombreCampo VARCHAR(100) NOT NULL,
    capacidad INT NOT NULL,
    precioHora DECIMAL(10, 2) NOT NULL,
    imagenCampo VARCHAR(255) DEFAULT NULL,
    estado ENUM('activo', 'inactivo') NOT NULL DEFAULT 'activo',
    FOREIGN KEY (idcomplejo) REFERENCES complejos_deportivos(idcomplejo)
) ENGINE = INNODB;

CREATE TABLE reservas (
    idreserva INT AUTO_INCREMENT PRIMARY KEY,
    idpersona INT,
    idcampo INT NOT NULL,
    fechaInicio DATE NOT NULL,
    horaInicio TIME NOT NULL,
    horaReservar INT NOT NULL,
    fechayHoraFin DATETIME NOT NULL,
    precioReservacion DECIMAL(10, 2) NOT NULL,
    montototal DECIMAL(10, 2) NOT NULL,
    estado ENUM('confirmada', 'cancelada', 'pendiente') NOT NULL DEFAULT 'pendiente',
    create_at DATETIME NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_reservas_persona FOREIGN KEY (idpersona) REFERENCES personas(idpersona),
    CONSTRAINT fk_reservas_campo FOREIGN KEY (idcampo) REFERENCES campos(idcampo)
) ENGINE = INNODB;

CREATE TABLE detalle_reserva_productos (
    iddetalle INT AUTO_INCREMENT PRIMARY KEY,
    idreserva INT NOT NULL,
    idproducto INT NOT NULL,
    cantidad INT NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (idreserva) REFERENCES reservas(idreserva),
    FOREIGN KEY (idproducto) REFERENCES productos(idproducto)
) ENGINE = INNODB;

CREATE TABLE detalle_reserva_servicios (
    iddetalle INT AUTO_INCREMENT PRIMARY KEY,
    idreserva INT NOT NULL,
    idservicio INT NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (idreserva) REFERENCES reservas(idreserva),
    FOREIGN KEY (idservicio) REFERENCES servicios(idservicio)
) ENGINE = INNODB;


-- Consultas para verificar datos
SELECT * FROM personas;
SELECT * FROM productos;
SELECT * FROM campos;
SELECT * FROM servicios;
SELECT * FROM usuarios;