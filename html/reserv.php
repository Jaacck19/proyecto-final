<?php
session_start();
require_once('../config/conexion.php');
require_once('../modelo/reserva.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $placa = $_POST['placa'] ?? '';
    $fecha_inicio = $_POST['fecha_inicio'] ?? '';
    $fecha_fin = $_POST['fecha_fin'] ?? '';
    $tipo_vehiculo = $_POST['tipo_vehiculo'] ?? '';
    $centro_comercial = $_POST['centro_comercial'] ?? '';

    if (!empty($nombre) && !empty($placa) && !empty($fecha_inicio) && !empty($tipo_vehiculo) && !empty($centro_comercial)) {
        $database = new Database();
        $db = $database->getConnection();

        // Verificar si el nombre existe en la tabla usuarios
        $query = "SELECT nombre FROM usuarios WHERE nombre = :nombre";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Verificar si la placa ya existe en la tabla reservas
            $query = "SELECT placa FROM reservas WHERE placa = :placa";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':placa', $placa);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                $tipo_vehiculo = $_POST['tipo_vehiculo'] ?? null;
                if (empty($tipo_vehiculo)) {
                    throw new Exception("El campo 'tipo_vehiculo' no puede estar vacío.");
                }

                $reserva = new Reserva(
                    $db,
                    $_POST['nombre'] ?? null,
                    $_POST['fecha_inicio'] ?? null,
                    $_POST['fecha_fin'] ?? null,
                    $_POST['placa'] ?? null,
                    $_POST['centro_comercial'] ?? null,
                    $tipo_vehiculo
                );

                if ($reserva->crearReserva()) {
                    echo "<script>
                        alert('Reserva creada exitosamente.');
                        window.location.href = 'recibo.php?placa=" . urlencode($placa) . "';
                    </script>";
                    exit();
                } else {
                    echo "Error al crear la reserva.";
                }
            } else {
                echo "La placa proporcionada ya está registrada.";
            }
        } else {
            echo "El nombre proporcionado no existe en la base de datos.";
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
}

if (isset($_SESSION['user_id'])) {
    echo '<a href="cerrarsesion.php" style="text-decoration: none; color: black;">Cerrar sesión</a>';
}
?>
