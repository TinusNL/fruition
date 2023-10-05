<?php
$dev = true;
if ($dev) {
    $userId = $_SESSION['user_id'] ?? 12;
} else {
    $userId = $_SESSION['user_id'];
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['alter-account'])) {
        if(!empty($_POST['username']) && !empty($_POST['current-password']) && !empty($_POST['password']) && !empty($_POST['confirm-password']) && !empty($_POST['email']) && !empty($_POST['phone-number'])) {
            if(isset($_FILES['profile-picture']) && $_FILES['profile-picture']['error'] === 0) {
                // Get the image data
                $imgContent = file_get_contents($_FILES['profile-picture']['tmp_name']);
    
                // Assuming $userId is properly set
                $stmt = Database::prepare("UPDATE users SET profile_image = :profile_image WHERE id = :id");
                $stmt->bindParam(':profile_image', $imgContent, PDO::PARAM_LOB);
                $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
                $stmt->execute();
    
                // Optionally, you can save $imgContent in a variable to use it in your HTML later
                $newProfilePicture = $imgContent;
            }

            $newUsername = $_POST['username'];
            $newPassword = $_POST['password'];
            $newPasswordConfirm = $_POST['confirm-password'];
            $newEmail = $_POST['email'];
            $newPhoneNumber = $_POST['phone-number'];

            $stmt = Database::prepare("UPDATE users SET username = :username, password = :password, email = :email, phone_number = :phone_number WHERE id = :id");
            $stmt->bindParam(':username', $newUsername);
            $stmt->bindParam(':password', $newPassword);
            $stmt->bindParam(':email', $newEmail);
            $stmt->bindParam(':phone_number', $newPhoneNumber);
            $stmt->bindParam(':id', $userId);
            $stmt->execute();

            header('Location: /' . URL_PREFIX . '/alter-account/');
        }
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