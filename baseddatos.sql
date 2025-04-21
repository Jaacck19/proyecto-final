CREATE DATABASE IF NOT EXISTS reserva;
USE reserva;

-- Tabla usuarios con contraseñas hasheadas
CREATE TABLE usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL, 
    numerocel VARCHAR(50),
    rol VARCHAR(20) NOT NULL DEFAULT 'usuario'
);
-- Tabla espacios de parqueo
CREATE TABLE espacios_parqueo (
    id_espacio INT PRIMARY KEY AUTO_INCREMENT,
    numero_espacio VARCHAR(10) UNIQUE NOT NULL
);

-- Tabla centro comercial
CREATE TABLE centro_comercial (
    id_centro_comercial INT PRIMARY KEY AUTO_INCREMENT,
    nombrecentro VARCHAR(100) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    capacidad_total INT NOT NULL,
    horario_apertura TIME NOT NULL,
    telefono VARCHAR(20),
    email VARCHAR(100)
);

-- Tabla reservas modificada para usar id_usuario en lugar de nombre
CREATE TABLE reservas (
    id_reserva INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
	nombre VARCHAR(100) NOT NULL,
    fecha_inicio DATETIME NOT NULL,
    fecha_fin DATETIME,
    placa VARCHAR(100) NOT NULL,
    centro_comercial VARCHAR(100) NOT NULL,
    tipo_vehiculo VARCHAR(100) NOT NULL
);

-- Tabla precios
CREATE TABLE precios (
    id_precio INT PRIMARY KEY AUTO_INCREMENT,
    tarifa_hora DECIMAL(10,2) NOT NULL,
    tarifa_dia DECIMAL(10,2) NOT NULL,
    reserva DECIMAL(10,2) NOT NULL
);

-- Insertar espacios de parqueo (solo los primeros 10 para ejemplo)
INSERT INTO espacios_parqueo (numero_espacio)
VALUES 
    ('ESP001'), ('ESP002'), ('ESP003'), ('ESP004'), ('ESP005'),
    ('ESP006'), ('ESP007'), ('ESP008'), ('ESP009'), ('ESP010');

-- Insertar usuario administrador con contraseña hasheada
-- La contraseña es 'admin123' hasheada
INSERT INTO usuarios (nombre, apellido, email, contrasena, numerocel, rol)
VALUES ('Admin', 'Sistema', 'admin@sistema.com', '$2y$10$mV2BEVSglWpBohjGUvfZhu.CJ0Jk7nN12M.CHB7FpVdlT9O9zaACu', '1234567890', 'admin');
