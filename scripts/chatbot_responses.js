const qaPairs = {
    "What types of trees can I find for harvesting?": [
        "You can find a variety of trees for harvesting, including fruit trees like apple and pear, as well as nut trees like walnut and chestnut. Make sure to identify them correctly before harvesting.",
        "You can start by exploring local parks, community gardens, and nature reserves. Be sure to respect local regulations and property rights when foraging.",
        "Tree foraging can be a rewarding experience. It allows you to connect with nature and enjoy fresh, locally sourced produce."
    ],
    "How do I identify edible trees?": [
        "Identifying edible trees requires knowledge of tree species, leaves, fruits, and their characteristics. Consider using field guides or mobile apps for tree identification.",
        "Safety is paramount when tree foraging. Always wear appropriate clothing, carry necessary tools, and be cautious of potential hazards like insects or poisonous plants.",
        "For beginners, it's a good idea to forage with an experienced forager who can teach you the ropes and help you identify edible trees."
    ],
    "What are the best seasons for tree harvesting?": [
        "The best seasons for tree harvesting can vary depending on your location. Typically, late summer to early fall is a fruitful time for harvesting many tree fruits.",
        "Laws regarding tree foraging can vary by region, so it's essential to research local regulations and obtain any necessary permits to ensure you're foraging legally.",
        "You can contribute to tree conservation by practicing sustainable foraging methods, respecting wildlife habitats, and planting native tree species."
    ],
    "How old can trees be for harvesting?": [
        "Trees can vary in age for harvesting. Some fruit trees start producing fruit within a few years, while others may take longer. Ensure the tree is healthy and its fruits are ripe.",
        "When going tree foraging, bring containers for collecting fruits, a field guide for identification, gloves, and pruning shears or a ladder for hard-to-reach branches.",
        "There are many delicious recipes you can try with tree-foraged ingredients, such as apple pies, nut-based dishes, and preserves."
    ],
    "Who can I contact for more information?": [
        "For more information, you can contact local environmental organizations, gardening clubs, or forestry departments. They may have resources and events related to tree foraging.",
        "There are several organizations dedicated to tree conservation and foraging, such as the Tree Foragers Association and the National Forest Foundation.",
        "Tree foraging has environmental benefits, including reducing food waste, promoting local food sourcing, and connecting people with nature."
    ],
    "Where can I forage for trees in my area?": [
        "You can start by exploring nearby parks, nature reserves, and community gardens. Be sure to respect any rules and regulations regarding foraging in those areas.",
        "Consider joining local foraging groups or online communities where you can connect with experienced foragers and get recommendations for specific foraging spots in your area.",
        "Before foraging on private property or protected land, always obtain proper permissions and permits to ensure you're foraging legally and responsibly."
    ],
    
};


const alternatives = [
    "I'm not sure, could you please provide more details?",
    "It seems like you have a specific question. Feel free to ask, and I'll do my best to help."
];



function getBotResponse(userInput) {
    for (const question in qaPairs) {
        if (userInput.toLowerCase().includes(question.toLowerCase())) {
            const responses = qaPairs[question];
            let randomResponse = responses[Math.floor(Math.random() * responses.length)];
            // Don't show the same response twice in a row 
            while (randomResponse === getBotResponse.previousResponse) {
                randomResponse = responses[Math.floor(Math.random() * responses.length)];
            }
            getBotResponse.previousResponse = randomResponse;
            return randomResponse;
        }
    }
    const randomAlternative = alternatives[Math.floor(Math.random() * alternatives.length)];
    // Don't show the same alternative twice in a row 
    while (randomAlternative === getBotResponse.previousResponse) {
        randomAlternative = alternatives[Math.floor(Math.random() * alternatives.length)];
    }
    getBotResponse.previousResponse = randomAlternative;
    return randomAlternative;
}





let currentQuestionIndex = 0;
const questions = Object.keys(qaPairs);

function displayQuestion() {
    const questionText = document.getElementById("question-text");
    questionText.textContent = questions[currentQuestionIndex];
}

function appendMessage(message, sender) {
    const chatbox = document.getElementById("chatbox");
    const messageElement = document.createElement("div");
    messageElement.classList.add("message", sender);
    messageElement.textContent = message;
    chatbox.appendChild(messageElement);
}

document.getElementById("next-button").addEventListener("click", () => {
    if (currentQuestionIndex < questions.length - 1) {
        currentQuestionIndex++;
        displayQuestion();
    }
});

document.getElementById("previous-button").addEventListener("click", () => {
    if (currentQuestionIndex > 0) {
        currentQuestionIndex--;
        displayQuestion();
    }
});

document.getElementById("submit-button").addEventListener("click", () => {
    const userResponse = document.getElementById("textInput").value;
    if (userResponse.trim() === "") {
        return; 
    }

    
    const botResponse = getBotResponse(userResponse);

    appendMessage(`You: ${userResponse}`, "user");
    appendMessage(`Bot: ${botResponse}`, "bot");

    
    document.getElementById("textInput").value = "";
});






displayQuestion();