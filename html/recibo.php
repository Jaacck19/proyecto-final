<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require_once('../config/conexion.php');

if (!isset($_GET['placa'])) {
    header("Location: ../index.html");
    exit();
}

$placa = $_GET['placa'];

try {
    $database = new Database();
    $conn = $database->getConnection();

    $sql = "SELECT id_reserva, nombre, fecha_inicio, placa, centro_comercial, tipo_vehiculo 
            FROM reservas WHERE placa = :placa";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':placa', $placa);
    $stmt->execute();

    $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reserva) {
        $id_reserva = htmlspecialchars($reserva['id_reserva']);
        $nombre = htmlspecialchars($reserva['nombre']);
        $fecha_inicio = htmlspecialchars($reserva['fecha_inicio']);
        $placa = htmlspecialchars($reserva['placa']);
        $centro_comercial = htmlspecialchars($reserva['centro_comercial']);
        $tipo_vehiculo = htmlspecialchars($reserva['tipo_vehiculo']);

        // Calcular el tiempo restante y el costo adicional
        $fecha_inicio_datetime = new DateTime($reserva['fecha_inicio']);
        $fecha_actual = new DateTime();
        $tiempo_gratis = 1 * 60; // 1 minuto en segundos
        $tiempo_transcurrido = $fecha_actual->getTimestamp() - $fecha_inicio_datetime->getTimestamp();
        $tiempo_restante = max($tiempo_gratis - $tiempo_transcurrido, 0); // Evitar valores negativos

        // Calcular el costo adicional
        $minutos_adicionales = max(ceil(($tiempo_transcurrido - $tiempo_gratis) / 60), 0);
        $costo_adicional = $minutos_adicionales * 100; // 100 pesos por minuto adicional
        $total_a_pagar = 2500 + $costo_adicional; // Base de $2500 más el costo adicional
    } else {
        echo "No se encontró una reserva con la placa proporcionada.";
        exit();
    }
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
            <p><strong>Espacio elegido:</strong> <?php echo $id_reserva; ?> - Espacio Ubicado</p>
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