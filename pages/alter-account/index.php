<?php
    $dev = true;
    if ($dev) {
        $userId = $_SESSION['user_id'] ?? 12;
    } else {
        $userId = $_SESSION['user_id'];
    }

    if($userId == '') {
        header('Location: /' . URL_PREFIX . '/');
    }

    // get the user form the database
    $stmt = Database::prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<style>
    form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    label {
        margin-top: 1rem;
    }

    input {
        margin-top: 0.5rem;
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 20rem;
    }

    button {
        margin-top: 1rem;
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 20rem;
        background-color: #ccc;
        cursor: pointer;
    }

    button:hover {
        background-color: #ddd;
    }

    .alter-account {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

</style>
<main class="main">
    <div class="alter-account">
        <div class="form">
            <form action="/<?= URL_PREFIX ?>/alter-account/process-request" method="post" enctype="multipart/form-data">
                <input type="hidden" name="user_id" data-value="<?= $_SESSION['user_id'] ?>">

                <label for="profile-picture">Profile picture</label>
                <img style="width:100px;height:100px;" src="data:image/*;base64,<?= base64_encode($user['profile_image']) ?>" alt="Profile picture">
                <input type="file" name="profile-picture" id="profile-picture" accept="image/*">

                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="<?= $user['username'] ?>">

                <label for="current-password">Current password</label>
                <input type="password" name="current-password" id="current-password">

                <label for="password">New password</label>
                <input type="password" name="password" id="password">

                <label for="confirm-password">Confirm new password</label>
                <input type="password" name="confirm-password" id="confirm-password">
                
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?= $user['email'] ?>">

                <label for="phone-number">Phone number</label>
                <input type="tel" name="phone-number" id="phone-number" value="<?= $user['phone_number'] ?>">

                <button type="submit" name="alter-account">Submit</button>
                <p>Or delete your account & data here</p>
            </form>
            
            <form action="/<?= URL_PREFIX ?>/alter-account/process-request" method="post">
                <button type="submit" name="delete-account">Delete account</button>
            </form>
        </div>
    </div>

    <!-- <div class="users">
        <table>
            <thead>
                <tr>
                    <th>Profile picture</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Email</th>
                    <th>Phone number</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><img src="<?= $user['profile_image'] ?>" alt="Profile picture" width="100px" height="100px"></td>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['password'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['phone_number'] ?></td>
                </tr>
            </tbody>
        </table>
    </div> -->
</main>