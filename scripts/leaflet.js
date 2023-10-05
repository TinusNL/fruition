var map = L.map('leaflet-map').setView([50.370380, -4.142650], 15)

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
}).addTo(map)

var locationMarker

var btn = L.easyButton('<img src="./assets/location-crosshairs-solid.svg" id="location-crosshair">', function () {
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

var markers = JSON.parse(markerJson)
markers.forEach(markerInfo => {
    var marker = L.marker([markerInfo.lat, markerInfo.lng]).addTo(map)
    marker.bindPopup(`<b>${markerInfo.type}</b></br>${markerInfo.id}`)
})