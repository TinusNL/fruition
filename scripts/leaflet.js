// Background
const tileLayer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
})

// Seting up marker layers
const markers = JSON.parse(markerJson)
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

// Open Functions
function hideMarkerType(type) {
    map.removeLayer(markerLayers[type])
}

function showMarkerType(type) {
    map.addLayer(markerLayers[type])
}