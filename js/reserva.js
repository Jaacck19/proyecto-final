document.addEventListener("DOMContentLoaded", function () {
    crearEstacionamiento();
    actualizarContadores();
});

const pisos = 3;
const espaciosPorPiso = 30;
const letrasPisos = "ABCDEFGHIJ";
let seleccionados = [];
let tipoVehiculo = "carro"; // Predeterminado

function crearEstacionamiento() {
    const contenedor = document.getElementById("estacionamiento");
    const selectPiso = document.getElementById("seleccionPiso");

    for (let p = 0; p < pisos; p++) {
        let option = document.createElement("option");
        option.value = letrasPisos[p];
        option.innerText = `Piso ${letrasPisos[p]}`;
        selectPiso.appendChild(option);

        const pisoDiv = document.createElement("div");
        pisoDiv.classList.add("piso", "container");
        pisoDiv.id = `piso-${letrasPisos[p]}`;
        pisoDiv.style.display = "none";

        const titulo = document.createElement("h4");
        titulo.classList.add("text-center", "mb-3");
        titulo.innerText = `Piso ${letrasPisos[p]}`;

        const filaDiv = document.createElement("div");
        filaDiv.classList.add("d-flex", "flex-wrap", "gap-2");

        for (let e = 1; e <= espaciosPorPiso; e++) {
            const espacio = document.createElement("div");

            // Alternar entre espacios para carros y motos
            if (e % 2 === 0) {
                espacio.classList.add("espacio", "disponible-carro");
                espacio.dataset.tipo = "carro";
                espacio.innerHTML = '<i class="fas fa-car"></i>';
            } else {
                espacio.classList.add("espacio", "disponible-moto");
                espacio.dataset.tipo = "moto";
                espacio.innerHTML = '<i class="fas fa-motorcycle"></i>';
            }

            espacio.dataset.piso = letrasPisos[p];
            espacio.dataset.numero = e;

            espacio.addEventListener("click", () => manejarClicEspacio(espacio));
            filaDiv.appendChild(espacio);
        }

        pisoDiv.appendChild(titulo);
        pisoDiv.appendChild(filaDiv);
        contenedor.appendChild(pisoDiv);
    }

    mostrarPiso();
    actualizarContadores();
}

function mostrarPiso() {
    const pisoSeleccionado = document.getElementById("seleccionPiso").value;
    document.querySelectorAll(".piso").forEach(p => p.style.display = "none");
    document.getElementById(`piso-${pisoSeleccionado}`).style.display = "block";
    actualizarContadores();
}

function cambiarTipoVehiculo() {
    tipoVehiculo = document.getElementById("seleccionVehiculo").value;

    document.querySelectorAll(".espacio.disponible-carro, .espacio.disponible-moto").forEach(espacio => {
        espacio.classList.remove("disponible-carro", "disponible-moto");
        espacio.classList.add(tipoVehiculo === "carro" ? "disponible-carro" : "disponible-moto");
        espacio.dataset.tipo = tipoVehiculo;
        espacio.innerHTML = tipoVehiculo === "carro" ? '<i class="fas fa-car"></i>' : '<i class="fas fa-motorcycle"></i>';
    });

    actualizarContadores();
}

function manejarClicEspacio(espacio) {
    if (espacio.classList.contains("ocupado-carro") || espacio.classList.contains("ocupado-moto")) {
        liberarEspacio(espacio);
    } else {
        seleccionarEspacio(espacio);
    }
}

function seleccionarEspacio(espacio) {
    if (espacio.classList.contains("seleccionado")) {
        // Deseleccionar el espacio
        espacio.classList.remove("seleccionado");
        espacio.classList.add(espacio.dataset.tipo === "carro" ? "disponible-carro" : "disponible-moto");
        espacio.innerHTML = espacio.dataset.tipo === "carro" ? '<i class="fas fa-car"></i>' : '<i class="fas fa-motorcycle"></i>';
        seleccionados = seleccionados.filter(e => e !== espacio);
        delete espacio.dataset.tipoSeleccionado; // Eliminar el tipo seleccionado temporal
    } else {
        // Seleccionar el espacio
        espacio.classList.remove("disponible-carro", "disponible-moto");
        espacio.classList.add("seleccionado");
        espacio.innerHTML = '<i class="fas fa-check-circle"></i>';
        espacio.dataset.tipoSeleccionado = tipoVehiculo; // Asignar el tipo seleccionado temporal
        seleccionados.push(espacio);
    }

    actualizarContadores();
}

function confirmarSeleccion() {
    if (seleccionados.length === 0) {
        alert("No has seleccionado ningún espacio.");
        return;
    }

    let mensaje = "Has reservado los siguientes espacios:\n";
    seleccionados.forEach(espacio => {
        mensaje += `Piso ${espacio.dataset.piso}, Espacio ${espacio.dataset.numero} (${espacio.dataset.tipoSeleccionado})\n`;
        espacio.classList.remove("seleccionado", "disponible-carro", "disponible-moto");
        espacio.classList.add(espacio.dataset.tipoSeleccionado === "carro" ? "ocupado-carro" : "ocupado-moto");
        espacio.innerHTML = ''; // Elimina cualquier contenido adicional
        espacio.dataset.tipo = espacio.dataset.tipoSeleccionado; // Actualizar el tipo original
        delete espacio.dataset.tipoSeleccionado; // Eliminar el tipo seleccionado temporal
    });

    seleccionados = [];
    actualizarContadores();
    alert(mensaje);
}

function liberarEspacio(espacio) {
    if (!espacio.classList.contains("ocupado-carro") && !espacio.classList.contains("ocupado-moto")) return;

    if (confirm(`¿Quieres liberar el espacio ${espacio.dataset.piso}-${espacio.dataset.numero}?`)) {
        espacio.classList.remove("ocupado-carro", "ocupado-moto");
        espacio.classList.add(espacio.dataset.tipo === "carro" ? "disponible-carro" : "disponible-moto");
        espacio.innerHTML = espacio.dataset.tipo === "carro" ? '<i class="fas fa-car"></i>' : '<i class="fas fa-motorcycle"></i>';
        actualizarContadores();
    }
}

function actualizarContadores() {
    const pisoSeleccionado = document.getElementById("seleccionPiso").value;

    // Filtrar los espacios por el piso seleccionado
    const espaciosEnPiso = document.querySelectorAll(`.piso#piso-${pisoSeleccionado} .espacio`);
    const disponiblesCarro = Array.from(espaciosEnPiso).filter(e => e.classList.contains("disponible-carro")).length;
    const disponiblesMoto = Array.from(espaciosEnPiso).filter(e => e.classList.contains("disponible-moto")).length;

    // Actualizar los contadores separados
    document.getElementById("contadorCarros").innerText = `Espacios disponibles para carros: ${disponiblesCarro}`;
    document.getElementById("contadorMotos").innerText = `Espacios disponibles para motos: ${disponiblesMoto}`;
}