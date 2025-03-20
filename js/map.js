// maps.js

// Datos de ejemplo
const places = [
    { name: 'Centro Comercial Santafé', rating: 4.5, address: 'Autopista Norte #185-70', lat: 4.712, lng: -74.072 },
    { name: 'Centro Comercial Andino', rating: 4.6, address: 'Cra. 11 #82-71', lat: 4.674, lng: -74.050 },
    { name: 'Centro Comercial Gran Estación', rating: 4.4, address: 'Av. Calle 26 #62-47', lat: 4.625, lng: -74.075 },
    { name: 'Centro Comercial Mall Plaza', rating: 4.5, address: 'Cra. 15 #124-30', lat: 4.619, lng: -74.101 },
    { name: 'Centro Comercial Titan Plaza', rating: 4.3, address: 'Av. Boyacá #80-94', lat: 4.625, lng: -74.109 },
    { name: 'Centro Comercial Plaza de Las Américas', rating: 4.2, address: 'Cra. 71D #6-94 Sur', lat: 4.601, lng: -74.157 },
    { name: 'Centro Comercial Centro Mayor', rating: 4.3, address: 'Autopista Sur #38A Sur-07', lat: 4.571, lng: -74.130 }
];

let map;
let markers = [];

// Función para inicializar el mapa
function initMap() {
    const bogota = { lat: 4.7110, lng: -74.0721 };
    
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 12,
        center: bogota,
    });

    // Agregar marcadores con icono personalizado
    places.forEach(place => {
        const marker = new google.maps.Marker({
            position: { lat: place.lat, lng: place.lng },
            map: map,
            title: place.name,
            icon: {
                url: "../img/ubi.png", // Icono personalizado
                scaledSize: new google.maps.Size(40, 40) // Ajustar tamaño del icono
            }
        });
        markers.push(marker);
    });

    renderPlaces(places);
}

// Función para renderizar lugares en la lista
function renderPlaces(placesToRender) {
    const placesList = document.getElementById('placesList');
    placesList.innerHTML = placesToRender.map(place => `
        <div class="place-item" onclick="selectPlace(${place.lat}, ${place.lng})">
            <div class="place-name">${place.name}</div>
            <div class="place-rating">
                <span class="star">★</span> ${place.rating}
            </div>
            <div class="place-address">${place.address}</div>
        </div>
    `).join('');
}

// Función para seleccionar un lugar y cambiar el marcador
function selectPlace(lat, lng) {
    const position = { lat: lat, lng: lng };
    map.setCenter(position);
    map.setZoom(15);

    // Eliminar marcadores anteriores
    markers.forEach(marker => marker.setMap(null));

    // Crear un nuevo marcador con un icono diferente para la selección
    const marker = new google.maps.Marker({
        position: position,
        map: map,
        title: "Ubicación seleccionada",
        icon: {
            url: "../img/ubi.png", // Imagen diferente para selección
            scaledSize: new google.maps.Size(50, 50) // Ajusta el tamaño si es necesario
        }
    });

    // Mantener solo el nuevo marcador
    markers = [marker];
}

// Función para filtrar los lugares
function filterPlaces(searchTerm) {
    const filteredPlaces = places.filter(place =>
        place.name.toLowerCase().includes(searchTerm.toLowerCase())
    );
    renderPlaces(filteredPlaces);
}

// Función para alternar la barra lateral
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mapContent = document.getElementById('mapContent');
    const toggleIcon = document.getElementById('toggleIcon');
    
    sidebar.classList.toggle('collapsed');
    mapContent.classList.toggle('expanded');
    
    if (sidebar.classList.contains('collapsed')) {
        toggleIcon.classList.remove('fa-chevron-right');
        toggleIcon.classList.add('fa-chevron-left');
    } else {
        toggleIcon.classList.remove('fa-chevron-left');
        toggleIcon.classList.add('fa-chevron-right');
    }
}
