<h1 class="login-text">Submissions</h1>

<div>
<form class="submission-form" action="submissions/send" method="post">
  
        <label for="plant_name" >Plant Name:</label>     
<div class="form-group">
        
        <input type="text" id="plant-name" name="plant_name" required><br><br>
</div>
        
        <label for="location" >Location:</label>

<div class="form-group">            
       
        <input id="location" type="text" name="location" id="location" required>
        <button type="button" id="getLocationButton">Get Location</button><br><br>
</div>

        <label for="photo" >Photo:</label>

        <label for="img-link"></label>
<input type="url" id="img-link" placeholder="image link here" name="img-link">
        <input id="photo" type="file" name="photo"  required><br><br>


<div class="column">

    <div class="labels">
        <label for="season" >Season </label>
        &
        <label for="types" >types: </label>
    </div>
    <div class="row">
        <div class="form-group">
                <!-- Select element for season -->
                
                <select id="season" name="season" required>
                    <option value="" disabled selected>Select a season</option>
                    <?php
                    // Get from database
                    // $stmt = new Database;
                    // $prepared = $stmt->prepare('SELECT `id`, `season` as `name` FROM `seasons`');
                    // $result = $prepared->execute();

                    $result = [
                        0 => [
                            'id' => 222,
                            'name' => 'Spring'
                        ],
                        1 => [
                            'id' => 333,
                            'name' => 'Autumn'
                        ]
                    ];

                    foreach ($result as $season) {
                        echo '<option value="'.$season['id'].'">'.$season['name'].'</option>';
                    }

                    if (empty($result)) {
                        echo '<option value="0">No data</option';
                    }
                    ?>
                </select><br><br>
        </div>
        <div class="form-group">            
                <select id="types" name="types" required>
                    <option value="" disabled selected>Select a type</option>
                    <?php
                    // Get from database
                    // $stmt = new Database;
                    // $prepared = $stmt->prepare('SELECT `id`, `type` as `name` FROM `types`');
                    // $result = $prepared->execute();

                    $result = [
                        0 => [
                            'id' => 222,
                            'name' => 'Food'
                        ],
                        1 => [
                            'id' => 333,
                            'name' => 'Unknown'
                        ]
                    ];

                    foreach ($result as $type) {
                        echo '<option value="'.$type['id'].'">'.$type['name'].'</option>';
                    }

                    if (empty($result)) {
                        echo '<option value="0">No data</option';
                    }
                    ?>
                </select><br><br>
        </div>
    </div>
</div>

        <!-- Hidden fields to store latitude and longitude -->
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
    <div class="buttons">
        <button type="submit" id="send" name="send">Send</button>
        <button type="submit" id="back" name="back">Back</button>
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