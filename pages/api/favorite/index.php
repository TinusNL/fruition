<?php

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    die();
}

$data = json_decode(file_get_contents('php://input'), true);

$stmt = Database::prepare("INSERT INTO favorites (user, item) VALUES (:user, :item)");
$stmt->bindParam(':user', $_SESSION['user_id']);
$stmt->bindParam(':item', $data['id']);
$stmt->execute();

http_response_code(200);
die();
