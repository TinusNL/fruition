<?php
    // When the application is finished, remove following lines: 3-8
    $dev = true;
    if ($dev) {
        $userId = $_SESSION['user_id'] ?? 12;
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
?>

<main class="main">
    <div class="alter-account">
        <div class="form">
            <form action="/<?= URL_PREFIX ?>/alter-account/process-request" method="post" enctype="multipart/form-data">
                <input type="hidden" name="user_id" data-value="<?= $userId ?>">

                <!-- <label for="profile-picture">Profile picture</label> -->
                <!-- Delete the inline style from image when app is finished and ready for styling. -->
                <!-- example ----→ <img src="" alt="Profile picture"> -->
                <!-- <img style="width:100px;height:100px;" src="data:image/*;base64,<?= base64_encode($user['profile_image']) ?>" alt="Profile picture"> -->
                <!-- <input type="file" name="profile-picture" id="profile-picture" accept="image/*"> -->

                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="<?= $user['username'] ?>">

                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?= $user['email'] ?>">
                
                <label for="phone-number">Phone number</label>
                <input type="tel" name="phone-number" id="phone-number" value="<?= $user['phone_number'] ?>">


                <label for="current-password">Current password</label>
                <input type="password" name="current-password" id="current-password">

                <label for="password">New password</label>
                <input type="password" name="password" id="password">

                <label for="confirm-password">Confirm new password</label>
                <input type="password" name="confirm-password" id="confirm-password">
                
                <button type="submit" name="alter-account">Submit</button>
                <p>Or delete your account & data here</p>
            </form>
            
            <form action="/<?= URL_PREFIX ?>/alter-account/process-request" method="post">
                <button type="submit" name="delete-account">Delete account</button>
            </form>            
            <a href="javascript:history.back()">Go back</a>
        </div>
    </div>
</main>