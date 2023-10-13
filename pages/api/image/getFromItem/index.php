<?php
if (!isset($_GET['item_id'])) {
    http_response_code(401);
    die();
}

$item_id = intval($_GET['item_id']);

// Get item author id
$stmt = Database::prepare('SELECT author FROM items WHERE id = :id');
$stmt->bindParam(':id', $item_id);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);
$uid = $result['author'];

if (!$item_id || !$uid) {
    http_response_code(404);
    die();
}

// Return the image
echo FileManager::getSubmissionImage($item_id, $uid);

http_response_code(200);
die();
