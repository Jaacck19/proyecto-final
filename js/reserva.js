document.addEventListener("DOMContentLoaded", function () {
    crearEstacionamiento();
});

const pisos = 3;
const espaciosPorPiso = 30;
const letrasPisos = "ABCDEFGHIJ";
let seleccionados = [];

function crearEstacionamiento() {
    console.log("Creando estacionamiento...");
    const contenedor = document.getElementById("estacionamiento");
    const selectPiso = document.getElementById("seleccionPiso");

    if (!contenedor || !selectPiso) {
        console.error("Error: Elementos HTML no encontrados.");
        return;
    }

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

        const contador = document.createElement("div");
        contador.classList.add("alert", "alert-secondary", "text-center");
        contador.id = `contador-${letrasPisos[p]}`;
        contador.innerText = `Espacios disponibles: ${espaciosPorPiso} | Ocupados: 0`;

        const filaDiv = document.createElement("div");
        filaDiv.classList.add("fila");

        for (let e = 1; e <= espaciosPorPiso; e++) {
            const espacio = document.createElement("div");
            espacio.classList.add("espacio", "disponible");
            espacio.dataset.piso = letrasPisos[p];
            espacio.dataset.numero = e;
            espacio.innerHTML = '<i class="fas fa-car"></i>';
            espacio.addEventListener("click", () => seleccionarEspacio(espacio));
            filaDiv.appendChild(espacio);
        }

        pisoDiv.appendChild(titulo);
        pisoDiv.appendChild(contador);
        pisoDiv.appendChild(filaDiv);
        contenedor.appendChild(pisoDiv);
    }
    actualizarContadorGlobal();
}

function mostrarPiso() {
    const pisoSeleccionado = document.getElementById("seleccionPiso").value;
    const pisos = document.querySelectorAll(".piso");

    pisos.forEach(p => p.style.display = "none");

    if (pisoSeleccionado) {
        document.getElementById(`piso-${pisoSeleccionado}`).style.display = "block";
    }
}

function seleccionarEspacio(espacio) {
    if (espacio.classList.contains("ocupado")) return;

    if (espacio.classList.contains("seleccionado")) {
        espacio.classList.remove("seleccionado");
        espacio.innerHTML = '<i class="fas fa-car"></i>';
        seleccionados = seleccionados.filter(e => e !== espacio);
    } else {
        espacio.classList.add("seleccionado");
        espacio.innerHTML = '<i class="fas fa-check-circle"></i>';
        seleccionados.push(espacio);
    }
}

function confirmarSeleccion() {
    if (seleccionados.length === 0) {
        alert("No has seleccionado ningún espacio.");
        return;
    }

    seleccionados.forEach(espacio => {
        espacio.classList.remove("seleccionado", "disponible");
        espacio.classList.add("ocupado");
        espacio.innerHTML = '<i class="fas fa-ban"></i>';
    });

    seleccionados = [];
    actualizarContadorGlobal();
    alert("Espacios confirmados.");
}

function actualizarContadorGlobal() {
    let totalDisponibles = 0;
    let totalOcupados = 0;

    letrasPisos.split("").forEach(letra => {
        const espacios = document.querySelectorAll(`#piso-${letra} .espacio`);
        let disponibles = 0;
        let ocupados = 0;

        espacios.forEach(espacio => {
            if (espacio.classList.contains("disponible")) {
                disponibles++;
            } else if (espacio.classList.contains("ocupado")) {
                ocupados++;
            }
        });

        totalDisponibles += disponibles;
        totalOcupados += ocupados;

        const contadorPiso = document.getElementById(`contador-${letra}`);
        if (contadorPiso) {
            contadorPiso.innerText = `Espacios disponibles: ${disponibles} | Ocupados: ${ocupados}`;
        }
    });

    document.getElementById("contadorGlobal").innerText = `Espacios disponibles: ${totalDisponibles} | Ocupados: ${totalOcupados}`;
}
