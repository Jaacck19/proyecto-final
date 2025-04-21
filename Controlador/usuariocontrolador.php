<?php
require_once('../modelo/usuario.php');

class UsuarioControlador {
    private $usuario;

    public function __construct() {
        $this->usuario = new Ini();
    }

    public function iniciarSesion($email, $password) {
        // Llamada al método verificarCredenciales que devuelve el rol si las credenciales son correctas
        $rol = $this->usuario->verificarCredenciales($email, $password);

        if ($rol) {
            return $rol; // Retorna el rol si las credenciales son correctas
        } else {
            return false; // Credenciales incorrectas
        }
    }
}
?>