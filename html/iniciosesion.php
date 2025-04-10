<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: ../html/reserva.html"); // Si no es admin, lo redirige a la página de reservas
    exit();
}
session_start();
session_destroy();
header("Location: ../html/iniciosesion.php");
exit();


session_start();
require_once('../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['txemail']) ? trim(htmlspecialchars($_POST['txemail'])) : '';
    $contrasena = isset($_POST['txtpassword']) ? trim($_POST['txtpassword']) : '';

    if (empty($email) || empty($contrasena)) {
        header('Location: ../html/iniciosesion.php?error=empty_fields');
        exit;
    }

    try {
        $database = new Database();
        $db = $database->getConnection();

        // Consulta para verificar el usuario y su rol
        $sql = "SELECT id_usuario, email, contrasena, rol FROM usuarios WHERE LOWER(TRIM(email)) = LOWER(TRIM(:email))";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user_data) {
            // Verificar la contraseña
            if (password_verify($contrasena, $user_data['contrasena'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user_data['id_usuario'];
                $_SESSION['user'] = $user_data['email'];

                if ($user_data['rol'] === 'admin') {
                    $_SESSION['admin'] = true; // Guardamos que es admin
                    header('Location: ../html/usuarios.php'); // Lo enviamos a la página de actualización
                    exit;
                } else {
                    $_SESSION['admin'] = false; // No es admin
                    header('Location: ../html/reserva.html'); // Lo enviamos a la reserva
                    exit;
                }
            }
        }
        header('Location: ../html/iniciosesion.php?error=invalid_credentials');
        exit;
    } catch (PDOException $e) {
        header('Location: ../html/iniciosesion.php?error=db_error');
        exit;
    }
}
?>
