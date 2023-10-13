<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$conn = new Database;

function send_email($type, $longitude, $latitude): void
{
    if (!empty($_SESSION['user_email'])) {
        // Get a type from database
        try {
            $stmt = Database::prepare("SELECT * FROM types WHERE id = :id");
            $stmt->bindParam(':id', $type);
            $stmt->execute();
            $type = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // TODO: add logger
        }

        // Send email
        try {
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.stackmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'no-reply@fruition.city';
            $mail->Password = ']wQ=]]Kz~€F|';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('no-reply@fruition.city');
            $mail->addAddress($_SESSION['user_email']);

            $mail->isHTML(true);

            // Set the subject
            $mail->Subject = 'Your contribution has been received!';

            // Construct a map link using $longitude and $latitude
            $map_link = "https://www.google.com/maps/dir/?api=1&destination=" . $longitude . "," . $latitude;

            $body = "
                <html>
                    <head>
                        <title>Submission</title>
                    </head>
                    <body>
                        <h1>Your contribution has been received!</h1>
                        <p>Thank you for your submission. We will review it as soon as possible.</p>
                        <br>
                        <h2>Details</h2>
                        <p>Short description: " . $_POST['short_desc'] . "</p>
                        <p>Type: " . $type['label'] . "</p>
                        <p><a href='" . $map_link . "'>Click here to view the location on Google Maps</a></p>
                        <p>The image you've provided should be in the attachment</p>
                        <br>
                        <p>Kind regards,</p>
                        <p>The Fruition team</p>
                        <img src='cid:logoPNG' alt='Fruition logo' width='100px'>
                        
                        <p style='font-size: 10px;'>This email was sent automatically. Please do not reply to this email.</p>
                    </body>
                </html>
                ";
            $mail->Body = $body;
            $mail->AddEmbeddedImage('assets/logo.png', 'logoPNG');
            $mail->addAttachment($_FILES["photo"]["tmp_name"], $_FILES["photo"]["name"]);

            $mail->send();
        } catch (Exception $e) {
            // TODO: add logger
        }
    }
}

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
            send_email($type, $longitude, $latitude);
        }
    }

    echo '<script type="text/javascript">
        window.location = "/' . URL_PREFIX . '/"
    </script>';
    exit();
}
?>