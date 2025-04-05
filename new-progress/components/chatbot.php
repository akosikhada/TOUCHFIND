<!-- Chatbot Component -->
<link rel="stylesheet" href="../css/chatbot.css">

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

<script src="../js/chatbot.js" defer></script>