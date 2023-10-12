<?php

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    die();
}

$data = json_decode(file_get_contents('php://input'), true);

$stmt = Database::prepare("DELETE FROM favorites WHERE user = :user AND item = :item;");
$stmt->bindParam(':user', $_SESSION['user_id']);
$stmt->bindParam(':item', $data['id']);
$stmt->execute();

http_response_code(200);
die();
