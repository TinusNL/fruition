<?php
$dev = false;
if ($dev) {
    $userId = $_SESSION['user_id'] ?? 11;
} else {
    $userId = $_SESSION['user_id'];
}

$conn = new Database;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['alter-account'])) {
        if(isset($_FILES['profile-picture']) && $_FILES['profile-picture']['error'] === 0) {
            // Add new profile picture
            try {
                FileManager::uploadProfileImage($_FILES['profile-picture']);
            } catch (Exception $e) {
                Logger::log('Alter account', 'ERROR', $e);
            }
        }

        if(!empty($_POST['username']) && !empty($_POST['email'])) {
            $newUsername = $_POST['username'];
            $newEmail = $_POST['email'];

            $stmt = $conn->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
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
            $stmt = $conn->prepare("SELECT password FROM users WHERE id = :id");
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!password_verify($currentPassword, $user['password'])) {
                echo '<script type="text/javascript">
                    window.location = "/' . URL_PREFIX . '/alter-account/"
                </script>';
                exit;
            }

            // check if the new password and the confirmation password are the same
            if($newPassword !== $newPasswordConfirm) {
                echo '<script type="text/javascript">
                    window.location = "/' . URL_PREFIX . '/alter-account/"
                </script>';
                exit;
            }

            // hash the new password
            $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = :password WHERE id = :id");
            $stmt->bindParam(':password', $newPassword);
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
        }

        echo '<script type="text/javascript">
            window.location = "/' . URL_PREFIX . '/alter-account/"
        </script>';
    }

    if (isset($_POST['delete-account'])) {
        if (isset($userId)) {
            // Check if the default user is still in the database
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = 'no-reply@fruition.city'");
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (empty($user)) {
                // Add the default user to the database
                try {
                    $stmt = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES ('deleted user', '', 'no-reply@fruition.city', 5)");
                    $stmt->execute();
                } catch (PDOException $e) {
                    Logger::log('Alter account', 'ERROR', $e);
                }

                $defaultUserId = $conn->lastInsertId();
            } else {
                $defaultUserId = $user['id'];
            }

            // If DELETED_USER_REMAINS is false, delete all items and favorites from the default user
            if (!DELETED_USER_REMAINS) {
                // First get the image id's from the default user and put them in an array
                try {
                    $stmt = $conn->prepare("SELECT image FROM items WHERE author = :userId");
                    $stmt->bindParam(':userId', $userId);
                    $stmt->execute();
                    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    Logger::log('Alter account', 'ERROR', $e);
                }

                // Delete the favorites
                try {
                    $stmt = $conn->prepare("DELETE FROM favorites WHERE user = :userId");
                    $stmt->bindParam(':userId', $userId);
                    $stmt->execute();
                } catch (PDOException $e) {
                    Logger::log('Alter account', 'ERROR', $e);
                }

                // Delete the items
                try {
                    $stmt = $conn->prepare("DELETE FROM items WHERE author = :userId");
                    $stmt->bindParam(':userId', $userId);
                    $stmt->execute();
                } catch (PDOException $e) {
                    Logger::log('Alter account', 'ERROR', $e);
                }

                // Delete the images
                $images = $images ?? [];
                foreach ($images as $image) {
                    try {
                        $stmt = $conn->prepare("DELETE FROM images WHERE id = :imageId");
                        $stmt->bindParam(':imageId', $image['image']);
                        $stmt->execute();
                    } catch (PDOException $e) {
                        Logger::log('Alter account', 'ERROR', $e);
                    }
                }
            } else {
                // Update all items from the user to the default user
                try {
                    $stmt = $conn->prepare("UPDATE items SET author = :defaultUserId WHERE author = :userId");
                    $stmt->bindParam(':defaultUserId', $defaultUserId);
                    $stmt->bindParam(':userId', $userId);
                    $stmt->execute();
                } catch (PDOException $e) {
                    Logger::log('Alter account', 'ERROR', $e);
                }

                // Update all favorites from the user to the default user
                try {
                    $stmt = $conn->prepare("UPDATE favorites SET user = :defaultUserId WHERE user = :userId");
                    $stmt->bindParam(':defaultUserId', $defaultUserId);
                    $stmt->bindParam(':userId', $userId);
                    $stmt->execute();
                } catch (PDOException $e) {
                    Logger::log('Alter account', 'ERROR', $e);
                }
            }

            // Get a profile picture
            try {
                $stmt = $conn->prepare("SELECT profile_image FROM users WHERE id = :userId");
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();

                $profileImage = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                Logger::log('Alter account', 'ERROR', $e);
            }

            // Delete user
            try {
                $stmt = $conn->prepare("DELETE FROM users WHERE id = :user_id");
                $stmt->bindParam(':user_id', $userId);
                $stmt->execute();
            } catch (PDOException $e) {
                Logger::log('Alter account', 'ERROR', $e);
            }

            // Delete profile picture
            try {
                $stmt = $conn->prepare("DELETE FROM images WHERE id = :image_id");
                $stmt->bindParam(':image_id', $profileImage['profile_image']);
                $stmt->execute();
            } catch (PDOException $e) {
                Logger::log('Alter account', 'ERROR', $e);
            }

            // Redirect using html
            echo '<script type="text/javascript">
                window.location = "/' . URL_PREFIX . '/logout"
            </script>';
            exit;
        }
    }
}

echo '<script type="text/javascript">
    window.location = "/' . URL_PREFIX . '/alter-account/"
</script>';
exit;
?>