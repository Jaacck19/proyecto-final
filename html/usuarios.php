<?php
session_start();
require_once('../config/conexion.php');

$database = new Database();
$db = $database->getConnection();

// Capturar el filtro de búsqueda
$emailBuscado = isset($_GET['email']) ? trim($_GET['email']) : '';

// Construir la consulta
if (!empty($emailBuscado)) {
    $query = "SELECT id_usuario, nombre, apellido, email, numerocel FROM usuarios WHERE email LIKE :email";
    $stmt = $db->prepare($query);
    $paramEmail = "%" . $emailBuscado . "%";
    $stmt->bindParam(':email', $paramEmail);
} else {
    $query = "SELECT id_usuario, nombre, apellido, email, numerocel FROM usuarios";
    $stmt = $db->prepare($query);
}

$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Usuarios - Cave Location</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/admintabla.css">
</head>
<body>
<div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand">cave location</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="lista.php">Reservas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="espacio.html">Espacios Libres</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<div class="container mt-5">
    <h2 class="text-center mb-4">Listado de Usuarios</h2>

    <!-- Buscador por Email -->
    <form method="GET" class="mb-4 d-flex" role="search">
        <input type="text" name="email" class="form-control me-2" placeholder="Buscar por email" value="<?php echo htmlspecialchars($emailBuscado); ?>">
        <button type="submit" class="btn btn-primary">Buscar</button>
        <a href="usuarios.php" class="btn btn-secondary ms-2">Limpiar</a>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Número Cel</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($usuarios) > 0): ?>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario['id_usuario']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['apellido']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['numerocel']); ?></td>
                        <td>
                            <a href="Principal/actualiza.php?id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-edit"></i> Actualizar
                            </a>
                            <a href="Principal/elimina.php?id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">
                                <i class="fas fa-trash"></i> Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No se encontraron usuarios.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
