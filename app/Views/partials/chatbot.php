<!-- RMB Store Chatbot Integration -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="<?= base_url('assets/frontend/css/chatbot.css') ?>">

<!-- Chatbot Container -->
<div id="chatbot-container" class="chatbot-container">
    <!-- Chatbot Header -->
    <div class="chatbot-header">
        <div class="chatbot-avatar">
            <i class="fas fa-robot"></i>
        </div>
        <div class="chatbot-info">
            <h3>RMB Store Assistant</h3>
            <span class="status">Online</span>
        </div>
        <button id="minimize-btn" class="minimize-btn">
            <i class="fas fa-minus"></i>
        </button>
    </div>

    <!-- Chat Messages -->
    <div id="chat-messages" class="chat-messages">
        <div class="message bot-message">
            <div class="message-content">
                <p>Hello! 👋 Welcome to RMB Store. How can I help you today?</p>
                <div class="quick-replies">
                    <button class="quick-reply" onclick="sendQuickReply('products')">Browse Products</button>
                    <button class="quick-reply" onclick="sendQuickReply('categories')">View Categories</button>
                    <button class="quick-reply" onclick="sendQuickReply('contact')">Contact Support</button>
                </div>
            </div>
            <span class="message-time">Just now</span>
        </div>
    </div>

    <!-- Chat Input -->
    <div class="chat-input-container">
        <div class="input-wrapper">
            <input type="text" id="chat-input" placeholder="Type your message..." maxlength="500">
            <button id="send-btn" class="send-btn">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
        <div class="typing-indicator" id="typing-indicator" style="display: none;">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>

<!-- Chatbot Toggle Button -->
<div id="chatbot-toggle" class="chatbot-toggle">
    <i class="fas fa-comments"></i>
    <span class="notification-badge" id="notification-badge" style="display: none;">1</span>
</div>

<!-- Chatbot JavaScript -->
<script src="<?= base_url('assets/frontend/js/chatbot.js') ?>"></script>
