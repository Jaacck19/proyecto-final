<?php
session_start();
require_once('../config/conexion.php');

try {
    $conexion = new Conexion();
    $conn = $conexion->getConexion();

    $sql = "SELECT id_reserva, nombre, fecha_inicio, placa, centro_comercial, tipo_vehiculo FROM reservas";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $reservas = [];
    while ($fila = $resultado->fetch_assoc()) {
        $reservas[] = $fila;
    }

    $stmt->close();
    $conexion->cerrarConexion();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <title>Cave Location</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/admintabla.css">
</head>
<body>
     <!-- Encabezado / Barra de Navegación -->
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
                            <a class="nav-link" href="espacio.html">Espacios libres</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
<div class="container mt-5">
    <h2 class="text-center mb-4">Listado de Reservas</h2>

    <?php if (count($reservas) > 0): ?>
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
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info text-center">No hay reservas registradas.</div>
    <?php endif; ?>
</div>
</body>
</html>
