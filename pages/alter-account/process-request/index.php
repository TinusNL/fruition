<?php
$dev = true;
if ($dev) {
    $userId = $_SESSION['user_id'] ?? 11;
} else {
    $userId = $_SESSION['user_id'];
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['alter-account'])) {
        if(isset($_FILES['profile-picture']) && $_FILES['profile-picture']['error'] === 0) {
            $imgContent = file_get_contents($_FILES['profile-picture']['tmp_name']);

            $stmt = Database::prepare("UPDATE users SET profile_image = :profile_image WHERE id = :id");
            $stmt->bindParam(':profile_image', $imgContent, PDO::PARAM_LOB);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            $stmt->execute();

            $newProfilePicture = $imgContent;
        }

        if(!empty($_POST['username']) && !empty($_POST['email'])) {
            $newUsername = $_POST['username'];
            $newEmail = $_POST['email'];

            $stmt = Database::prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
            $stmt->bindParam(':username', $newUsername);
            $stmt->bindParam(':email', $newEmail);
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
        }

        if(!empty($_POST['current-password']) && !empty($_POST['password']) && !empty($_POST['confirm-password'])) {
            $currentPassword = $_POST['current-password'];
            $newPassword = $_POST['password'];
            $newPasswordConfirm = $_POST['confirm-password'];

            // check if the current password is correct
            $stmt = Database::prepare("SELECT password FROM users WHERE id = :id");
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!password_verify($currentPassword, $user['password'])) {
                header('Location: /' . URL_PREFIX . '/alter-account/');
                exit;
            }

            // check if the new password and the confirm password are the same
            if($newPassword !== $newPasswordConfirm) {
                header('Location: /' . URL_PREFIX . '/alter-account/');
                exit;
            }

            // hash the new password
            $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = Database::prepare("UPDATE users SET password = :password WHERE id = :id");
            $stmt->bindParam(':password', $newPassword);
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
        }

        header('Location: /' . URL_PREFIX . '/alter-account/');
    }

    if (isset($_POST['delete-account'])) {
        if (isset($userId)) {
            $query = "DELETE FROM users WHERE id = :user_id";
            $stmt = Database::prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();

            header('Location: /' . URL_PREFIX . '/');
            exit;
        }
    }
}

header('Location: /' . URL_PREFIX . '/alter-account/');
?>