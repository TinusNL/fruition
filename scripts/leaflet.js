// Background
const tileLayer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
});

// Set up marker layers
const markerLayers = {};

const markers = JSON.parse('[{ "id": 1, "photoName": "77069d90-e7e1-47a9-b5e0-41d70e45a956.webp", "type": "apple", "location": { "lat": 50.373380, "lng": -4.142650 }, "timestamp": 1633440000, "createdBy": "John Doe", "userId": 123, "name": "Apple Tree 1", "typeId": 1, "seasonId": 2 }, { "id": 2, "type": "apple", "location": { "lat": 50.370380, "lng": -4.142650 }, "timestamp": 1633441200, "createdBy": "Jane Smith", "photoName": "andere-foto-naam.webp", "userId": 456, "name": "Apple Tree 2", "typeId": 1, "seasonId": 3 }]');

markers.forEach(markerInfo => {
    const marker = L.marker([markerInfo.location.lat, markerInfo.location.lng], {
        icon: L.divIcon({ className: 'custom-icon', html: markerInfo.type }),
        riseOnHover: true
    });

    marker.bindPopup(`
        <div class="popup-container">
            <img src="Images/${markerInfo.photoName}" alt="Marker Photo" class="popup-img">
            <p class="type">Type: ${markerInfo.type}</p>
            <p class="createdby">Created by: ${markerInfo.createdBy}</p>
            <p class="timestamp">Timestamp: ${new Date(markerInfo.timestamp).toLocaleString()}</p>
            <p class="season">Season: ${markerInfo.season}</p>
            <p class="location"><a href="https://www.google.com/maps?q=${markerInfo.location.lat},${markerInfo.location.lng}" target="_blank">Location: ${markerInfo.location.lat}, ${markerInfo.location.lng}</a></p>
        </div>
    `);

    markerLayers[markerInfo.type] = markerLayers[markerInfo.type] || L.layerGroup();
    marker.addTo(markerLayers[markerInfo.type]);
});

// Create map
const map = L.map('leaflet-map', {
    center: [50.370380, -4.142650],
    zoom: 15,
    layers: [tileLayer, ...Object.values(markerLayers).flat()]
});

// Current Location
let locationMarker;
const btn = L.easyButton('<img src="./assets/icons/location-crosshair.svg" id="location-crosshair">', function () {
    navigator.geolocation.getCurrentPosition((position) => {
        map.setView([position.coords.latitude, position.coords.longitude], 16, { pan: { animate: true } });

        if (locationMarker) {
            locationMarker.removeFrom(map);
        }

        locationMarker = L.circle([position.coords.latitude, position.coords.longitude], {
            color: '#006ACD',
            fillColor: '#006ACD',
            radius: 10
        }).addTo(map);
    });
}).addTo(map);

// Open Functions
function hideMarkerType(type) {
    map.removeLayer(markerLayers[type]);
}

function showMarkerType(type) {
    map.addLayer(markerLayers[type]);
}










// var marker = JSON_parse('<?php echo $markerJSON ?>')

// marker.forEach( function (markerInfo) {
//     var marker = L.marker([markerInfo.lat, markerInfo.lng]).addTo(map)
//     marker.bindPopup(`<b>${markerInfo.type}</b></br>${markerInfo.id}`)
// })

// var popupContent = `
//         <b>${markerInfo.type}</b><br>
//         ${markerInfo.description}<br>
//         <img src="${markerInfo.imageURL}" alt="${markerInfo.type}" width="100" height="100">
//     `;

// marker.bindPopup(popupContent);
// Open Functions
