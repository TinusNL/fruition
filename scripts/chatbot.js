
function toggleChatPopup() {
    var chatPopup = document.querySelector('.full-chat-block');
    chatPopup.classList.toggle('show');
    // Trigger ChatTitle click event
    chatTitle.click();
}

// Attach the toggle function to the chat button click event
document.getElementById('chat-button').addEventListener('click', toggleChatPopup);

function getTime() {
    let today = new Date();
    hours = today.getHours();
    minutes = today.getMinutes();

    if (hours < 10) {
        hours = "0" + hours;
    }

    if (minutes < 10) {
        minutes = "0" + minutes;
    }

    let time = hours + ":" + minutes;
    return time;
}


function firstBotMessage() {
    let firstMessage = 'Hello my name is Peary I am a chatbot. I am here to help you with your questions.'
    document.getElementById("botStarterMessage").innerHTML = '<p class="botText"><span>' + firstMessage + '</span></p>';

    let time = getTime();

    document.getElementById("chat-timestamp").append(time);
    document.getElementById("userInput").scrollIntoView(false);
}

firstBotMessage();

function insertMessage(className, content) {
    let p = document.createElement('p');
    p.classList.add(className);
    let span = document.createElement('span');
    span.textContent = content;
    p.appendChild(span);
    return p;
}

function getHardResponse(userText) {
    
    let botResponse = getBotResponse(userText);
    let botHtml = insertMessage('botText', botResponse);
    document.getElementById("chatbox").append(botHtml);

    document.getElementById("chat-bar-bottom").scrollIntoView(true);
}


function getResponse() {
    let userText = document.getElementById("textInput").value;
    let userHtml = insertMessage('userText', userText);

    document.getElementById("textInput").value = "";
    document.getElementById("chatbox").append(userHtml);
    document.getElementById("chat-bar-bottom").scrollIntoView(true);

    setTimeout(() => {
        getHardResponse(userText);
    }, 1000)
}


function buttonSendText(sampleText) {
    let userHtml = insertMessage('userText', sampleText);

    document.getElementById("textInput").value = "";
    document.getElementById("chatbox").append(userHtml);
    document.getElementById("chat-bar-bottom").scrollIntoView(true);

    setTimeout(() => {
        getHardResponse(sampleText);
    }, 1000)
}

function questionSendButton() {
    let questionText = document.getElementById("question-text").textContent;

    if(questionText !== '' && questionText !== 'undefined') {
        let userHtml = insertMessage('userText', questionText);

        document.getElementById("textInput").value = "";
        document.getElementById("chatbox").append(userHtml);
        document.getElementById("chat-bar-bottom").scrollIntoView(true);

        setTimeout(() => {
            getHardResponse(questionText);
        }, 1000)
    }
}


function sendButton() {
    getResponse();
}


document.getElementById("textInput").addEventListener("keydown", function (e) {
    if (e.code === "Enter" || e.code === "NumpadEnter") {
        getResponse();
    }
});

var chatTitle = document.querySelector(".chat-title");
var chatContent = document.querySelector(".full-chat-block");


var chatIsOpen = true; // Start with the chat open

chatTitle.addEventListener("click", function () {
    if (chatIsOpen) {
        // Close the chat
        chatTitle.style.display = "none";
        chatContent.style.maxHeight = "0"; // Set the maximum height to 0 to hide the chat content
        chatIsOpen = false;
    } else if (!chatIsOpen) {
        // Open the chat
        chatTitle.style.display = "block";
        chatContent.style.maxHeight = "500px"; // Set the maximum height to the desired height
        chatIsOpen = true;
    } 
});
