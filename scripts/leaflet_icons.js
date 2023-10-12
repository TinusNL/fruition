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


const leafletIcons = {
    "apple": icon('./assets/markers/apple.svg'),
    "apricot": icon('./assets/markers/apricot.svg'),
    "berry": icon('./assets/markers/berry.svg'),
    "grapefruit": icon('./assets/markers/grapefruit.svg'),
    "grapes": icon('./assets/markers/grapes.svg'),
    "lemon": icon('./assets/markers/lemon.svg'),
    "orange": icon('./assets/markers/orange.svg'),
    "pear": icon('./assets/markers/pear.svg'),
    "strawberry": icon('./assets/markers/strawberry.svg'),
}  