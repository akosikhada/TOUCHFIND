<?php
// chatbot.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../css/chatbot.css">
    <title>TouchFind Assistant</title>
</head>
<body>
    <div class="chatbot-container">
        <div class="chatbot-header">
            <h3>TouchFind Assistant</h3>
            <button id="close-chatbot" class="close-button">X</button>
        </div>
        <div class="chatbot-body" id="chatbot-body">
            <div class="chatbot-message bot-message">
                <p>Hello! I am TouchFind, your kiosk assistant. I'm here to attend to your needs and assist you with your transactions. How can I help you today?</p>
            </div>
        </div>
        <div class="chatbot-input">
            <input type="text" id="chatbot-input" placeholder="Type your message here...">
            <button id="send-message"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>

    <script>
        // Close chatbot when the close button is clicked
        document.getElementById('close-chatbot').addEventListener('click', function() {
            document.querySelector('.chatbot-container').style.display = 'none';
        });

        // Send message and auto-reply
        document.getElementById('send-message').addEventListener('click', function() {
            sendMessage();
        });

        // Allow pressing Enter to send a message
        document.getElementById('chatbot-input').addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        });

        function sendMessage() {
            const input = document.getElementById('chatbot-input');
            const message = input.value.trim();
            if (message) {
                // Add user's message to the chat
                const userMessage = document.createElement('div');
                userMessage.className = 'chatbot-message user-message';
                userMessage.innerHTML = `<p>${message}</p>`;
                document.getElementById('chatbot-body').appendChild(userMessage);

                // Clear the input box
                input.value = '';

                // Show typing animation
                const typingAnimation = document.createElement('div');
                typingAnimation.className = 'chatbot-message bot-message typing-animation';
                typingAnimation.innerHTML = `<div class="dot"></div><div class="dot"></div><div class="dot"></div>`;
                document.getElementById('chatbot-body').appendChild(typingAnimation);

                // Scroll to the bottom of the chat
                document.getElementById('chatbot-body').scrollTop = document.getElementById('chatbot-body').scrollHeight;

                // Send the message to the server for processing
                fetch('fetch_chatbot_response.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ message: message }),
                })
                .then(response => {
                    console.log('Response status:', response.status); // Log the response status
                    return response.text(); // Get the response as text first
                })
                .then(text => {
                    console.log('Response text:', text); // Log the response text
                    try {
                        const data = JSON.parse(text); // Parse the text as JSON
                        // Remove typing animation
                        typingAnimation.remove();

                        // Add bot's response
                        const botMessage = document.createElement('div');
                        botMessage.className = 'chatbot-message bot-message';
                        botMessage.innerHTML = `<p>${data.response}</p>`;
                        document.getElementById('chatbot-body').appendChild(botMessage);

                        // Scroll to the bottom of the chat
                        document.getElementById('chatbot-body').scrollTop = document.getElementById('chatbot-body').scrollHeight;
                    } catch (error) {
                        console.error('Error parsing JSON:', error);
                        // Remove typing animation
                        typingAnimation.remove();

                        // Add error message
                        const botMessage = document.createElement('div');
                        botMessage.className = 'chatbot-message bot-message';
                        botMessage.innerHTML = `<p>Sorry, something went wrong. Please try again later.</p>`;
                        document.getElementById('chatbot-body').appendChild(botMessage);
 }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Remove typing animation
                    typingAnimation.remove();

                    // Add error message
                    const botMessage = document.createElement('div');
                    botMessage.className = 'chatbot-message bot-message';
                    botMessage.innerHTML = `<p>Sorry, something went wrong. Please try again later.</p>`;
                    document.getElementById('chatbot-body').appendChild(botMessage);
                });
            }
        }
    </script>
</body>
</html>