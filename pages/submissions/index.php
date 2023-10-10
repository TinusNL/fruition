<div>
<form action="submissions/send" method="post">
        Email <input type="email" name="email"><br>

        <label for="plant_name">Plant Name:</label>
        <input type="text" name="plant_name" required><br><br>

        
            
        <label for="location">Location:</label>
        <input type="text" name="location" id="location" required>
        <button type="button" id="getLocationButton">Get Location</button><br><br>

        <label for="photo">Photo:</label>
        <input type="file" name="photo"  required><br><br>

        <!-- Select element for season -->
        <label for="season">Season:</label>
        <select name="season" required>
            <option value="" disabled selected>Select a season</option>
            <option value="1">1. Autumn</option>
            <option value="2">2. Spring</option>
            <option value="3">3. Summer</option>
            <option value="4">4. Winter</option>
        </select><br><br>

        <label for="types">types:</label>
        <select name="types" required>
            <option value="" disabled selected>Select a type</option>
            <option value="1">1. Food</option>
            <option value="2">2. Unknown</option>
        </select><br><br>

        <!-- Hidden fields to store latitude and longitude -->
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">

        <button type="submit" id="send" name="send">Send</button>
    </form>

    <script>
         function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;
                    document.getElementById("latitude").value = latitude;
                    document.getElementById("longitude").value = longitude;
                    document.getElementById("location").value = latitude + " " + longitude;
                }, function (error) {
                    // Handle location error here
                    console.error(error.message);
                });
            } else {
                document.getElementById("location").value = "Geolocation is not supported in this browser.";
            }
        }

        // Attach the getLocation function to a button click event
        document.getElementById("getLocationButton").addEventListener("click", getLocation);
    </script>
</div>