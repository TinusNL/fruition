<?php
$conn = new Database;

if (isset($_POST['send'])) {
    if (isset($_POST["short_desc"], $_POST["types"], $_FILES["photo"], $_POST["location"]) && $_FILES["photo"]["error"] === 0) {
        $imgContent = file_get_contents($_FILES["photo"]["tmp_name"]);

        $id = $_SESSION['user_id'];
        $short_desc = $_POST["short_desc"];
        $type = $_POST["types"];

        // Split into long and lat
        $location = explode(" ", $_POST["location"]);
        $longitude = $location[0];
        $latitude = $location[1];
        
        $stmt = $conn->prepare("INSERT INTO items (author, description, type, longitude, latitude) VALUES (:author, :short_desc, :type, :long, :lat)");
        $stmt->bindParam(':author', $id, PDO::PARAM_INT);
        $stmt->bindParam(':short_desc', $short_desc, PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, PDO::PARAM_INT);
        $stmt->bindParam(':long', $longitude, PDO::PARAM_STR);
        $stmt->bindParam(':lat', $latitude, PDO::PARAM_STR);
        $stmt->execute();

        // Get the item id
        $item_id = $conn->lastInsertId();

        // Upload the image
        try {
            FileManager::uploadSubmissionImage($_FILES["photo"], $item_id);
        } catch (Exception $e) {
            // TODO: add logger
        }

        // Find everyone with the admin role
        $stmt = $conn->prepare("SELECT id FROM users WHERE role = 3");
        $stmt->execute();
        $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Find the admin with the least unapproved submissions
        foreach ($admins as $admin) {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM submissions WHERE author = :adminId AND approved = 0");
            $stmt->bindParam(':adminId', $admin['id'], PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!isset($least) || $count['COUNT(*)'] < $least) {
                $least = $count['COUNT(*)'];
                $least_admin = $admin['id'];
            }
        }

        $chosen_admin = $least_admin ?? 1;

        // Insert the submission
        $stmt = $conn->prepare("INSERT INTO submissions (author, item) VALUES (:author, :item)");
        $stmt->bindParam(':author', $chosen_admin, PDO::PARAM_INT);
        $stmt->bindParam(':item', $item_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            Mailer::send_approval_email($item_id);
            Mailer::send_submission_email($type, $longitude, $latitude);
        }
    }

    echo '<script type="text/javascript">
        window.location = "/' . URL_PREFIX . '/"
    </script>';
    exit();
}
?>