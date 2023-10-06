// Background
const tileLayer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
})

// Seting up marker layers
// const markers = JSON.parse(markerJson)
const markerLayers = {}

markers.forEach(markerInfo => {
    const marker = L.marker([markerInfo.lat, markerInfo.lng], { icon: leafletIcons[markerInfo.type], riseOnHover: true })
    marker.bindPopup(`<b>${markerInfo.type}</b></br>${markerInfo.id}`)

    markerLayers[markerInfo.type] = markerLayers[markerInfo.type] || L.layerGroup()
    marker.addTo(markerLayers[markerInfo.type])
})

// Create map
const map = L.map('leaflet-map', {
    center: [50.370380, -4.142650],
    zoom: 15,
    layers: [tileLayer, ...Object.values(markerLayers).flat()]
})

// Current Location
var locationMarker
const btn = L.easyButton('<img src="./assets/icons/location-crosshair.svg" id="location-crosshair">', function () {
    navigator.geolocation.getCurrentPosition((position) => {
        map.setView([position.coords.latitude, position.coords.longitude], 16, { pan: { animate: true } })

        if (locationMarker) {
            locationMarker.removeFrom(map)
        }

        locationMarker = L.circle([position.coords.latitude, position.coords.longitude], {
            color: '#006ACD',
            fillColor: '#006ACD',
            radius: 10
        }).addTo(map)
    })
}).addTo(map)

var markers = JSON.parse(markerJson);
markers.forEach(markerInfo => {
    var marker = L.marker([markerInfo.location.lat, markerInfo.location.lng]).addTo(map);

    var timestamp = new Date(markerInfo.timestamp);
    var photoUrl = `Images/${markerInfo.photoName}`;

    // Convert latitude and longitude to a Google Maps link
    var googleMapsLink = `https://www.google.com/maps?q=${markerInfo.location.lat},${markerInfo.location.lng}`;

    marker.bindPopup(`
        <div class="popup-container">
            <p class="timestamp">${timestamp.toLocaleString()}</p>
            <img src="${photoUrl}" alt="Marker Photo" class="popup-img">
            <p class="type">Type: ${markerInfo.type}</p>
            <p class="createdby">Created by: ${markerInfo.createdBy}</p>
            <p class="season">Season: ${markerInfo.season}</p>
            <p class="location"><a href="${googleMapsLink}" target="_blank">Location: ${markerInfo.location.lat}, ${markerInfo.location.lng}</a></p>
        </div>
    `, {
        className: 'custom-popup'
    });
});












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
function hideMarkerType(type) {
    map.removeLayer(markerLayers[type])
}

function showMarkerType(type) {
    map.addLayer(markerLayers[type])
}
