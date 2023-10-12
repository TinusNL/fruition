<?php
if (!isset($_GET['item_id'])) {
    http_response_code(401);
    die();
}

$stmt = Database::prepare("
        SELECT
            img.data AS image
        FROM
            items i,
            images img
        WHERE
            i.id = :item_id");

$stmt->bindParam(':item_id', $_GET['item_id']);
$stmt->execute();

$image = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$image) {
    http_response_code(404);
    die();
}

// Convert to base64
$imageData = base64_encode($image['image']);

// Return the image
echo json_encode($imageData);

http_response_code(200);
die();