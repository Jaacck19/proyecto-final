<?php
// config/conexion.php

class Conexion {
    private $host = 'localhost';
    private $usuario = 'root';
    private $contrasena = '';
    private $base_datos = 'reserva';
    private $conexion;
    
    public function __construct() {
        $this->conexion = new mysqli(
            $this->host,
            $this->usuario,
            $this->contrasena,
            $this->base_datos
        );
        
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
        
        $this->conexion->set_charset("utf8");
    }
    
    public function getConexion() {
        return $this->conexion;
    }
    
    public function cerrarConexion() {
        $this->conexion->close();
    }
}
class Database {
    // Atributos privados para la conexión
    private $host = "localhost";
    private $user_name = "root";
    private $db_name = "reserva";
    private $password = "";

    // Objeto de conexión
    public $conn;

    // Función para obtener la conexión a la base de datos
    public function getConnection() {
        $this->conn = null;

        try {
           $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->user_name, $this->password);
            $this->conn->exec("set names utf8");

            if($this->conn) {
            }
        } catch(PDOException $exception) {
            echo "Error en la conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
$database = new Database();
$database->getConnection();

?>