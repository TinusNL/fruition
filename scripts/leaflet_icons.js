function icon(img) {
    return L.icon({
        iconUrl: img,
        shadowUrl: './assets/markers/shadow.png',

        iconSize: [37, 37],
        shadowSize: [41, 41],
        iconAnchor: [18, 36],
        shadowAnchor: [13, 39],
        popupAnchor: [0, -30]
    })
}


var leafletIcons = {
    "apple": icon('./assets/markers/apple.svg')
}  