<?php
    // When the application is finished, remove following lines: 3-8
    $dev = true;
    if ($dev) {
        $userId = $_SESSION['user_id'] ?? 1;
    } else {
        $userId = $_SESSION['user_id'];
    }

    if($userId == '') {
        header('Location: /' . URL_PREFIX . '/');
    }

    // get the user from the database
    $stmt = Database::prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($user['profile_image'])) {
        $profile_picture = base64_encode($user['profile_image']);
    } else {
        // Load the default picture and store it in the $default_picture variable
        $default_picture = file_get_contents('././assets/default_profile.png');
        $profile_picture = base64_encode($default_picture);
    }
?>

<main class="main">
    <div class="alter-account">
    <a href="/<?= URL_PREFIX ?>/">Go back</a>
        <h1 class="alter-account-text">Alter Account</h1>
        <div class="form alter-ac-form">
            <form action="/<?= URL_PREFIX ?>/alter-account/process-request" method="post" enctype="multipart/form-data">
                <div class="container_aa">
                    <div class="left_side">
                        <label for="username">Username</label><br>
                        <input type="text" name="username" id="username" value="<?= $user['username'] ?>"><br>

                        <label for="email">Email</label><br>
                        <input type="email" name="email" id="email" value="<?= $user['email'] ?>"><br>
                    </div>

                    <div class="right_side">
                        <label for="profile-picture">Profile picture</label><br>
                        <img style="width:100px;height:100px;" src="data:image/*;base64,<?= $profile_picture ?>" alt="Profile picture">
                        <input type="file" name="profile-picture" id="profile-picture" accept="image/*" style="display:none">
                        <button onclick="document.getElementById('profile-picture').click()">Upload picture</button>
                        <br>
                    </div>
                </div>

                <label for="current-password">Current password</label><br>
                <input type="password" name="current-password" id="current-password"><br>

                <label for="password">New password</label><br>
                <input type="password" name="password" id="password"><br>

                <label for="confirm-password">Confirm new password</label>
                <input type="password" name="confirm-password" id="confirm-password">
                
                <button type="submit" name="alter-account">Submit</button>
                <p>Or delete your account & data here</p>
            </form>
            
            <form action="/<?= URL_PREFIX ?>/alter-account/process-request" method="post">
                <button type="submit" name="delete-account">Delete account</button>
            </form>
        </div>
    </div>
</main>