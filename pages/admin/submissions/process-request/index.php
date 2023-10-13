<?php
$item = $_POST['item'];

// Check whether the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo '<script type="text/javascript">
        window.location = "/' . URL_PREFIX . '/login"
    </script>';
    exit;
}

// Check whether the user is an admin
$user_role = User::getRole($_SESSION['user_id']);

if ($user_role != (3 || 4)) {
    echo '<script type="text/javascript">
        window.location = "/' . URL_PREFIX . '/"
    </script>';
    exit;
}

// Check whether the item exists
if (!Item::exists($item)) {
    echo '<script type="text/javascript">
        window.location = "/' . URL_PREFIX . '/admin/submissions"
    </script>';
    exit;
}

// Check whether the item has already been approved
if (Item::isApproved($item)) {
    echo '<script type="text/javascript">
        window.location = "/' . URL_PREFIX . '/admin/submissions"
    </script>';
    exit;
}

// Get the item's author
$item = Item::get($item);
$itemId = $item->id;
$to = $item->author;

if (isset($_POST['approve'])) {

    // Approve the item
    $stmt = Database::prepare("UPDATE submissions SET approved = 1 WHERE item = :itemId");
    $stmt->bindParam(':itemId', $itemId);
    $stmt->execute();

    // Email the author
    Mailer::send_approved_email($to, $itemId);
}

if (isset($_POST['reject'])) {
    // Delete the submission
    $stmt = Database::prepare("DELETE FROM submissions WHERE item = :itemId");
    $stmt->bindParam(':itemId', $itemId);
    $stmt->execute();

    // Reject the item by deleting it
    $stmt = Database::prepare("DELETE FROM items WHERE id = :itemId");
    $stmt->bindParam(':itemId', $itemId);
    $stmt->execute();

    // Email the author
    Mailer::send_rejected_email($to);
}

// Redirect to the admin submissions page
echo '<script type="text/javascript">
    window.location = "/' . URL_PREFIX . '/admin/submissions"
</script>';
exit;