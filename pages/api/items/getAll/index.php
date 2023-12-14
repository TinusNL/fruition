<?php

$result = Item::getAllJson(null, false);

if (!$result) {
    http_response_code(404);
    die();
}

// Return the image
echo $result;

http_response_code(200);
die();
