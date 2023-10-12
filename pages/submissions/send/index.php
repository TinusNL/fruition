<?php
use  PHPMailer\PHPMailer\PHPMailer;
use  PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$conn = new Database;


if (isset($_POST['send'])) {
    
    if (isset($_POST["plant_name"], $_POST["types"], $_FILES["photo"], $_POST["season"], $_POST["location"]) && $_FILES["photo"]["error"] === 0) {
        $imgContent = file_get_contents($_FILES["photo"]["tmp_name"]);
        
        $stmt = $conn->prepare("INSERT INTO `images` (`data`) VALUES (:data)");
        $stmt->bindParam(':data', $imgContent, PDO::PARAM_LOB);
        $stmt->execute();
        $photo_id = $conn->lastInsertId();

        $id = $_SESSION['user_id'];
        $plant_name = $_POST["plant_name"];
        $type = $_POST["types"];
        $season = $_POST["season"];
        $location = $_POST["location"];
        
        $stmt = $conn->prepare("INSERT INTO items (userId, name, typeId, seasonId, location) VALUES (:id, :name, :type, :season, :location)");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $plant_name, PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, PDO::PARAM_INT);
        $stmt->bindParam(':photo', $photo_id, PDO::PARAM_INT);
        $stmt->bindParam(':season', $season, PDO::PARAM_INT);
        $stmt->bindParam(':location', $location, PDO::PARAM_STR);

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

    header("Location: http://localhost/fruition/map");
    exit();
}
?>