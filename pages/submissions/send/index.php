<?php
use  PHPMailer\PHPMailer\PHPMailer;
use  PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$conn = new Database;


if (isset($_POST['send'])) {
    if (isset($_POST["short_desc"], $_POST["types"], $_FILES["photo"], $_POST["location"]) && $_FILES["photo"]["error"] === 0) {
        $imgContent = file_get_contents($_FILES["photo"]["tmp_name"]);
        
        $stmt = $conn->prepare("INSERT INTO `images` (`data`) VALUES (:data)");
        $stmt->bindParam(':data', $imgContent, PDO::PARAM_LOB);
        $stmt->execute();
        $photo_id = $conn->lastInsertId();

        $id = $_SESSION['user_id'];
        $short_desc = $_POST["short_desc"];
        $type = $_POST["types"];

        // Split into long and lat
        $location = explode(" ", $_POST["location"]);
        $longitude = $location[0];
        $latitude = $location[1];
        
        $stmt = $conn->prepare("INSERT INTO items (author, description, type, image, longitude, latitude) VALUES (:author, :short_desc, :type, :image, :long, :lat)");
        $stmt->bindParam(':author', $id, PDO::PARAM_INT);
        $stmt->bindParam(':short_desc', $short_desc, PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, PDO::PARAM_INT);
        $stmt->bindParam(':image', $photo_id, PDO::PARAM_INT);
        $stmt->bindParam(':long', $longitude, PDO::PARAM_STR);
        $stmt->bindParam(':lat', $latitude, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "Data has been inserted successfully!";
        } else {
            echo "Error inserting data: " . $stmt->error;
        }
    } else {
        echo "Not all required fields are filled in.";
    }

    if (!empty($_POST['email'])) {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'fruitioneuropa@gmail.com';
        $mail->Password = 'kckqnopsmgiehsux';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('fruitioneuropa@gmail.com');

        $mail->addAddress($_POST['email']);

        $mail->isHTML(true);

        $body = "Name: " . $_POST['plant_name']. "<br>";
        $body .= "Location: " . $_POST['location']. "<br>". "Season:  ". $_POST['season']. "<br>". "Type: ".$_POST['types'];

        

        $mail->Subject = "Thank you for ur submission!";
        $mail->Body = $body;
        // $mail->$attachment = chunk_split(base64_encode(file_get_contents($_POST['photo'])));
    

        
        $mail->send();
    }

    echo '<script type="text/javascript">
        window.location = "/' . URL_PREFIX . '/"
    </script>';
    exit();
}
?>