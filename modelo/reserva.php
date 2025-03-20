<?php
// modelo/reserva.php

class Reserva {
    private $id_reservass;
    private $nombre;
    private $fecha_inicio;
    private $fecha_fin;
    private $placa;
    private $centro_comercial;
    private $tipo_vehiculo;
    
    public function __construct($nombre = null, $fecha_inicio = null, $fecha_fin = null, $placa = null, $centro_comercial = null, $tipo_vehiculo = null, $id_reservass = null) {
        $this->nombre = $nombre;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
        $this->placa = $placa;
        $this->centro_comercial = $centro_comercial;
        $this->tipo_vehiculo = $tipo_vehiculo;
        $this->id_reservass = $id_reservass;
    }
    
    // Getters
    public function getId() {
        return $this->id_reservass;
    }
    
    public function getIdUsuario() {
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

    public function getNombre() {
        return $this->nombre;
    }
    
    // Setters
    public function setId($id_reservass) {
        $this->id_reservass = $id_reservass;
    }
    
    public function setIdUsuario($nombre) {
        $this->nombre = $nombre;
    }
    
    public function setFechaInicio($fecha_inicio) {
        $this->fecha_inicio = $fecha_inicio;
    }
    
    public function setFechaFin($fecha_fin) {
        $this->fecha_fin = $fecha_fin;
    }
    
    public function setPlaca($placa) {
        $this->placa = $placa;
    }
    
    public function setCentroComercial($centro_comercial) {
        $this->centro_comercial = $centro_comercial;
    }
    
    public function setTipoVehiculo($tipo_vehiculo) {
        $this->tipo_vehiculo = $tipo_vehiculo;
    }
}
?>