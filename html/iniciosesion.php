<?php
session_start();
require_once('../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Depuración: Ver qué datos llegan desde el formulario
    var_dump($_POST);

    // Capturar datos y limpiar entrada
    $email = isset($_POST['txemail']) ? trim(htmlspecialchars($_POST['txemail'])) : '';
    $contrasena = isset($_POST['txtpassword']) ? trim($_POST['txtpassword']) : '';

    // Verificar si los campos están vacíos
    if (empty($email) || empty($contrasena)) {
        header('Location: ../html/iniciosesion.php?error=empty_fields');
        exit;
    }

    try {
        $database = new Database();
        $db = $database->getConnection();

        // Consulta para verificar el usuario
        $sql = "SELECT id_usuario, email, contrasena FROM usuarios WHERE LOWER(TRIM(email)) = LOWER(TRIM(:email))";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si el usuario existe
        if ($user_data) {
            // Verificar la contraseña
            if (password_verify($contrasena, $user_data['contrasena'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user_data['id_usuario'];
                $_SESSION['user'] = $user_data['email'];

                header('Location: ../html/reserva.html');
                exit;
            } else {
                header('Location: ../html/reserva.html');
                exit;
            }
        } else {
            header('Location: ../html/reserva.html');
            exit;
        }
    } catch (PDOException $e) {
        header('Location: ../html/reserva.html');
        exit;
    }
}
?>
