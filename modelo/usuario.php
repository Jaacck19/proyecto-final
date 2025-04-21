<?php
class Ini {
    private $conexion;

    public function __construct() {
        // Configuración de la conexión a la base de datos
        $this->conexion = new mysqli("localhost", "root", "", "reserva");

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function verificarCredenciales($email, $password) {
        $query = "SELECT contrasena, rol FROM usuarios WHERE email = ?";
        $stmt = $this->conexion->prepare($query);

        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $this->conexion->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();

            // Verificar la contraseña encriptada
            echo "Contraseña desde el controlador: " . $password . "<br>";
            echo "Contraseña en la base de datos: " . $usuario['contrasena'] . "<br>";

            if (password_verify($password, $usuario['contrasena'])) {
                return $usuario['rol']; // Retorna el rol del usuario si la contraseña es correcta
            } else {
                return false; // Contraseña incorrecta
            }
        } else {
            return false; // Usuario no encontrado
        }
    }
}

?>