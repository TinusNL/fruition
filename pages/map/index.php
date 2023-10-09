<?php include 'components/header.php' ?>

<div class="map">
    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- Easybutton -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.css">
    <script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script>

    <div id="leaflet-map"></div>
    <script>
        var markerJson = '<?= Item::getInRadiusJson(50.370380, -4.142650, 1) ?>';
        // console.log(markerJson);
    </script>
    <script src="./<?= Router::getOffset() ?>scripts/leaflet_icons.js"></script>
    <script src="./<?= Router::getOffset() ?>scripts/leaflet.js"></script>
</div>