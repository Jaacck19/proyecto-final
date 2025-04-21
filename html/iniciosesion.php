<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../Controlador/usuariocontrolador.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['txemail']) && isset($_POST['txpassword'])) {
        $email = $_POST['txemail'];
        $contrasena = $_POST['txpassword'];

        $controlador = new UsuarioControlador();
        $rol = $controlador->iniciarSesion($email, $contrasena);

        if ($rol) {
            if ($rol === 'admin') {
                header("Location: usuarios.php");
                exit();
            } elseif ($rol === 'usuario') {
                header("Location: reserva.html");
                exit();
            }
        } else {
            echo "<script>alert('Credenciales incorrectas.');</script>";
        }
    } else {
        echo "<script>alert('Por favor, complete todos los campos.');</script>";
    }
}
?>
