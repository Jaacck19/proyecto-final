<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Css/estilos.css">
    <title>Veterinaria</title>
</head>
<body>
<header>
        <img src="../../img/img4.png" alt="logo">
        <h1>Confirmacion de eliminacion</h1>
    </header>
    <nav>
        <a href="../../indexx.html" style="text-decoration: none; color: black;">Inicio</a>
        <a>|</a>
        <a href="../../Html/Iniciosesion.html" style= "text-decoration: none; color: black;">Inicio sesión</a>
        <a>|</a>
        <a href="../../Html/Registromasc.html" style= "text-decoration: none; color: black;">Registro mascota</a>
        <a>|</a>
        <a href="../../Html/Masc.php" style= "text-decoration: none; color: black;">Tabla de mascotas</a>
    </nav>
<div class="message-box">
<?php
require_once('../../../config/conexion.php');
$database = new Database();
$db = $database->getConnection();

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Eliminar el usuario de la base de datos
    $query = "DELETE FROM usuario WHERE codusuario = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $user_id);

    if ($stmt->execute()) {
        echo "Usuario eliminado exitosamente. <a href='../Principal.php'>Regresar a la lista</a>";
    } else {
        echo "Error al eliminar el usuario. <a href='../Principal.php'>Regresar a la lista</a>";
    }
}else {
    echo "No se especificó el ID del usuario.";
}
?>
</div>
</body>
</html>