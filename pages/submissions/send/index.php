<?php
use  PHPMailer\PHPMailer\PHPMailer;
use  PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['send'])) {
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

    $body = "Plant name: " . $_POST['plant_name']. "<br>";
    $body .= "Location: " . $_POST['location']. "<br>";
    
    $body .= "Start date: " . $_POST['start_date']. "<br>";
    $body .= "End date: " . $_POST['end_date']. "<br>";

    $mail->Subject = "Thank you for ur submission!";
    $mail->Body = $body;
    $mail->AddAttachment = $_POST['photo'];
   
    // $mail->Body = $_POST['location'];
    // $mail->Body = $_POST['photo'];
    // $mail->Body = $_POST['start_date'];
    // $mail->Body = $_POST['end_date'];
    
    $mail->send();


    
if(isset($_POST['send'])) {
    header("Location: http://localhost/fruition");
    exit();
}

}
?>