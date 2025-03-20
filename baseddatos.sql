CREATE DATABASE reserva;
USE reserva;

CREATE TABLE usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL UNIQUE,  -- Hacemos el nombre único, si se requiere
    apellido VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    contrasena VARCHAR(100) NOT NULL,  -- Cambiado de "contraseña" a "contrasena"
    numerocel VARCHAR(50)
	
);

CREATE TABLE espacios_parqueo (
    id_espacio INT PRIMARY KEY AUTO_INCREMENT,
    numero_espacio VARCHAR(10) UNIQUE NOT NULL
);

CREATE TABLE reservas (
    id_reserva INT PRIMARY KEY AUTO_INCREMENT, -- Se cambió "id_reservass" a "id_reserva"
    id_usuario INT NOT NULL,
    id_espacio INT NOT NULL,
    fecha_inicio DATETIME NOT NULL,
    fecha_fin DATETIME,
    placa VARCHAR(100) UNIQUE NOT NULL,
    centro_comercial VARCHAR(100) NOT NULL,
    tipo_vehiculo VARCHAR(100) NOT NULL,
    
    -- Claves foráneas correctas
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_espacio) REFERENCES espacios_parqueo(id_espacio) ON DELETE CASCADE
    
);

CREATE TABLE precios (
    id_precio INT PRIMARY KEY AUTO_INCREMENT,
    tarifa_hora DECIMAL(10,2) NOT NULL,  -- Reducido a DECIMAL(10,2) para precisión estándar
    tarifa_dia DECIMAL(10,2) NOT NULL,
    reserva DECIMAL(10,2) NOT NULL
);

CREATE TABLE centro_comercial (
    id_centro_comercial INT PRIMARY KEY AUTO_INCREMENT,
    nombrecentro VARCHAR(100) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    capacidad_total INT NOT NULL,
    horario_apertura TIME NOT NULL,
    telefono VARCHAR(20),
    email VARCHAR(100)
);
