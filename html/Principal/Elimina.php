<?php
require_once('../../config/conexion.php');

if (isset($_GET['id'])) {
    $idUsuario = intval($_GET['id']);

    $database = new Database();
    $db = $database->getConnection();

    $query = "DELETE FROM usuarios WHERE id_usuario = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $idUsuario);

    if ($stmt->execute()) {
        // Redirige de vuelta al listado de usuarios después de eliminar
        header("Location: ../usuarios.php");
        exit();
    } else {
        echo "Error al eliminar el usuario.";
    }
} else {
    echo "ID de usuario no proporcionado.";
}
?>
