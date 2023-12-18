<?php

$result = Item::getInRadiusJson($_GET['longitude'], $_GET['latitude'], $_GET['radius']);

if (!$result) {
    http_response_code(404);
    die();
}

// Return the results
echo $result;

http_response_code(200);
die();
