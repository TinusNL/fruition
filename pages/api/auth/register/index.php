<?php

$result = User::register($_POST);

if (!$result) {
    http_response_code(404);
    die();
}

echo json_encode($result);

http_response_code(200);
die();