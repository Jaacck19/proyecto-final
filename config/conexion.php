<?php
class Database {
    private $host = "localhost";
    private $db_name = "reserva";
    private $user_name = "root";
    private $password = "";
    private $port = "3306";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};port={$this->port};dbname={$this->db_name}",
                $this->user_name,
                $this->password,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
            $this->conn->exec("SET NAMES utf8");
        } catch (PDOException $exception) {
            die("Error en la conexión a la base de datos: " . $exception->getMessage());
        }
        return $this->conn;
    }
}
?>
