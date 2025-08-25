// Chatbot JavaScript - Working with Existing HTML Structure
class ChatbotWidget {
    constructor() {
        this.isOpen = false;
        this.isTyping = false;
        this.messageCount = 0;
        this.messageHistory = [];
        this.products = [];
        this.qa = [];
        this.apiBase = '/chatbot';
        this.currentMode = 'auto'; // 'auto', 'products', 'store'
        
        this.init();
        this.loadProducts();
        this.loadQA();
    }
    
    // Initialize chatbot
    init() {
        console.log('🚀 Initializing chatbot...');
        this.bindEvents();
        console.log('✅ Chatbot initialized successfully!');
    }
    
    // Bind event listeners
    bindEvents() {
        console.log('🔗 Binding event listeners...');
        
        // Chat button toggle
        const chatButton = document.getElementById('chatButton');
        if (chatButton) {
            console.log('✅ Found chat button, adding click listener');
            chatButton.addEventListener('click', () => {
                console.log('🖱️ Chat button clicked!');
                this.toggleChat();
            });
        } else {
            console.error('❌ Chat button not found!');
        }
        
        // Close button
        const closeBtn = document.getElementById('closeBtn');
        if (closeBtn) {
            console.log('✅ Found close button, adding click listener');
            closeBtn.addEventListener('click', () => this.closeChat());
        } else {
            console.error('❌ Close button not found!');
        }
        
        // Send button
        const sendBtn = document.getElementById('sendBtn');
        if (sendBtn) {
            console.log('✅ Found send button, adding click listener');
            sendBtn.addEventListener('click', () => this.sendMessage());
        } else {
            console.error('❌ Send button not found!');
        }
        
        // Chat input
        const chatInput = document.getElementById('chatInput');
        if (chatInput) {
            console.log('✅ Found chat input, adding keypress listener');
            chatInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') this.sendMessage();
            });
        } else {
            console.error('❌ Chat input not found!');
        }
        
        // Mode toggle buttons
        const modeButtons = document.querySelectorAll('.mode-btn');
        if (modeButtons.length > 0) {
            console.log('✅ Found mode buttons, adding click listeners');
            modeButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    const mode = e.currentTarget.dataset.mode;
                    this.toggleMode(mode);
                    
                    // Update active state
                    modeButtons.forEach(btn => btn.classList.remove('active'));
                    e.currentTarget.classList.add('active');
                });
            });
        } else {
            console.error('❌ Mode buttons not found!');
        }
        
        console.log('🔗 Event listeners bound successfully!');
    }
    

    
    // Toggle chat visibility
    toggleChat() {
        console.log('🔄 Toggling chat visibility...');
        const chatWindow = document.getElementById('chatWindow');
        if (chatWindow) {
            this.isOpen = !this.isOpen;
            console.log(`Chat is now ${this.isOpen ? 'open' : 'closed'}`);
            chatWindow.classList.toggle('open', this.isOpen);
            
            // Focus on input when opening
            if (this.isOpen) {
                const chatInput = document.getElementById('chatInput');
                if (chatInput) {
                    chatInput.focus();
                    console.log('✅ Focused on chat input');
                }
            }
        } else {
            console.error('❌ Chat window not found!');
        }
    }
    
    // Close chat
    closeChat() {
        const chatWindow = document.getElementById('chatWindow');
        if (chatWindow) {
            this.isOpen = false;
            chatWindow.classList.remove('open');
        }
    }
    
    // Send message
    sendMessage() {
        const chatInput = document.getElementById('chatInput');
        if (!chatInput) return;
        
        const message = chatInput.value.trim();
        if (!message) return;
        
        // Add user message
        this.addMessage(message, 'user');
        chatInput.value = '';
        
        // Process message with current mode
        this.processMessage(message);
    }
    
    // Toggle search mode
    toggleMode(mode) {
        this.currentMode = mode;
        console.log('🔄 Chatbot mode changed to:', mode);
        
        // Update mode indicator
        this.updateModeIndicator();
        
        // Update placeholder text based on mode
        const chatInput = document.getElementById('chatInput');
        if (chatInput) {
            switch (mode) {
                case 'products':
                    chatInput.placeholder = 'Search for products... (e.g., "macbook", "nike shoes")';
                    break;
                case 'store':
                    chatInput.placeholder = 'Ask about store info... (e.g., "store hours", "return policy")';
                    break;
                default:
                    chatInput.placeholder = 'Ask me anything... (auto-detect mode)';
                    break;
            }
        }
        
        // Add mode change message
        this.addMessage(`Mode switched to: ${this.getModeDisplayName(mode)}`, 'system');
    }
    
    // Get display name for mode
    getModeDisplayName(mode) {
        switch (mode) {
            case 'products': return '🛍️ Product Search';
            case 'store': return '🏪 Store Inquiry';
            default: return '🤖 Auto-Detect';
        }
    }
    
    // Update mode indicator
    updateModeIndicator() {
        const modeIndicator = document.getElementById('modeIndicator');
        if (modeIndicator) {
            modeIndicator.textContent = this.getModeDisplayName(this.currentMode);
            modeIndicator.className = `mode-indicator ${this.currentMode}`;
        }
    }
    
    // Process user message
    async processMessage(message) {
        // Show typing indicator
        this.showTyping();
        
        try {
            console.log('🚀 Processing message:', message);
            // Use the backend's intelligent response generation for ALL messages
            const response = await this.generateAIResponse(message);
            console.log('📨 Response received:', response);
            this.addMessage(response, 'bot');
        } catch (error) {
            console.error('❌ Error processing message:', error);
            this.addMessage("I'm sorry, I encountered an error. Please try again.", 'bot');
        }
        
        this.hideTyping();
    }
    

    
    // Generate AI response
    async generateAIResponse(message) {
        try {
            const response = await fetch(`${this.apiBase}/generateResponse`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    message: message,
                    sessionId: this.generateSessionId(),
                    searchMode: this.currentMode // Send current mode to backend
                })
            });
            
            if (response.ok) {
                const result = await response.json();
                if (result.status === 'success') {
                    console.log('🔍 Backend response:', result);
                    console.log('📊 Response mode:', result.mode);
                    
                    // Check if this is a product response that needs special handling
                    if (result.type === 'product_results' && result.products) {
                        console.log('✅ Product results detected, returning special object');
                        // Return special marker for product display
                        return { type: 'product_results', products: result.products, query: message, mode: result.mode };
                    }
                    console.log('📝 Returning regular response:', result.response);
                    return result.response;
                }
                return this.getFallbackResponse(message);
            }
        } catch (error) {
            console.error('Error generating AI response:', error);
        }
        
        return this.getFallbackResponse(message);
    }
    
    // Format product response with beautiful card boxes
    formatProductResponse(products, query) {
        if (products.length === 0) {
            return `I couldn't find any products matching "${query}". Try different keywords or ask me about our categories!`;
        }
        
        let response = `🔍 **Search Results for "${query}"**\n\n`;
        
        if (products.length === 1) {
            const product = products[0];
            response += `📱 **${product.product_name}**\n`;
            response += `💰 Price: $${product.price}\n\n`;
            response += "Would you like to know more about this product?";
        } else {
            response += `Found ${products.length} products:\n\n`;
            
            products.forEach((product, index) => {
                response += `**${index + 1}. ${product.product_name}**\n`;
                response += `💰 Price: $${product.price}\n\n`;
            });
            
            response += "Would you like me to show you more details about any specific product?";
        }
        
        return response;
    }
    
    // Render product cards with beautiful styling
    renderProductCards(products, query) {
        console.log('🎨 renderProductCards called with:', { products, query });
        
        if (products.length === 0) {
            return `<p>I couldn't find any products matching "${query}". Try different keywords or ask me about our categories!</p>`;
        }
        
        let html = `
            <div class="product-search-container">
                <div class="search-results-header">
                    <h3>🔍 Search Results for "${query}"</h3>
                    <div class="product-count-badge">${products.length} product${products.length > 1 ? 's' : ''} found</div>
                </div>
                <div class="product-grid">
        `;
        
        products.forEach((product, index) => {
            console.log('📦 Rendering product:', product);
            html += `
                <div class="product-card-clean">
                    <div class="product-image-container">
                        <div class="product-image-clean" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                            📱
                        </div>
                    </div>
                    <div class="product-name-container">
                        <a href="/product/${product.id}" class="product-name-link" target="_blank">
                            🔗 ${product.product_name}
                        </a>
                        <div style="color: #667eea; font-weight: 600; margin-top: 4px;">$${product.price}</div>
                        <div style="color: #666; font-size: 12px; margin-top: 2px;">Click to view details</div>
                    </div>
                </div>
            `;
        });
        
        html += `
                </div>
            </div>
        `;
        
        console.log('🎨 Generated HTML:', html);
        return html;
    }
    
    // Fallback method removed - now using AI responses
    
    // Show typing indicator
    showTyping() {
        const typingIndicator = document.getElementById('typingIndicator');
        if (typingIndicator) {
            this.isTyping = true;
            typingIndicator.classList.add('show');
            this.scrollToBottom();
        }
    }
    
    // Hide typing indicator
    hideTyping() {
        const typingIndicator = document.getElementById('typingIndicator');
        if (typingIndicator) {
            this.isTyping = false;
            typingIndicator.classList.remove('show');
        }
    }
    
    // Add message to chat
    addMessage(content, sender, isHTML = false) {
        const chatMessages = document.getElementById('chatMessages');
        if (!chatMessages) return;
        
        console.log('🔍 addMessage called with:', { content, sender, isHTML, contentType: typeof content });
        
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender}-message`;
        
        if (typeof content === 'object' && content.type === 'product_results') {
            console.log('✅ Rendering product cards for:', content);
            // Special handling for product responses
            messageDiv.innerHTML = `
                <div class="message-content">
                    ${this.renderProductCards(content.products, content.query)}
                    <span class="message-time">Just now</span>
                </div>
            `;
        } else if (isHTML) {
            messageDiv.innerHTML = `
                <div class="message-content">
                    ${content}
                    <span class="message-time">Just now</span>
                </div>
            `;
        } else {
            messageDiv.innerHTML = `
                <div class="message-content">
                    <p>${content}</p>
                    <span class="message-time">Just now</span>
                </div>
            `;
        }
        
        chatMessages.appendChild(messageDiv);
        this.messageCount++;
        this.scrollToBottom();
    }
    

    
    // Scroll to bottom
    scrollToBottom() {
        const chatMessages = document.getElementById('chatMessages');
        if (chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    }
    
    // Load products from database
    async loadProducts() {
        try {
            const response = await fetch(`${this.apiBase}/getProducts`);
            if (response.ok) {
                const result = await response.json();
                if (result.status === 'success') {
                    this.products = result.data;
                    console.log('📦 Loaded products from database:', this.products.length);
                }
            }
        } catch (error) {
            console.error('Error loading products:', error);
        }
    }
    
    // Load Q&A from database
    async loadQA() {
        try {
            const response = await fetch(`${this.apiBase}/getQA`);
            if (response.ok) {
                const result = await response.json();
                if (result.status === 'success') {
                    this.qa = result.data;
                    console.log('📚 Loaded Q&A from database:', this.qa.length);
                }
            }
        } catch (error) {
            console.error('Error loading Q&A:', error);
        }
    }
    
    // Generate session ID
    generateSessionId() {
        return 'session_' + Date.now() + '_' + Math.random().toString(36).substring(2);
    }
}

// Initialize chatbot when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.chatbot = new ChatbotWidget();
});
