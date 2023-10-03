
<div>
    <?php

    
    // Process the form when it is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect data from the form
        $location = $_POST["location"];
        $name = $_POST["name"];
        $fruitType = $_POST["fruitType"];
        $description = $_POST["description"];
        $email = $_POST["email"];

        // Photo upload processing
        if (isset($_FILES["photo"])) {
            $uploadDir = "uploads/";
            $uploadFile = $uploadDir . basename($_FILES["photo"]["name"]);
        }

        // Here you can add the logic for sending the confirmation email

        // Example: Send a simple confirmation email
        $to = $_POST["email"];
        $subject = "Form Confirmation";
        $message = "Location: $location\n";
        $message .= "Name: $name\n";
        $message .= "Fruit Type: $fruitType\n";
        $message .= "Description: $description\n";
        $headers = "From: asaadhajar6@gamail.com";

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

        <label for="email">Email:</label>
        <input type="email" name="email"><br>

        <input id="emailConfirmation" type="checkbox"><span class="checkmark"></span>
        <label for="emailConfirmation">Send me an mail</label><br>
        
        <label for="photo">Upload Photo:</label>
        <input type="file" name="photo" accept="image/*"><br>

        <label for="description">Description:</label><br>
        <textarea name="description" rows="4" cols="50" required></textarea><br>

        <input type="submit" value="Submit">
    </form>
</div>

