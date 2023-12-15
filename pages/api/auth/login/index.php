<?php

$result = User::login($_POST['email'], $_POST['password']);

if (!$result) {
    http_response_code(404);
    die();
}

User::createUserSession($result);

http_response_code(200);