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