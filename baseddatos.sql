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
    id_reserva INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,  -- Campo para almacenar el nombre
    fecha_inicio DATETIME NOT NULL,
    fecha_fin DATETIME,
    placa VARCHAR(100) NOT NULL,  -- Eliminado UNIQUE
    centro_comercial VARCHAR(100) NOT NULL,
    tipo_vehiculo VARCHAR(100) NOT NULL,
    
    -- Clave foránea adicional con nombre (referencia a 'nombre' en la tabla usuarios)
    CONSTRAINT fk_nombre_usuario_reserva FOREIGN KEY (nombre) REFERENCES usuarios(nombre) ON DELETE CASCADE
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

-- Insertar 100 espacios de parqueo
INSERT INTO espacios_parqueo (numero_espacio)
VALUES 
    ('ESP001'), ('ESP002'), ('ESP003'), ('ESP004'), ('ESP005'),
    ('ESP006'), ('ESP007'), ('ESP008'), ('ESP009'), ('ESP010'),
    ('ESP011'), ('ESP012'), ('ESP013'), ('ESP014'), ('ESP015'),
    ('ESP016'), ('ESP017'), ('ESP018'), ('ESP019'), ('ESP020'),
    ('ESP021'), ('ESP022'), ('ESP023'), ('ESP024'), ('ESP025'),
    ('ESP026'), ('ESP027'), ('ESP028'), ('ESP029'), ('ESP030'),
    ('ESP031'), ('ESP032'), ('ESP033'), ('ESP034'), ('ESP035'),
    ('ESP036'), ('ESP037'), ('ESP038'), ('ESP039'), ('ESP040'),
    ('ESP041'), ('ESP042'), ('ESP043'), ('ESP044'), ('ESP045'),
    ('ESP046'), ('ESP047'), ('ESP048'), ('ESP049'), ('ESP050'),
    ('ESP051'), ('ESP052'), ('ESP053'), ('ESP054'), ('ESP055'),
    ('ESP056'), ('ESP057'), ('ESP058'), ('ESP059'), ('ESP060'),
    ('ESP061'), ('ESP062'), ('ESP063'), ('ESP064'), ('ESP065'),
    ('ESP066'), ('ESP067'), ('ESP068'), ('ESP069'), ('ESP070'),
    ('ESP071'), ('ESP072'), ('ESP073'), ('ESP074'), ('ESP075'),
    ('ESP076'), ('ESP077'), ('ESP078'), ('ESP079'), ('ESP080'),
    ('ESP081'), ('ESP082'), ('ESP083'), ('ESP084'), ('ESP085'),
    ('ESP086'), ('ESP087'), ('ESP088'), ('ESP089'), ('ESP090'),
    ('ESP091'), ('ESP092'), ('ESP093'), ('ESP094'), ('ESP095'),
    ('ESP096'), ('ESP097'), ('ESP098'), ('ESP099'), ('ESP100');