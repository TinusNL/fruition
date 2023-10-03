
<div>
    <?php
    // Process the form when it is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect data from the form
        $location = $_POST["location"];
        $name = $_POST["name"];
        $fruitType = $_POST["fruitType"];
        $description = $_POST["description"];

        // Photo upload processing
        if (isset($_FILES["photo"])) {
            $uploadDir = "uploads/";
            $uploadFile = $uploadDir . basename($_FILES["photo"]["name"]);
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $uploadFile)) {
                echo "The photo has been successfully uploaded.";
            } else {
                echo "An error occurred while uploading the photo.";
            }
        }

        // Here you can add the logic for sending the confirmation email

        // Example: Send a simple confirmation email
        $to = "your@email.com";
        $subject = "Form Confirmation";
        $message = "Location: $location\n";
        $message .= "Name: $name\n";
        $message .= "Fruit Type: $fruitType\n";
        $message .= "Description: $description\n";
        $headers = "From: webmaster@example.com";

        mail($to, $subject, $message, $headers);
    }
    ?>

    <h2>Form</h2>
    <form method="post" enctype="multipart/form-data">
        <label for="location">Location:</label>
        <input type="text" name="location" required><br>

        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="fruitType">Fruit Type:</label>
        <input type="text" name="fruitType" required><br>

        <label for="photo">Upload Photo:</label>
        <input type="file" name="photo" accept="image/*"><br>

        <label for="description">Description:</label><br>
        <textarea name="description" rows="4" cols="50" required></textarea><br>

        <input type="submit" value="Submit">
    </form>
</div>

