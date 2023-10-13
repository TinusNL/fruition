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

// Show the admin panel
?>
<a href="/<?php echo URL_PREFIX; ?>/admin" class="submissions_back">Back</a>
<h1 class="title">Admin Panel</h1>
<div class="admin_container">
    <div class="admin_item">
        <h1>Manage Users</h1>
        <p>Manage the users of the website.</p>
        <a href="/<?php echo URL_PREFIX; ?>/admin/users">Manage</a>
    </div>
    <div class="admin_item">
        <h1>Manage Submissions</h1>
        <p>Manage the submissions of the website.</p>
        <a href="/<?php echo URL_PREFIX; ?>/admin/submissions">Manage</a>
    </div>
</div>
