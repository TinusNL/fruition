<?php

$result = User::login($_POST['email'], $_POST['password']);

if (!$result) {
    http_response_code(401);
    die();
}

// Delete favorites
$stmt = Database::prepare("DELETE FROM favorites WHERE user = :user AND item = :item");
$stmt->bindParam(':user', $result['id']);
$stmt->bindParam(':item', $_POST['item']);
$stmt->execute();

$newStatus = $stmt->rowCount() === 0;

if ($newStatus) {
    // Add favorites
    $stmt = Database::prepare("INSERT INTO favorites (user, item) VALUES (:user, :item)");
    $stmt->bindParam(':user', $result['id']);
    $stmt->bindParam(':item', $_POST['item']);
    $stmt->execute();
}

echo json_encode([
    'status' => $newStatus
]);

http_response_code(200);
die();

