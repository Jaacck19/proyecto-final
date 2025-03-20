<?php
session_start();
require_once('../config/conexion.php');
require_once('../modelo/registro.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['txtnombre'] ?? '';
    $apellido = $_POST['txtapellido'] ?? '';
    $email = $_POST['txemail'] ?? '';
    $password = $_POST['txtpassword'] ?? '';
    $numero_cel = $_POST['txtnumero'] ?? '';

    if (!empty($nombre) && !empty($apellido) && !empty($email) && !empty($password) && !empty($numero_cel)) {
        $database = new Database();
        $db = $database->getConnection();
        $usuario = new Usuario($db);

        $usuario->nombre = $nombre;
        $usuario->apellido = $apellido;
        $usuario->email = $email;
        $usuario->contra = password_hash($password, PASSWORD_DEFAULT);
        $usuario->numerocel = $numero_cel;

        if ($usuario->crearUsuario()) {
            header("Location: ../html/iniciosesion.php");
            exit;
        } else {
            echo "Error al registrar usuario.";
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
}

if (isset($_SESSION['user_id'])) {
    echo '<a href="cerrarsesion.php" style="text-decoration: none; color: black;">Cerrar sesión</a>';
}
?>
