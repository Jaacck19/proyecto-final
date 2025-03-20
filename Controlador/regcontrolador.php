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
        try {
            $database = new Database();
            $db = $database->getConnection();
            $usuario = new Usuario($db);

            $usuario->nombre = $nombre;
            $usuario->apellido = $apellido;
            $usuario->email = $email;
            $usuario->contra = password_hash($password, PASSWORD_DEFAULT);
            $usuario->numerocel = $numero_cel;

            if ($usuario->crearUsuario()) {
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo "<script>
                    Swal.fire({
                        title: 'Cave Location',
                        text: 'Usuario creado exitosamente.',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        window.location.href = '../html/inicios.html';
                    });
                </script>";
                exit;
            } else {
                throw new Exception("No se pudo registrar el usuario. Intente nuevamente.");
            }
        } catch (Exception $e) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                Swal.fire({
                    title: 'Cave Location',
                    text: 'Error al registrar usuario: " . addslashes($e->getMessage()) . "',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    window.location.href = '../html/Registro.html';
                });
            </script>";
        }
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Cave Location',
                text: 'Todos los campos son obligatorios.',
                icon: 'warning',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                window.location.href = '../html/Registro.html';
            });
        </script>";
    }
}

if (isset($_SESSION['user_id'])) {
    echo '<a href="cerrarsesion.php" style="text-decoration: none; color: black;">Cerrar sesión</a>';
}
?>
