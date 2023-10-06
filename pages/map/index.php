<head>
    <link rel="stylesheet" href="/src/scss/pages/map.scss" />
</head>

<body class="map">
    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- Easybutton -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.css">
    <script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script>

    <div id="leaflet-map"></div>
    <script>
        var markerJson = '[{"id":1,"photoName":"77069d90-e7e1-47a9-b5e0-41d70e45a956.webp","type":"apple","lat":50.373380,"lng":-4.142650,"timestamp":1633440000,"createdBy":"John Doe", "userId": 123, "name": "Apple Tree 1", "typeId": 1, "seasonId": 2}, {"id":2,"type":"apple","lat":50.370380,"lng":-4.142650,"timestamp":1633441200,"createdBy":"Jane Smith","photoName":"andere-foto-naam.webp", "userId": 456, "name": "Apple Tree 2", "typeId": 1, "seasonId": 3}]';
    </script>
    <script src="./scripts/leaflet.js"></script>
</body>

<?php

// function getMarkerData($mysqli)
// {
//     $query = "SELECT * FROM EXAMPLE_TABLE";
//     $result = $mysqli->query($query);

//     if ($result->num_rows > 0) {
//         $data = array();

//         while ($row = $result->fetch_assoc()) {
//             $data[] = $row;
//         }

//         return json_encode($data);
//     } else {
//         return "[]"; 
//     }
// }

// $markerJSON = getMarkerData($mysqli);

// $mysqli->close();

?>
