document.addEventListener("DOMContentLoaded", function () {
  const chatbot = document.getElementById("chatbot");
  const chatbotToggle = document.getElementById("chatbot-toggle");
  const chatbotClose = document.getElementById("chatbot-close");
  const chatbotMessages = document.getElementById("chatbot-messages");
  const chatbotInput = document.getElementById("chatbot-input");
  const chatbotSend = document.getElementById("chatbot-send");
  const typingIndicator = document.getElementById("typing-indicator");

  // Toggle chatbot window
  chatbotToggle.addEventListener("click", function () {
    chatbot.classList.toggle("open");
    if (chatbot.classList.contains("open")) {
      chatbotInput.focus();
    }
  });

  // Close chatbot window
  chatbotClose.addEventListener("click", function () {
    chatbot.classList.remove("open");
  });

  // Send message on button click
  chatbotSend.addEventListener("click", sendMessage);

  // Send message on Enter key
  chatbotInput.addEventListener("keypress", function (e) {
    if (e.key === "Enter") {
      sendMessage();
    }
  });

  // Function to send user message
  function sendMessage() {
    const message = chatbotInput.value.trim();
    if (message === "") return;

    // Add user's message
    addMessage(message, "user");
    chatbotInput.value = "";

    // Show typing indicator
    typingIndicator.classList.add("active");

    // Simulate typing delay
    setTimeout(() => {
      fetch("chatbot_handler.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `message=${encodeURIComponent(message)}`
      })
        .then(response => response.json())
        .then(data => {
          console.log("Chatbot response:", data);
          if (data.status === "success" && data.reply) {
            addMessage(data.reply, "bot");
          } else {
            addMessage("Sorry, I didn't understand that.", "bot");
          }

          typingIndicator.classList.remove("active");
          chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
        })
        .catch(err => {
          console.error("Error:", err);
          addMessage("Oops! Something went wrong.", "bot");
          typingIndicator.classList.remove("active");
        });
    }, 800); // simulate delay
  }

  // Function to add a message to the chat
  function addMessage(message, sender) {
    const messageElement = document.createElement("div");
    messageElement.classList.add("chatbot-message", `${sender}-message`);
  
    // Use innerHTML for bot responses with rich HTML (like product results)
    if (sender === "bot") {
      messageElement.innerHTML = message;
    } else {
      messageElement.textContent = message;
    }
  
    chatbotMessages.insertBefore(messageElement, typingIndicator);
    chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
  }
});