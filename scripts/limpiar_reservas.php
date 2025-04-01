<?php
require_once '../Controlador/resercontrolador.php';

$controlador = new ReservaControlador();
$controlador->eliminarReservasExpiradas();

echo "Reservas expiradas eliminadas correctamente.";
?>
