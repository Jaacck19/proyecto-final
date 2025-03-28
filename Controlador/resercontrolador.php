<?php
// Controlador/resercontrolador.php
require_once '../modelo/reserva.php';
require_once '../config/conexion.php';

class ReservaControlador {
    public function crearReserva($nombre, $fecha_inicio, $fecha_fin, $placa, $centro_comercial, $tipo_vehiculo) {
        try {
            if (is_null($fecha_inicio)) {
                throw new Exception("La fecha de inicio no puede ser nula");
            }

            $conexion = new Conexion();
            $conn = $conexion->getConexion();

            // Verificar si el usuario existe
            $sql_usuario = "SELECT nombre FROM usuarios WHERE nombre = ?";
            $stmt_usuario = $conn->prepare($sql_usuario);
            $stmt_usuario->bind_param("s", $nombre);
            $stmt_usuario->execute();
            $resultado_usuario = $stmt_usuario->get_result();
            if ($resultado_usuario->num_rows == 0) {
                throw new Exception("El nombre no existe");
            }
            $stmt_usuario->close();

            $reserva = new Reserva($nombre, $fecha_inicio, $fecha_fin, $placa, $centro_comercial, $tipo_vehiculo);

            // Asegúrate de que la clase Reserva tenga los siguientes métodos
            $nombre = $reserva->getNombre();
            $fecha_inicio = $reserva->getFechaInicio();
            $fecha_fin = $reserva->getFechaFin();
            $placa = $reserva->getPlaca();
            $centro_comercial = $reserva->getCentroComercial();
            $tipo_vehiculo = $reserva->getTipoVehiculo();
            
            // Guardar la reserva en la base de datos
            $sql = "INSERT INTO reservas (nombre, fecha_inicio, fecha_fin, placa, centro_comercial, tipo_vehiculo) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", 
                $nombre, 
                $fecha_inicio, 
                $fecha_fin, 
                $placa, 
                $centro_comercial, 
                $tipo_vehiculo
            );
            
            if ($stmt->execute()) {
                $stmt->close();
                $conexion->cerrarConexion();
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo "<script>
                    Swal.fire({
                        title: 'Cave Location',
                        text: 'Reserva creada exitosamente.',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        window.location.href = '../html/recibo.php?placa=" . urlencode($placa) . "';
                    });
                </script>";
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
            $stmt->close();
            $conexion->cerrarConexion();
            
            return $reserva;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function obtenerReserva($id_reserva) {
        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();
            
            $sql = "SELECT * FROM reservas WHERE id_reserva = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_reserva);
            $stmt->execute();
            
            $resultado = $stmt->get_result();
            if ($fila = $resultado->fetch_assoc()) {
                $reserva = new Reserva(
                    $fila['nombre'],
                    $fila['fecha_inicio'],
                    $fila['fecha_fin'],
                    $fila['placa'],
                    $fila['centro_comercial'],
                    $fila['tipo_vehiculo'],
                    $fila['id_reserva']
                );
                
                $stmt->close();
                $conexion->cerrarConexion();
                return $reserva;
            }
            
            $stmt->close();
            $conexion->cerrarConexion();
            return null;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function actualizarReserva($id_reserva, $nombre, $fecha_inicio, $fecha_fin, $placa, $centro_comercial, $tipo_vehiculo, $moto) {
        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();
            
            $sql = "UPDATE reservas SET nombre=?, fecha_inicio=?, fecha_fin=?, placa=?, centro_comercial=?, tipo_vehiculo=?
                    WHERE id_reserva=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $nombre, $fecha_inicio, $fecha_fin, $placa, $centro_comercial, $tipo_vehiculo, $id_reserva);
            
            $resultado = $stmt->execute();
            $stmt->close();
            $conexion->cerrarConexion();
            
            return $resultado;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function eliminarReserva($id_reserva) {
        try {
            $conexion = new Conexion();
            $conn = $conexion->getConexion();
            
            $sql = "DELETE FROM reservas WHERE id_reserva=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_reserva);
            
            $resultado = $stmt->execute();
            $stmt->close();
            $conexion->cerrarConexion();
            
            return $resultado;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}

// Procesar el formulario de reserva
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controlador = new ReservaControlador();
    $controlador->crearReserva(
        $_POST['nombre'] ?? null,
        $_POST['fecha_inicio'] ?? null,
        $_POST['fecha_fin'] ?? null,
        $_POST['placa'] ?? null,
        $_POST['centro_comercial'] ?? null,
        $_POST['tipo_vehiculo'] ?? null
    );
}
?>