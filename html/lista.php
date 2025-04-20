<?php
session_start();
require_once('../config/conexion.php');

$database = new Database();
$db = $database->getConnection();

$placaBuscada = isset($_GET['placa']) ? trim($_GET['placa']) : '';

if (!empty($placaBuscada)) {
    $query = "SELECT * FROM reservas WHERE placa LIKE :placa";
    $stmt = $db->prepare($query);
    $placaParam = "%" . $placaBuscada . "%";
    $stmt->bindParam(':placa', $placaParam);
} else {
    $query = "SELECT * FROM reservas";
    $stmt = $db->prepare($query);
}

$stmt->execute();
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Reservas - Cave Location</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/admintabla.css">
</head>
<body>

<!-- Barra de Navegación -->
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
                        <a class="nav-link" href="usuarios.php">Usuarios</a>
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
    <h2 class="text-center mb-4">Listado de Reservas</h2>

    <!-- Formulario de Búsqueda -->
    <form method="GET" class="mb-4 d-flex" role="search">
        <input type="text" name="placa" class="form-control me-2" placeholder="Buscar por placa" value="<?php echo htmlspecialchars($placaBuscada); ?>">
        <button type="submit" class="btn btn-primary">Buscar</button>
        <a href="reservas.php" class="btn btn-secondary ms-2">Limpiar</a>
    </form>

    <!-- Tabla de Reservas -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID Reserva</th>
                <th>Nombre</th>
                <th>Fecha Inicio</th>
                <th>Placa</th>
                <th>Centro Comercial</th>
                <th>Tipo de Vehículo</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($reservas) > 0): ?>
                <?php foreach ($reservas as $reserva): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reserva['id_reserva']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['fecha_inicio']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['placa']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['centro_comercial']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['tipo_vehiculo']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No se encontraron reservas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
