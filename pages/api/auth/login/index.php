<?php

$result = User::login($_POST['email'], $_POST['password']);

if (!$result) {
    http_response_code(404);
    die();
}

echo $result;

http_response_code(200);
die();
