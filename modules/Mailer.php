<?php
use JetBrains\PhpStorm\NoReturn;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    public static function send_signup_email($email, $username, $role): void
    {
        if (!empty($email || $username || $role)) {
            // Get a type from database
            try {
                $stmt = Database::prepare("SELECT * FROM roles WHERE id = :id");
                $stmt->bindParam(':id', $role);
                $stmt->execute();
                $role = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                Logger::log('Mailer', 'ERROR', $e);
            }

            $role = $role['name'];
            $role = ucfirst($role);

            // Send email
            try {
                $mail = self::getPHPMailer();
                $mail->addAddress($email);

                $mail->isHTML(true);

                // Set the subject
                $mail->Subject = 'Your account has been created!';

                $body = "
                <html lang='en'>
                    <head>
                        <title>Account creation</title>
                    </head>
                    <body>
                        <h1>Your account has been created!</h1>
                        <p>Thank you for registering. We hope you enjoy using our website.</p>
                        <br>
                        <h2>Details</h2>
                        <p>Username: " . $username . "</p>
                        <p>Role: " . $role . "</p>
                        <br>
                        <p><a href='https://fruition.city/" . URL_PREFIX . "'>Click here to log into your account</a></p>
                        <p>Kind regards,</p>
                        <p>The Fruition team</p>
                        <img src='cid:logoPNG' alt='Fruition logo' width='100px'>
                        
                        <p style='font-size: 10px;'>This email was sent automatically. Please do not reply to this email.</p>
                    </body>
                </html>
                ";
                $mail->Body = $body;
                $mail->AddEmbeddedImage('assets/logo.png', 'logoPNG');

                $mail->send();
            } catch (Exception $e) {
                Logger::log('Mailer', 'ERROR', $e);
            }
        }
    }

    public static function send_submission_email($type, $longitude, $latitude): void
    {
        if (!empty($_SESSION['user_email'])) {
            // Get a type from database
            try {
                $stmt = Database::prepare("SELECT * FROM types WHERE id = :id");
                $stmt->bindParam(':id', $type);
                $stmt->execute();
                $type = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                Logger::log('Mailer', 'ERROR', $e);
            }

            // Send email
            try {
                $mail = self::getPHPMailer();
                $mail->addAddress($_SESSION['user_email']);

                $mail->isHTML(true);

                // Set the subject
                $mail->Subject = 'Your contribution has been received!';

                // Construct a map link using $longitude and $latitude
                $map_link = "https://www.google.com/maps/dir/?api=1&destination=" . $longitude . "," . $latitude;

                $body = "
                <html lang='en'>
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
                Logger::log('Mailer', 'ERROR', $e);
            }
        }
    }

    public static function send_approved_email($to, $item): void
    {
        if (!empty($to || $item)) {
            $item = Item::get($item);
            $short_desc = $item->description;
            $type = $item->typeId;

            // Get a type from database
            try {
                $stmt = Database::prepare("SELECT * FROM types WHERE id = :id");
                $stmt->bindParam(':id', $type);
                $stmt->execute();
                $type = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                Logger::log('Mailer', 'ERROR', $e);
            }

            // Send email
            try {
                $mail = self::getPHPMailer();
                $mail->addAddress($to);

                $mail->isHTML(true);

                // Set the subject
                $mail->Subject = 'Your contribution has been approved!';

                // Construct a map link using $longitude and $latitude
                $longitude = $item->longitude;
                $latitude = $item->latitude;
                $map_link = Location::getMapsLink($longitude, $latitude);

                $body = "
                <html lang='en'>
                    <head>
                        <title>Submission</title>
                    </head>
                    <body>
                        <h1>Your contribution has been approved!</h1>
                        <p>Thank you for your submission. It has been approved by an admin and is now visible on the website.</p>
                        <br>
                        <h2>Details</h2>
                        <p>Short description: " . $short_desc . "</p>
                        <p>Type: " . $type['label'] . "</p>
                        <p><a href='" . $map_link . "'>Click here to view the location on Google Maps</a></p>
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

                $mail->send();
            } catch (Exception $e) {
                Logger::log('Mailer', 'ERROR', $e);
            }
        }
    }

    public static function send_rejected_email($to): void
    {
        if (!empty($to)) {
            // Send email
            try {
                $mail = self::getPHPMailer();
                $mail->addAddress($to);

                $mail->isHTML(true);

                // Set the subject
                $mail->Subject = 'Your contribution has been declined';

                $body = "
                <html lang='en'>
                    <head>
                        <title>Submission</title>
                    </head>
                    <body>
                        <h1>Your contribution has been declined.</h1>
                        <p>It appears that your submission has been declined by an admin. Please check your submission and try again.</p>
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

                $mail->send();
            } catch (Exception $e) {
                Logger::log('Mailer', 'ERROR', $e);
            }
        }
    }

    public static function send_approval_email($item): void
    {
        if (!empty($item)) {
            // Get the submission from database
            try {
                $stmt = Database::prepare("SELECT * FROM submissions WHERE item = :itemId");
                $stmt->bindParam(':itemId', $item);
                $stmt->execute();
                $submission = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                Logger::log('Mailer', 'ERROR', $e);
            }

            // Get the item from a database
            try {
                $stmt = Database::prepare("SELECT * FROM items WHERE id = :itemId");
                $stmt->bindParam(':itemId', $item);
                $stmt->execute();
                $item = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                Logger::log('Mailer', 'ERROR', $e);
            }

            // Get the authors email from a database
            try {
                $stmt = Database::prepare("SELECT email FROM users WHERE id = :authorId");
                $stmt->bindParam(':authorId', $item['author']);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                Logger::log('Mailer', 'ERROR', $e);
            }

            // Get the reviewer email from a database
            try {
                $stmt = Database::prepare("SELECT email FROM users WHERE id = :reviewerId");
                $stmt->bindParam(':reviewerId', $submission['author']);
                $stmt->execute();
                $reviewer = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                Logger::log('Mailer', 'ERROR', $e);
            }

            // Check if stuff is defined at this point
            if (!isset($submission, $item, $user, $reviewer)) {
                return;
            }

            // Set item details
            $type = $submission['type'];
            $longitude = $item['longitude'];
            $latitude = $item['latitude'];
            $reviewer_email = $reviewer['email'];

            // Get a type from database
            try {
                $stmt = Database::prepare("SELECT * FROM types WHERE id = :id");
                $stmt->bindParam(':id', $type);
                $stmt->execute();
                $type = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                Logger::log('Mailer', 'ERROR', $e);
            }

            // Send email
            try {
                $mail = self::getPHPMailer();
                $mail->addAddress($reviewer_email);

                $mail->isHTML(true);

                // Set the subject
                $mail->Subject = 'A submission needs your approval!';

                // Construct a map link using $longitude and $latitude
                $map_link = "https://www.google.com/maps/dir/?api=1&destination=" . $longitude . "," . $latitude;

                $body = "
                <html lang='en'>
                    <head>
                        <title>Approval</title>
                    </head>
                    <body>
                        <h1>A submission needs your approval!</h1>
                        <p>There is a new submission that needs your approval. Please review it as soon as possible.</p>
                        <br>
                        <h2>Details</h2>
                        <p>Short description: " . $item['description'] . "</p>
                        <p>Type: " . $type['label'] . "</p>
                        <p><a href='" . $map_link . "'>Click here to view the location on Google Maps</a></p>
                        <p>The image that was provided is attached to this email</p>
                        <hr style='border: 1px solid black;'>
                        <p><a href='https://fruition.city/" . URL_PREFIX . "/admin/submissions?item=" . $item['id'] . "'>Click here</a> to view the submission</p>
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
                Logger::log('Mailer', 'ERROR', $e);
            }
        }
    }

    /**
     * @return PHPMailer
     * @throws Exception
     */
    public static function getPHPMailer(): PHPMailer
    {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.stackmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@fruition.city';
        $mail->Password = ']wQ=]]Kz~€F|';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('no-reply@fruition.city');
        return $mail;
    }
}
