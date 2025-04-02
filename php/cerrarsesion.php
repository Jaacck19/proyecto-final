<?php
session_start();

// Verificar si la sesión está activa antes de intentar destruirla
if (session_status() === PHP_SESSION_ACTIVE) {
    session_unset(); // Eliminar todas las variables de sesión
    session_destroy(); // Destruir la sesión
}

// Redirigir al inicio y asegurarse de que no haya salida previa
header("Location: ../index.html");
exit();
?>
