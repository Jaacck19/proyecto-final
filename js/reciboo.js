document.addEventListener("DOMContentLoaded", function () {
    let totalPrecio = 2500; // Se cobra la reserva de $2500
    let precioPorMinuto = 110; // Precio por minuto después de 30 minutos
    let tiempoGratis = 30 * 60; // 30 minutos en segundos
    let tiempoUsado = 0;
    
    const countdownElement = document.getElementById("countdown");
    const precioElement = document.getElementById("precioTotal");

    function actualizarTemporizador() {
        let minutos = Math.floor(tiempoGratis / 60);
        let segundos = tiempoGratis % 60;

        countdownElement.textContent = `${minutos}:${segundos < 10 ? "0" : ""}${segundos}`;
        
        if (tiempoGratis > 0) {
            tiempoGratis--;
        } else {
            // Una vez terminado el tiempo gratis, empieza el cobro por minuto
            tiempoUsado++;
            totalPrecio += precioPorMinuto;
            precioElement.textContent = `$${totalPrecio.toLocaleString()}`;
        }
    }

    // Ejecutar cada segundo
    setInterval(actualizarTemporizador, 1000);
    
    // Mostrar el precio inicial con la reserva de $2500
    precioElement.textContent = `$${totalPrecio.toLocaleString()}`;
});
