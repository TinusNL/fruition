<?php
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

// Check if there is an item present in GET
if (isset($_GET['item'])) {
    include 'approve.php';
    exit;
}

// Show a list of submissions
$unapproved_submissions = Item::getUnapprovedSubmissions();
?>

<div class="submission_wrapper">
    <a href="/<?php echo URL_PREFIX; ?>/admin" class="submissions_back">Back</a>
    <h1 class="submissions_title">Unapproved submissions</h1>
    <div class="submissions_container">
        <div class="submissions_table-wrapper">
            <table class="submissions_table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Author</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <?php foreach ($unapproved_submissions as $submission) : ?>
                    <?php
                    // Get the item's image
                    $image = FileManager::getSubmissionImage($submission->id);

                    // Get the item's author
                    $author = $submission->author;

                    // Get the item's type
                    $type = Type::get($submission->typeId);

                    // Get the location of the item by its coordinates
                    $location = Location::getMapsLink($submission->longitude, $submission->latitude);
                    ?>
                    <tr>
                        <td>
                            <img src="../<?php echo $image; ?>" alt="Image of <?php echo $submission->typeName; ?>">
                            <p><?php echo $submission->typeName; ?></p>
                        </td>
                        <td><?php echo $author; ?></td>
                        <td><a href="<?php echo $location; ?>" target="_blank">View on Google Maps</a></td>
                        <td>
                            <a href="/<?php echo URL_PREFIX; ?>/admin/submissions?item=<?php echo $submission->id; ?>">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <img src="/<?php echo URL_PREFIX; ?>/assets/logo.svg" alt="Logo" class="submissions_logo">
</div>
