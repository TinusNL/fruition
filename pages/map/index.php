<?php include 'components/header.php' ?>

<div class="map">
    <div class="icon">
        <a href="#" id="chat-button" class="collapsible"><img src="./<?= Router::getOffset() ?>assets/icons/chat.svg" alt=""></a>
        <a href="./faq"><img src="./<?= Router::getOffset() ?>assets/icons/questionmark.svg" alt=""></a>
    </div>
    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- Easybutton -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.css">
    <script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script>

    <div id="leaflet-map"></div>
    <?php include 'components/chatbot.php' ?>


    <?php
    // Get itemResults from the database
    $markerJSON = Item::getAllJson($_GET['season'] ?? null, ($_GET['favorites'] ?? null) == 'on');
    ?>

    <script>
        const markerJson = '<?= !empty($markerJSON) ? $markerJSON : '[]' ?>';
        const loggedIn = <?= intval(isset($_SESSION['user_id'])) ?>;
    </script>

    <script src="./<?= Router::getOffset() ?>scripts/leaflet_icons.js"></script>
    <script src="./<?= Router::getOffset() ?>scripts/leaflet.js"></script>
</div>