<?php
session_start();
require_once('../config/conexion.php');

if (!isset($_GET['placa'])) {
    echo "No se proporcionó una placa.";
    exit();
}

$placa = $_GET['placa'];

try {
    $conexion = new Conexion();
    $conn = $conexion->getConexion();

    $sql = "SELECT id_reserva, nombre, fecha_inicio, placa, centro_comercial, tipo_vehiculo FROM reservas WHERE placa = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $placa);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($fila = $resultado->fetch_assoc()) {
        $id_reserva = htmlspecialchars($fila['id_reserva']);
        $nombre = htmlspecialchars($fila['nombre']);
        $fecha_inicio = htmlspecialchars($fila['fecha_inicio']);
        $centro_comercial = htmlspecialchars($fila['centro_comercial']);
        $tipo_vehiculo = htmlspecialchars($fila['tipo_vehiculo']);
    } else {
        echo "No se encontró una reserva con la placa proporcionada.";
        exit();
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
    <title>Recibo - Cave Location</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/recib.css">
</head>

<body>
    <!-- Encabezado -->
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand">Cave Location</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="../index.html">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="../html/nosotros.html">Nosotros</a></li>
                        <li class="nav-item"><a class="nav-link" href="../html/cencomercial.html">Centros Comerciales</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <!-- Contenedor del recibo -->
    <div class="container mt-5">
        <div class="card p-4">
            <h2 class="text-center">Recibo de Pago</h2>
            <p><strong>Nombre:</strong> <?php echo $nombre; ?></p>
            <p><strong>Placa:</strong> <?php echo $placa; ?></p>
            <p><strong>Centro Comercial:</strong> <?php echo $centro_comercial; ?></p>
            <p><strong>Fecha Inicio:</strong> <?php echo $fecha_inicio; ?></p>
            <p><strong>espacio elegido:</strong> <?php echo $id_reserva; ?> - Espacio Ubicado</p>
            <p><strong>Tipo de Vehículo:</strong> <?php echo $tipo_vehiculo; ?></p>

            <!-- Espacio para código QR -->
            <div class="d-flex justify-content-center my-3">
                <img src="../img/qr.jpg" alt="Código QR" class="qr-placeholder">
            </div>

            <!-- Temporizador -->
            <p><strong>Tiempo restante gratis:</strong></p>
            <div id="countdown" class="timer text-center">30:00</div>

            <!-- Total a pagar -->
            <p class="mt-3"><strong>Total a pagar:</strong> <span id="precioTotal">$2500</span></p>
        </div>
    </div>

    <script src="../js/reciboo.js"></script>
</body>

</html>
