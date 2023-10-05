<div>
    <form action="submissions/send" method="post">
        
        
      

        

        Email <input type="email"  name="email"> <br>

        <label for="plant_name">Plant Name:</label>
        <input type="text" name="plant_name" required><br><br>

        <label for="location">Location:</label>
        <input type="text" name="location" required><br><br>

        <label for="photo">Photo:</label>
        <input type="file" name="photo" accept="image/*" required><br><br>

        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" required><br><br>

        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" required><br><br>

        

        <button type="submit" id="send" name="send">Send</button>

    </form>
</div>
