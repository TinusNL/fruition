<?php
if (!isset($_GET['item_id'])) {
    http_response_code(401);
    die();
}

// Get item image id
$stmt = Database::prepare("
        SELECT
            image
        FROM
            items
        WHERE
            id = :item_id");
$stmt->bindParam(':item_id', $_GET['item_id']);
$stmt->execute();

$imageId = $stmt->fetch(PDO::FETCH_ASSOC);

// Get the image from the images table using the id
$stmt = Database::prepare("
        SELECT
            data
        FROM
            images
        WHERE
            id = :image_id");
$stmt->bindParam(':image_id', $imageId['image']);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

$image = $result['data'];

if (!$image) {
    http_response_code(404);
    die();
}

// Convert to base64
$imageData = base64_encode($image);

// Return the image
echo json_encode($imageData);

http_response_code(200);
die();