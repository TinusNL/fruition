<?php
$item = $_GET['item'];

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

// Show the approval request
$item = Item::get($item);

// Get the item's image
$image = FileManager::getSubmissionImage($item->id);

// Get the item's author
$author = User::get($item->author);

// Get the item's type
$type = Type::get($item->typeId);

// Get the location of the item by its coordinates
$location = Location::getMapsLink($item->longitude, $item->latitude);
?>

<div class="approval_wrapper">
    <a href="/<?php echo URL_PREFIX; ?>/admin" class="submissions_back">Back</a>
    <h1 class="title">Approve Item</h1>
    <div class="approve_container">
        <div class="approve_image">
            <img src="../<?php echo $image; ?>" alt="Image of <?php echo $item->typeName; ?>">
        </div>
        <div class="approve_info">
            <h1><?php echo $item->typeName; ?></h1>
            <h2>By: <?php echo $item->author; ?></h2>
            <p><?php echo $item->description; ?></p>
            <a href="<?php echo $location; ?>" target="_blank">View on Google Maps</a>
            <div class="approve_buttons">
                <form action="/<?= URL_PREFIX ?>/admin/submissions/process-request" method="POST" class="approve_form">
                    <input type="hidden" name="item" value="<?php echo $item->id; ?>">
                    <input type="submit" name="approve" value="Approve">
                    <input type="submit" name="reject" value="Deny">
                </form>
            </div>
        </div>
    </div>

    <img src="/<?php echo URL_PREFIX; ?>/assets/logo.svg" alt="Logo" class="logo">
</div>