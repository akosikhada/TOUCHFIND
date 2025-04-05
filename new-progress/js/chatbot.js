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

    // Add user message
    addMessage(message, "user");
    chatbotInput.value = "";

    // Show typing indicator
    typingIndicator.classList.add("active");

    // Simulate bot response after delay
    setTimeout(() => {
      typingIndicator.classList.remove("active");

      // Generate bot response based on user message
      const botResponse = getBotResponse(message);
      addMessage(botResponse, "bot");

      // Scroll to the bottom
      chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }, 1000 + Math.random() * 1000); // Random delay between 1-2 seconds

    // Scroll to the bottom
    chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
  }

  // Function to add a message to the chat
  function addMessage(message, sender) {
    const messageElement = document.createElement("div");
    messageElement.classList.add("chatbot-message");
    messageElement.classList.add(sender + "-message");
    messageElement.textContent = message;

    // Insert before the typing indicator
    chatbotMessages.insertBefore(messageElement, typingIndicator);
  }

  // Function to generate bot responses
  function getBotResponse(message) {
    message = message.toLowerCase();

    if (
      message.includes("hello") ||
      message.includes("hi") ||
      message.includes("hey")
    ) {
      return "Hello! Welcome to TOUCHFIND. How can I help you find hardware supplies today?";
    } else if (message.includes("help") || message.includes("support")) {
      return "I can help you find tools, hardware supplies, or provide information about our products and services. What are you looking for?";
    } else if (message.includes("product") || message.includes("find")) {
      return "We have a wide range of hardware products in different categories. You can browse them from the sidebar or use the search function at the top of the page.";
    } else if (message.includes("tool") || message.includes("tools")) {
      return "We offer professional-grade tools including power drills, circular saws, measuring equipment, and hand tools. Is there a specific tool you're looking for?";
    } else if (message.includes("price") || message.includes("cost")) {
      return "Our product prices are displayed on each product card. We aim to provide competitive pricing on all our hardware supplies.";
    } else if (message.includes("order") || message.includes("checkout")) {
      return "To place an order, add items to your cart and then click on the 'Checkout' button in the cart page. We offer multiple payment options for your convenience.";
    } else if (message.includes("payment") || message.includes("pay")) {
      return "We accept credit cards, PayPal and Cash on Delivery. All transactions are secure and your information is protected.";
    } else if (message.includes("delivery") || message.includes("shipping")) {
      return "We offer standard delivery (3-5 business days) and express delivery (1-2 business days) options. Shipping costs are calculated at checkout based on your location.";
    } else if (message.includes("return") || message.includes("refund")) {
      return "We have a 30-day return policy for most items. Products must be in original condition with packaging. Contact our support team to initiate a return.";
    } else if (message.includes("warranty") || message.includes("guarantee")) {
      return "Most of our tools come with a manufacturer's warranty. Details of each product's warranty are listed on the product details page.";
    } else if (message.includes("paint") || message.includes("painting")) {
      return "We offer a variety of paints, primers, and painting supplies including brushes, rollers, and spray equipment. Our paint brands include premium quality options for all your projects.";
    } else if (message.includes("hardware") || message.includes("supplies")) {
      return "Our hardware selection includes screws, nails, brackets, hinges, and other essential supplies for construction and repair projects.";
    } else if (message.includes("plumbing") || message.includes("pipes")) {
      return "We carry plumbing supplies including pipes, fittings, valves, and fixtures for your home improvement needs.";
    } else if (message.includes("electric") || message.includes("electrical")) {
      return "Our electrical department offers wiring, switches, outlets, and other electrical components for both DIY and professional use.";
    } else if (message.includes("contact") || message.includes("call")) {
      return "You can contact our support team at support@touchfind.com or call us at 123-456-7890 during business hours (Mon-Fri, 9AM-6PM).";
    } else if (message.includes("thanks") || message.includes("thank you")) {
      return "You're welcome! Is there anything else I can help you with regarding our hardware products?";
    } else if (message.includes("bye") || message.includes("goodbye")) {
      return "Thank you for chatting with TOUCHFIND. Feel free to return if you have more questions about our tools and hardware supplies!";
    } else {
      return "I'm not sure I understand. Could you please ask about our tools, hardware supplies, or specific products you're looking for?";
    }
  }
});
