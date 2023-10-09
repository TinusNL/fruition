// User Location
let locationMarker
var userLoc = localStorage.getItem('userLocation') ?? false
if (!userLoc) {
    navigator.geolocation.getCurrentPosition((position) => {
        setCurrentLocation([position.coords.latitude, position.coords.longitude])

        localStorage.setItem('userLocation', JSON.stringify([position.coords.latitude, position.coords.longitude]))
    })
}

userLoc = JSON.parse(userLoc)

console.log(userLoc)

// Background
const tileLayer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
})

// Set up marker layers
const markerLayers = {}
const markers = JSON.parse(markerJson)

markers.forEach(markerInfo => {
    const marker = L.marker([markerInfo.longitude, markerInfo.latitude], {
        icon: leafletIcons[markerInfo.typeName],
        riseOnHover: true
    })

    marker.bindPopup(`
        <div class="popup-container">
            <img src="${markerInfo.image}" alt="Marker Photo" class="popup-img">
            <p class="type">Type: ${markerInfo.typeName}</p>
            <p class="createdby">Created by: ${markerInfo.createdBy}</p>
            <p class="season">Season: ${markerInfo.seasonName}</p>
            <p class="location"><a href="https://www.google.com/maps?q=${markerInfo.longitude},${markerInfo.latitude}" target="_blank">Route: ${markerInfo.longitude}, ${markerInfo.latitude}</a></p>
        </div>
    `)

    markerLayers[markerInfo.typeName] = markerLayers[markerInfo.typeName] || L.layerGroup()
    marker.addTo(markerLayers[markerInfo.typeName])
})

// Create map
const map = L.map('leaflet-map', {
    center: [0, 0],
    zoom: 1,
    layers: [tileLayer, ...Object.values(markerLayers).flat()]
})
if (userLoc) {
    setCurrentLocation(userLoc, true)
}

// Current Location
function setCurrentLocation(coords) {
    map.setView(coords, 16, { pan: { animate: true } })

    if (locationMarker) {
        locationMarker.removeFrom(map)
    }

    locationMarker = L.circle(coords, {
        color: '#006ACD',
        fillColor: '#006ACD',
        radius: 10
    }).addTo(map)
}

const btn = L.easyButton('<img src="./assets/icons/location-crosshair.svg" id="location-crosshair">', function () {
    setCurrentLocation(userLoc)

    navigator.geolocation.getCurrentPosition((position) => {
        setCurrentLocation([position.coords.latitude, position.coords.longitude])

        localStorage.setItem('userLocation', JSON.stringify([position.coords.latitude, position.coords.longitude]))
    })
}).addTo(map)

// Open Functions
function hideMarkerType(type) {
    if (!markerLayers[type]) return

    map.removeLayer(markerLayers[type])
}

function showMarkerType(type) {
    if (!markerLayers[type]) return

    map.addLayer(markerLayers[type])
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
