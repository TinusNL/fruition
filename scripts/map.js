// Define a MapApp class
class MapApp {
    constructor() {
        this.map = null;
        this.marker = null;
        this.initializeMap();
        this.initializeSearch();
    }

    initializeMap() {
        this.map = L.map('map').setView([51.505, -0.09], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(this.map);
    }

    initializeSearch() {
        const searchBox = document.getElementById('search-box');

        searchBox.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                const searchText = searchBox.value;
                if (searchText) {
                    // Uses Nominatim for searching locations
                    fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + searchText)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                const result = data[0];
                                const latlng = [parseFloat(result.lat), parseFloat(result.lon)];

                                // Removes the previous marker, if it exists
                                if (this.marker) {
                                    this.map.removeLayer(this.marker);
                                }

                                // Adds a new marker for the current location
                                this.marker = L.marker(latlng).addTo(this.map)
                                    .bindPopup(result.display_name)
                                    .on('popupclose', () => {
                                        // Removes the marker when the popup is closed
                                        this.map.removeLayer(this.marker);
                                    });
                                this.marker.openPopup();
                                this.map.setView(latlng, 15);
                            } else {
                                alert('Location not found.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            }
        });
    }
}

// Creates an instance of the MapApp class 
const mapApp = new MapApp();
