<div class="chat-bar-collapsible">

    <!-- Add the full-chat-block element here within the chat-bar-collapsible div -->
    <div class="full-chat-block">
        <div class="chat-title">
            Peary Chat
        </div>
        <!-- Message Container -->
        <div class="outer-container">
            <div class="chat-container">
                <!-- Messages -->
                <div id="chatbox">
                    <h5 id="chat-timestamp"></h5>
                    <p id="botStarterMessage" class="botText"><span>Loading...</span></p>
                </div>
                <div id="question-container">
                    <div id="question-text">Question Text</div>
                    <button id="previous-button">Previous</button>
                    <button id="next-button">Next</button>
                    <button id="submit-button" onclick="questionSendButton();">Submit</button>
                </div>
                <!-- User input box -->
                <div class="chat-bar-input-block">
                    <div id="userInput">
                        <input id="textInput" class="input-box" type="text" name="msg" placeholder="Tap 'Enter' to send a message">
                        <p></p>
                    </div>

                    <div class="chat-bar-icons">
                        <svg width="50" height="50" onclick="sendButton()">
                            <image x="10" y="0" width="40" height="40" xlink:href="assets\comment-regular.svg" />
                        </svg>


                    </div>
                </div>
                <div id="chat-bar-bottom">
                    <p></p>
                </div>

                <script src="./scripts/chatbot.js"></script>
                <script src="./scripts/chatbot_responses.js"></script>
            </div>
        </div>
    </div>






    <script src="./scripts/leaflet.js"></script>
    </body>

    <?php

    // function getMarkerData($mysqli)
    // {
    //     $query = "SELECT * FROM EXAMPLE_TABLE";
    //     $result = $mysqli->query($query);

    //     if ($result->num_rows > 0) {
    //         $data = array();

    //         while ($row = $result->fetch_assoc()) {
    //             $data[] = $row;
    //         }

    //         return json_encode($data);
    //     } else {
    //         return "[]";
    //     }
    // }

    // $markerJSON = getMarkerData($mysqli);

    // $mysqli->close();






    ?>
    </script>
    <script src="./<?= Router::getOffset() ?>scripts/leaflet_icons.js"></script>
    <script src="./<?= Router::getOffset() ?>scripts/leaflet.js"></script>
</div>