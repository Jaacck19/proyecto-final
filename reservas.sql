create database reserva;
use reserva;
CREATE TABLE usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP);
    
ALTER TABLE usuarios 
 ADD COLUMN contraseña varchar(100) not null,
 ADD COLUMN numerocel varchar(50);
 
 ALTER TABLE usuarios 
 DROP COLUMN fecha_registro;

CREATE TABLE espacios_parqueo (
    id_espacio INT PRIMARY KEY AUTO_INCREMENT,
    numero_espacio VARCHAR(10) UNIQUE NOT NULL);

CREATE TABLE reservas (
    id_reservass INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    id_espacio INT,
    fecha_inicio DATETIME NOT NULL,
    fecha_fin DATETIME,
    tarifa_hora DECIMAL(10,2) NOT NULL,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)on delete cascade,
    FOREIGN KEY (id_espacio) REFERENCES espacios_parqueo(id_espacio)on delete cascade);
    
   ALTER TABLE  reservas 
	ADD COLUMN moto varchar(100) NOT NULL;
    
    CREATE TABLE precios (
    id_precio INT PRIMARY KEY AUTO_INCREMENT,
    tarifa_hora DECIMAL(10,8) NOT NULL,
    tarifa_dia DECIMAL(10,8) NOT NULL,
	reserva DECIMAL(10,8) NOT NULL);

CREATE TABLE centro_comercial (
    id_centro_comercial INT PRIMARY KEY AUTO_INCREMENT,
    nombrecentro VARCHAR(100) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    capacidad_total INT NOT NULL,
    horario_apertura TIME NOT NULL,
    telefono VARCHAR(20),
    email VARCHAR(100));