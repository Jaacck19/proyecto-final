<?php
session_start();
require_once('../../config/conexion.php');
require_once('../../modelo/registro.php');

$database = new Database();
$db = $database->getConnection();
$usuario = new Usuario($db);

$user = null; // Inicializar la variable para evitar errores

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $user_id = $_GET['id'];
    $query = "SELECT * FROM usuarios WHERE id_usuario = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "<div class='alert alert-danger text-center'>Usuario no encontrado.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger text-center'>ID de usuario no proporcionado.</div>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['id'];
    $nombre = $_POST['txtnombre'];
    $apellido = $_POST['txtapellido'];
    $email = $_POST['txemail'];
    $password = !empty($_POST['txtpassword']) ? password_hash($_POST['txtpassword'], PASSWORD_DEFAULT) : $user['contrasena'];
    $numero_cel = $_POST['txtnumero'];

    $query = "UPDATE usuarios SET nombre=:nombre, apellido=:apellido, email=:email, contrasena=:password, numerocel=:numerocel WHERE id_usuario=:id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido', $apellido);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':numerocel', $numero_cel);
    $stmt->bindParam(':id', $user_id);

    if ($stmt->execute()) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Cave Location',
                text: 'Usuario actualizado exitosamente.',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                window.location.href = '../html/usuarios.php';
            });
        </script>";
        exit;
    } else {
        echo "<div class='alert alert-danger text-center'>Error al actualizar el usuario.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Actualizar Usuario</h2>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $user ? htmlspecialchars($user['id_usuario']) : ''; ?>">

        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" name="txtnombre" class="form-control" 
                   value="<?php echo $user ? htmlspecialchars($user['nombre']) : ''; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Apellido:</label>
            <input type="text" name="txtapellido" class="form-control" 
                   value="<?php echo $user ? htmlspecialchars($user['apellido']) : ''; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" name="txemail" class="form-control" 
                   value="<?php echo $user ? htmlspecialchars($user['email']) : ''; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contraseña (dejar en blanco para mantener la actual):</label>
            <input type="password" name="txtpassword" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Número Cel:</label>
            <input type="number" name="txtnumero" class="form-control" 
                   value="<?php echo $user ? htmlspecialchars($user['numerocel']) : ''; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
</body>
</html>
