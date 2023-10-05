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

var markers = JSON.parse(markerJson);
var markers = [
    {
        id: 1,
        photoName: '77069d90-e7e1-47a9-b5e0-41d70e45a956.webp',
        type: 'apple',
        lat: 50.373380,
        lng: -4.142650,
        timestamp: 1633440000,
        createdBy: 'John Doe',
        season: 'Spring', // Example season field
        location: 'Garden', // Example location field
    },
    {
        id: 2,
        photoName: 'andere-foto-naam.webp',
        type: 'apple',
        lat: 50.370380,
        lng: -4.142650,
        timestamp: 1633441200,
        createdBy: 'Jane Smith',
        season: 'Summer', // Example season field
        location: 'Orchard', // Example location field
    },
    // Add more marker data as needed
];

markers.forEach(markerInfo => {
    var marker = L.marker([markerInfo.lat, markerInfo.lng]).addTo(map);

    // Create a Date object from the timestamp
    var timestamp = new Date(markerInfo.timestamp);

    // Generate the photo URL based on the photo name
    var photoUrl = generatePhotoUrl(markerInfo.photoName);

    // Create a container div for styling purposes
    var popupContent = document.createElement('div');
    popupContent.className = 'popup-container';

    // Create HTML elements for each piece of information
    var typeElement = document.createElement('p');
    typeElement.textContent = 'Type: ' + markerInfo.type;
    var createdByElement = document.createElement('p');
    createdByElement.textContent = 'Created by: ' + markerInfo.createdBy;
    var timestampElement = document.createElement('p');
    timestampElement.textContent = 'Timestamp: ' + timestamp.toLocaleString();
    var seasonElement = document.createElement('p');
    seasonElement.textContent = 'Season: ' + markerInfo.season;
    var locationElement = document.createElement('p');
    locationElement.textContent = 'Location: ' + markerInfo.location;
    var imgElement = document.createElement('img');
    imgElement.src = photoUrl;
    imgElement.alt = 'Marker Photo';
    imgElement.className = 'popup-img';
    timestampElement.className = 'timestamp';
    typeElement.className = 'type';

    // Append each element to the container
    popupContent.appendChild(imgElement);
    popupContent.appendChild(typeElement);
    popupContent.appendChild(createdByElement);
    popupContent.appendChild(timestampElement);
    popupContent.appendChild(seasonElement);
    popupContent.appendChild(locationElement);

    marker.bindPopup(popupContent, {
        className: 'custom-popup'
    });

    function generatePhotoUrl(photoName) {
        // Replace this with your logic to generate the correct photo URL based on the name
        // For example, if the photos are in the same directory as the HTML page:
        return `Images/${photoName}`;
    }
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
