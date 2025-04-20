<?php
// config/conexion.php

class Database {
    // Parámetros de conexión
    private $host = 'localhost';
    private $usuario = 'root';
    private $contrasena = '';
    private $base_datos = 'reserva';

    // Objeto de conexión PDO
    private $conexion;

    // Constructor: establece la conexión
    public function __construct() {
        try {
            $this->conexion = new PDO(
                "mysql:host={$this->host};dbname={$this->base_datos}",
                $this->usuario,
                $this->contrasena
            );
            $this->conexion->exec("set names utf8");
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    // Devuelve la conexión activa
    public function getConnection() {
        return $this->conexion;
    }

    // Cierra la conexión
    public function cerrarConexion() {
        $this->conexion = null;
    }
}

// Ejemplo de uso:
// $db = new Database();
// $conexion = $db->getConnection();
?>
