

<div class="sub-div">
    <form class="sub-form" action="submissions/send" method="post">

            
            <h1>Submit a location</h1>
            
            <label for="plant_name"> Name:</label>
            <input type="text" name="plant_name" required>

            
            <label for="location">Location:</label>
            <div class="row">
                <input type="text" name="location" id="location" required>
                <button type="button" id="getLocationButton">Get Location</button>
            </div>

            
<div class="row">
        <div class="column">

            <label for="types">types:</label>
            
            <select id="select" name="types" required>
                <option value="" disabled selected>Select a type</option>
                <option value="1">1. Food</option>
                <option value="2">2. Unknown</option>

            </select>
        </div>
        

            
        <div class="column">
            <!-- Select element for season -->
            <label for="season">Season:</label>
            <select id="select" name="season" required>
                <option value="" disabled selected>Select a season</option>
                <option value="1">1. Autumn</option>
                <option value="2">2. Spring</option>
                <option value="3">3. Summer</option>
                <option value="4">4. Winter</option>
            </select>
        
        </div>
        </div>

            <label for="photo">Image:</label>
            <input type="file" name="photo" id="fileInput" style="display:none;" required>
            <button type="button" class="photo-button" onclick="document.getElementById('fileInput').click()">Upload image</button>
            
            <!-- Hidden fields to store latitude and longitude -->
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <div class="button-container">
                <button type="submit" id="send" name="send">Submit</button>
                <button onclick="history.go(-1);">Back</button>
                
            </div>
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


