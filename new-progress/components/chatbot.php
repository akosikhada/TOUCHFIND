<!-- Chatbot Component -->
<style>
    .chatbot-container {
        position: fixed;
        bottom: 70px;
        right: 20px;
        z-index: 2000;
        width: 50px;
        height: 50px;
        transform: scale(1);
        transition: all 0.3s ease;
        font-family: "Poppins", sans-serif;
    }
    
    .chatbot-toggle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #1F2937;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: all 0.3s ease;
        position: absolute;
        bottom: 0;
        right: 0;
        z-index: 1001;
        border: 1px solid #333;
        animation: pulse 1.5s infinite alternate;
    }
    
    @keyframes pulse {
        0% {
            transform: scale(1);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
        }
        100% {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
        }
    }
    
    .chatbot-toggle:hover {
        transform: scale(1.1);
        background-color: #2a3a4a;
        animation: none;
    }
    
    .chatbot-icon {
        width: 24px;
        height: 24px;
        opacity: 0.9;
    }
    
    .chatbot-window {
        position: absolute;
        bottom: 60px;
        right: 0;
        width: 300px;
        height: 380px;
        background-color: #1a1a1a;
        border-radius: 6px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        opacity: 0;
        transform: translateY(20px) scale(0.9);
        pointer-events: none;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid #333;
    }
    
    .chatbot-container.open .chatbot-window {
        opacity: 1;
        transform: translateY(0) scale(1);
        pointer-events: all;
    }
    
    .chatbot-header {
        background-color: #1F2937;
        padding: 10px 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #333;
    }
    
    .chatbot-title {
        color: white;
        font-size: 14px;
        font-weight: 500;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
    }
    
    .chatbot-title-icon {
        width: 16px;
        height: 16px;
        margin-right: 8px;
        opacity: 0.9;
    }
    
    .chatbot-close {
        width: 22px;
        height: 22px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: white;
        font-size: 14px;
        transition: background 0.3s;
    }
    
    .chatbot-close:hover {
        background: rgba(255, 255, 255, 0.2);
    }
    
    .chatbot-messages {
        flex: 1;
        padding: 12px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 8px;
        background-color: #141414;
    }
    
    .chatbot-message {
        max-width: 85%;
        padding: 10px 12px;
        border-radius: 8px;
        margin-bottom: 4px;
        font-size: 13px;
        line-height: 1.4;
        animation: fadeIn 0.3s ease-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .bot-message {
        background-color: #1F2937;
        color: white;
        align-self: flex-start;
        border-bottom-left-radius: 2px;
    }
    
    .user-message {
        background-color: #2a3a4a;
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 2px;
    }
    
    .chatbot-footer {
        padding: 10px;
        background-color: #1a1a1a;
        border-top: 1px solid #333;
        display: flex;
        gap: 8px;
    }
    
    .chatbot-input {
        flex: 1;
        background-color: #242424;
        border: 1px solid #333;
        border-radius: 16px;
        padding: 8px 12px;
        color: white;
        font-size: 13px;
        outline: none;
    }
    
    .chatbot-input::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }
    
    .chatbot-input:focus {
        border-color: #1F2937;
        box-shadow: 0 0 0 1px #1F2937;
    }
    
    .chatbot-send {
        width: 32px;
        height: 32px;
        background-color: #1F2937;
        border: 1px solid #333;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .chatbot-send:hover {
        background-color: #2a3a4a;
        transform: scale(1.05);
    }
    
    .typing-indicator {
        display: flex;
        align-items: center;
        gap: 3px;
        padding: 6px 10px;
        background-color: #1F2937;
        border-radius: 8px;
        width: fit-content;
        margin-bottom: 6px;
        align-self: flex-start;
        border-bottom-left-radius: 2px;
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .typing-indicator.active {
        opacity: 1;
    }
    
    .typing-dot {
        width: 5px;
        height: 5px;
        background-color: rgba(255, 255, 255, 0.6);
        border-radius: 50%;
        animation: typingAnimation 1.4s infinite ease-in-out;
    }
    
    .typing-dot:nth-child(1) {
        animation-delay: 0s;
    }
    
    .typing-dot:nth-child(2) {
        animation-delay: 0.2s;
    }
    
    .typing-dot:nth-child(3) {
        animation-delay: 0.4s;
    }
    
    @keyframes typingAnimation {
        0%, 60%, 100% {
            transform: translateY(0);
        }
        30% {
            transform: translateY(-4px);
        }
    }
    
    /* Responsive styling */
    @media (max-width: 768px) {
        .chatbot-container {
            bottom: 80px;
            right: 20px;
        }
        
        .chatbot-window {
            width: 280px;
            height: 350px;
            bottom: 60px;
            right: 0;
        }
        
        .chatbot-messages {
            padding: 10px;
        }
        
        .chatbot-message {
            padding: 8px 10px;
            font-size: 12px;
        }
    }
    
    @media (max-width: 576px) {
        .chatbot-container {
            bottom: 80px;
            right: 15px;
        }
        
        .chatbot-window {
            width: 260px;
            height: 320px;
            bottom: 60px;
            right: 0;
        }
        
        .chatbot-messages {
            padding: 10px;
        }
        
        .chatbot-message {
            padding: 8px 10px;
            font-size: 12px;
        }
    }
</style>

<div class="chatbot-container" id="chatbot">
    <div class="chatbot-toggle" id="chatbot-toggle">
        <svg class="chatbot-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
        </svg>
    </div>
    
    <div class="chatbot-window">
        <div class="chatbot-header">
            <div class="chatbot-title">
                <svg class="chatbot-title-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                TOUCHFIND Assistant
            </div>
            <div class="chatbot-close" id="chatbot-close">×</div>
        </div>
        
        <div class="chatbot-messages" id="chatbot-messages">
            <div class="chatbot-message bot-message">
                Hello! Welcome to TOUCHFIND. How can I help you find hardware supplies today?
            </div>
            
            <div class="typing-indicator" id="typing-indicator">
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
            </div>
        </div>
        
        <div class="chatbot-footer">
            <input type="text" class="chatbot-input" id="chatbot-input" placeholder="Type your message..." autocomplete="off">
            <button class="chatbot-send" id="chatbot-send">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="22" y1="2" x2="11" y2="13"></line>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatbot = document.getElementById('chatbot');
        const chatbotToggle = document.getElementById('chatbot-toggle');
        const chatbotClose = document.getElementById('chatbot-close');
        const chatbotMessages = document.getElementById('chatbot-messages');
        const chatbotInput = document.getElementById('chatbot-input');
        const chatbotSend = document.getElementById('chatbot-send');
        const typingIndicator = document.getElementById('typing-indicator');
        
        // Toggle chatbot window
        chatbotToggle.addEventListener('click', function() {
            chatbot.classList.toggle('open');
            if (chatbot.classList.contains('open')) {
                chatbotInput.focus();
            }
        });
        
        // Close chatbot window
        chatbotClose.addEventListener('click', function() {
            chatbot.classList.remove('open');
        });
        
        // Send message on button click
        chatbotSend.addEventListener('click', sendMessage);
        
        // Send message on Enter key
        chatbotInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
        
        // Function to send user message
        function sendMessage() {
            const message = chatbotInput.value.trim();
            if (message === '') return;
            
            // Add user message
            addMessage(message, 'user');
            chatbotInput.value = '';
            
            // Show typing indicator
            typingIndicator.classList.add('active');
            
            // Simulate bot response after delay
            setTimeout(() => {
                typingIndicator.classList.remove('active');
                
                // Generate bot response based on user message
                const botResponse = getBotResponse(message);
                addMessage(botResponse, 'bot');
                
                // Scroll to the bottom
                chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
            }, 1000 + Math.random() * 1000); // Random delay between 1-2 seconds
            
            // Scroll to the bottom
            chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
        }
        
        // Function to add a message to the chat
        function addMessage(message, sender) {
            const messageElement = document.createElement('div');
            messageElement.classList.add('chatbot-message');
            messageElement.classList.add(sender + '-message');
            messageElement.textContent = message;
            
            // Insert before the typing indicator
            chatbotMessages.insertBefore(messageElement, typingIndicator);
        }
        
        // Function to generate bot responses
        function getBotResponse(message) {
            message = message.toLowerCase();
            
            if (message.includes('hello') || message.includes('hi') || message.includes('hey')) {
                return "Hello! Welcome to TOUCHFIND. How can I help you find hardware supplies today?";
            } else if (message.includes('help') || message.includes('support')) {
                return "I can help you find tools, hardware supplies, or provide information about our products and services. What are you looking for?";
            } else if (message.includes('product') || message.includes('find')) {
                return "We have a wide range of hardware products in different categories. You can browse them from the sidebar or use the search function at the top of the page.";
            } else if (message.includes('tool') || message.includes('tools')) {
                return "We offer professional-grade tools including power drills, circular saws, measuring equipment, and hand tools. Is there a specific tool you're looking for?";
            } else if (message.includes('price') || message.includes('cost')) {
                return "Our product prices are displayed on each product card. We aim to provide competitive pricing on all our hardware supplies.";
            } else if (message.includes('order') || message.includes('checkout')) {
                return "To place an order, add items to your cart and then click on the 'Checkout' button in the cart page. We offer multiple payment options for your convenience.";
            } else if (message.includes('payment') || message.includes('pay')) {
                return "We accept credit cards, PayPal and Cash on Delivery. All transactions are secure and your information is protected.";
            } else if (message.includes('delivery') || message.includes('shipping')) {
                return "We offer standard delivery (3-5 business days) and express delivery (1-2 business days) options. Shipping costs are calculated at checkout based on your location.";
            } else if (message.includes('return') || message.includes('refund')) {
                return "We have a 30-day return policy for most items. Products must be in original condition with packaging. Contact our support team to initiate a return.";
            } else if (message.includes('warranty') || message.includes('guarantee')) {
                return "Most of our tools come with a manufacturer's warranty. Details of each product's warranty are listed on the product details page.";
            } else if (message.includes('paint') || message.includes('painting')) {
                return "We offer a variety of paints, primers, and painting supplies including brushes, rollers, and spray equipment. Our paint brands include premium quality options for all your projects.";
            } else if (message.includes('hardware') || message.includes('supplies')) {
                return "Our hardware selection includes screws, nails, brackets, hinges, and other essential supplies for construction and repair projects.";
            } else if (message.includes('plumbing') || message.includes('pipes')) {
                return "We carry plumbing supplies including pipes, fittings, valves, and fixtures for your home improvement needs.";
            } else if (message.includes('electric') || message.includes('electrical')) {
                return "Our electrical department offers wiring, switches, outlets, and other electrical components for both DIY and professional use.";
            } else if (message.includes('contact') || message.includes('call')) {
                return "You can contact our support team at support@touchfind.com or call us at 123-456-7890 during business hours (Mon-Fri, 9AM-6PM).";
            } else if (message.includes('thanks') || message.includes('thank you')) {
                return "You're welcome! Is there anything else I can help you with regarding our hardware products?";
            } else if (message.includes('bye') || message.includes('goodbye')) {
                return "Thank you for chatting with TOUCHFIND. Feel free to return if you have more questions about our tools and hardware supplies!";
            } else {
                return "I'm not sure I understand. Could you please ask about our tools, hardware supplies, or specific products you're looking for?";
            }
        }
    });
</script>