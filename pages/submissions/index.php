<div class="sub-div">
    <form class="sub-form" action="submissions/send" method="post" enctype="multipart/form-data">
        <h1>Submit a location</h1>

        <label for="short_desc">Short description:</label>
        <input type="text" name="short_desc" required>

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
                    <?php
                    // Get all types from the database
                    $types = Type::getAll();
                    // Loop through the objects and create an option for each
                    foreach ($types as $type) {
                        echo "<option value='$type->id' data-attr-season='$type->seasonId'>$type->label</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="column">
                <!-- Select an element for season -->
                <label for="season">Season:</label>
                <input type="text" name="season" id="season" required placeholder="Select a type" disabled>
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
            <img src="./assets/logo_light.png" alt="logo" class="logo-mobile">
        </div>
    </form>

    <script>
        function getSeason() {
            const seasonList = <?= json_encode(Season::getAll()) ?>;
            const typeSelect = document.getElementById("select");
            const seasonInput = document.getElementById("season");

            // Get the season from data-attr-season
            const season = typeSelect.options[typeSelect.selectedIndex].dataset.attrSeason;
            // Make it an int
            const seasonInt = parseInt(season);

            // Loop through the seasons and find the one that matches the selected type
            for (let i = 0; i < seasonList.length; i++) {
                if (seasonList[i].id === seasonInt) {
                    seasonInput.value = seasonList[i].name;
                }
            }
        }

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

        // Attach the getSeason function to a change event
        document.getElementById("select").addEventListener("change", getSeason);

        // Attach the getLocation function to a button click event
        document.getElementById("getLocationButton").addEventListener("click", getLocation);
    </script>
</div>


