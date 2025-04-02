<?php
// modelo/reserva.php

class Reserva {
    private $conn;
    private $table_name = "reservas";

    public $id_reserva;
    public $nombre;
    public $fecha_inicio;
    public $fecha_fin;
    public $placa;
    public $centro_comercial;
    public $tipo_vehiculo;

    public function __construct($db, $nombre = null, $fecha_inicio = null, $fecha_fin = null, $placa = null, $centro_comercial = null, $tipo_vehiculo = null) {
        $this->conn = $db;
        $this->nombre = $nombre;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
        $this->placa = $placa;
        $this->centro_comercial = $centro_comercial;

        if (empty($tipo_vehiculo)) {
            throw new Exception("El campo 'tipo_vehiculo' no puede estar vacío.");
        }
        $this->tipo_vehiculo = $tipo_vehiculo;
    }

    public function crearReserva() {
        if (empty($this->nombre)) {
            throw new Exception("El campo 'nombre' no puede estar vacío.");
        }

        if (empty($this->tipo_vehiculo)) {
            throw new Exception("El campo 'tipo_vehiculo' no puede estar vacío.");
        }

        $query = "INSERT INTO " . $this->table_name . " (nombre, fecha_inicio, fecha_fin, placa, centro_comercial, tipo_vehiculo) VALUES (:nombre, :fecha_inicio, :fecha_fin, :placa, :centro_comercial, :tipo_vehiculo)";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->fecha_inicio = htmlspecialchars(strip_tags($this->fecha_inicio));
        $this->fecha_fin = htmlspecialchars(strip_tags($this->fecha_fin));
        $this->placa = htmlspecialchars(strip_tags($this->placa));
        $this->centro_comercial = htmlspecialchars(strip_tags($this->centro_comercial));
        $this->tipo_vehiculo = htmlspecialchars(strip_tags($this->tipo_vehiculo));

        // bind values
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":fecha_inicio", $this->fecha_inicio);
        $stmt->bindParam(":fecha_fin", $this->fecha_fin);
        $stmt->bindParam(":placa", $this->placa);
        $stmt->bindParam(":centro_comercial", $this->centro_comercial);
        $stmt->bindParam(":tipo_vehiculo", $this->tipo_vehiculo);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function eliminarReservasExpiradas() {
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE fecha_fin <= NOW()";
            $stmt = $this->conn->prepare($query);
            if ($stmt->execute()) {
                $filas_afectadas = $stmt->rowCount(); // Verificar cuántas filas se eliminaron
                if ($filas_afectadas > 0) {
                    echo "Reservas expiradas eliminadas: $filas_afectadas.";
                } else {
                    echo "No se encontraron reservas expiradas para eliminar.";
                }
                return true;
            } else {
                throw new Exception("Error al ejecutar la consulta para eliminar reservas expiradas.");
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Métodos getter
    public function getNombre() {
        return $this->nombre;
    }

    public function getFechaInicio() {
        return $this->fecha_inicio;
    }

    public function getFechaFin() {
        return $this->fecha_fin;
    }

    public function getPlaca() {
        return $this->placa;
    }

    public function getCentroComercial() {
        return $this->centro_comercial;
    }

    public function getTipoVehiculo() {
        return $this->tipo_vehiculo;
    }
}
?>