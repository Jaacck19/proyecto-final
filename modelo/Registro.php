<?php
class Usuario {
    private $conn;
    private $table = "usuarios";
    
    public $id_usuario;
    public $nombre;
    public $apellido;
    public $email;
    public $contrasena; // Asegúrate de que coincida con la BD
    public $numerocel;

    // Constructor con conexión a la base de datos
    public function __construct($db) {
        if (!$db) {
            throw new Exception("Error: Conexión no válida.");
        }
        $this->conn = $db;
    }

    // Método para crear usuario
    public function crearUsuario() {
        try {
            // Verificar si el usuario ya existe
            if ($this->validarUsuario()) {
                echo "Error: El usuario ya existe.";
                return false;
            }

            // Consulta para insertar usuario
            $query = "INSERT INTO " . $this->table . " (nombre, apellido, email, contrasena, numerocel) 
                      VALUES (:nombre, :apellido, :email, :contrasena, :numerocel)";
            $stmt = $this->conn->prepare($query);

            // Sanitizar y encriptar datos
            $this->nombre = htmlspecialchars(strip_tags($this->nombre));
            $this->apellido = htmlspecialchars(strip_tags($this->apellido));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->contrasena = password_hash($this->contrasena, PASSWORD_BCRYPT); // Encriptar contraseña
            $this->numerocel = htmlspecialchars(strip_tags($this->numerocel));

            // Vincular parámetros
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':apellido', $this->apellido);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':contrasena', $this->contrasena); // Asegúrate de que coincida con la BD
            $stmt->bindParam(':numerocel', $this->numerocel);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo "Usuario creado exitosamente.";
                return true;
            }
        } catch (PDOException $e) {
            echo "Error al crear el usuario: " . $e->getMessage();
        }
        return false;
    }

    // Método para validar si el usuario ya existe
    public function validarUsuario() {
        try {
            $query = "SELECT id_usuario FROM " . $this->table . " WHERE email=:email OR nombre=:nombre LIMIT 1";
            $stmt = $this->conn->prepare($query);

            // Sanitizar datos
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->nombre = htmlspecialchars(strip_tags($this->nombre));

            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error al validar usuario: " . $e->getMessage();
            return false;
        }
    }
}
?>
