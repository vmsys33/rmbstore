/**
 * RMB Store Chatbot Widget
 * A modern, responsive chatbot widget for RMB Store
 * 
 * Features:
 * - Multi-user session management
 * - Product search and recommendations
 * - Q&A database integration
 * - AI-powered responses
 * - Responsive design
 */

class ChatbotWidget {
    constructor(options = {}) {
        // Default configuration
        this.config = {
            apiBase: '/chatbot',
            containerId: 'chatbot-container',
            headerTitle: 'RMB Store Assistant',
            placeholderText: 'Type your message here...',
            welcomeMessage: 'Hello! I\'m your RMB Store assistant. How can I help you today?',
            loadHistory: true,
            debug: false,
            ...options
        };

        // State
        this.state = {
            isOpen: false,
            isMinimized: false,
            isLoading: false,
            sessionId: null,
            userFingerprint: null,
            messages: [],
            products: [],
            qa: []
        };

        // Initialize
        this.init();
    }

    /**
     * Initialize the chatbot
     */
    init() {
        // Create DOM elements
        this.createElements();
        
        // Generate or retrieve session ID
        this.state.sessionId = this.generateSessionId();
        this.state.userFingerprint = this.generateUserFingerprint();
        
        // Save session
        this.saveSession();
        
        // Load products and Q&A
        this.loadProducts();
        this.loadQA();
        
        // Load chat history if enabled
        if (this.config.loadHistory) {
            this.loadChatHistory();
        } else {
            // Add welcome message
            this.addMessage('bot', this.config.welcomeMessage);
        }
        
        // Add event listeners
        this.addEventListeners();
        
        // Log debug info
        if (this.config.debug) {
            console.log('Chatbot initialized with session ID:', this.state.sessionId);
            console.log('User fingerprint:', this.state.userFingerprint);
        }
    }

    /**
     * Create DOM elements for the chatbot
     */
    createElements() {
        // Create container if it doesn't exist
        this.container = document.getElementById(this.config.containerId);
        if (!this.container) {
            this.container = document.createElement('div');
            this.container.id = this.config.containerId;
            document.body.appendChild(this.container);
        }
        
        // Create chatbot HTML structure
        this.container.innerHTML = `
            <div class="chatbot-widget">
                <div class="chatbot-toggle">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="chatbot-box">
                    <div class="chatbot-header">
                        <div class="chatbot-title">${this.config.headerTitle}</div>
                        <div class="chatbot-controls">
                            <button class="chatbot-minimize"><i class="fas fa-minus"></i></button>
                            <button class="chatbot-close"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="chatbot-messages"></div>
                    <div class="chatbot-typing">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="chatbot-input">
                        <input type="text" placeholder="${this.config.placeholderText}" />
                        <button class="chatbot-send"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
        `;
        
        // Store references to elements
        this.widget = this.container.querySelector('.chatbot-widget');
        this.toggleBtn = this.container.querySelector('.chatbot-toggle');
        this.chatbox = this.container.querySelector('.chatbot-box');
        this.header = this.container.querySelector('.chatbot-header');
        this.messagesContainer = this.container.querySelector('.chatbot-messages');
        this.typingIndicator = this.container.querySelector('.chatbot-typing');
        this.input = this.container.querySelector('.chatbot-input input');
        this.sendBtn = this.container.querySelector('.chatbot-send');
        this.minimizeBtn = this.container.querySelector('.chatbot-minimize');
        this.closeBtn = this.container.querySelector('.chatbot-close');
    }

    /**
     * Add event listeners
     */
    addEventListeners() {
        // Toggle chatbot
        this.toggleBtn.addEventListener('click', () => this.toggle());
        
        // Send message
        this.sendBtn.addEventListener('click', () => this.handleSend());
        this.input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                this.handleSend();
            }
        });
        
        // Minimize chatbot
        this.minimizeBtn.addEventListener('click', () => this.minimize());
        
        // Close chatbot
        this.closeBtn.addEventListener('click', () => this.close());
        
        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            // Alt+C to toggle chatbot
            if (e.altKey && e.key === 'c') {
                this.toggle();
            }
            
            // Escape to close chatbot
            if (e.key === 'Escape' && this.state.isOpen) {
                this.close();
            }
        });
    }

    /**
     * Generate a unique session ID
     */
    generateSessionId() {
        // Check if session ID exists in localStorage
        const existingSessionId = localStorage.getItem('chatbot_session_id');
        if (existingSessionId) {
            return existingSessionId;
        }
        
        // Generate new session ID
        const sessionId = 'session_' + Math.random().toString(36).substring(2, 15) + 
                          Math.random().toString(36).substring(2, 15) + 
                          '_' + Date.now();
        
        // Save to localStorage
        localStorage.setItem('chatbot_session_id', sessionId);
        
        return sessionId;
    }

    /**
     * Generate a user fingerprint for tracking across sessions
     */
    generateUserFingerprint() {
        // Check if fingerprint exists in localStorage
        const existingFingerprint = localStorage.getItem('chatbot_user_fingerprint');
        if (existingFingerprint) {
            return existingFingerprint;
        }
        
        // Generate fingerprint based on browser info
        const fingerprint = 'user_' + 
            (navigator.userAgent + navigator.language + 
             screen.width + screen.height + 
             new Date().getTimezoneOffset())
            .split('')
            .reduce((a, b) => {
                a = ((a << 5) - a) + b.charCodeAt(0);
                return a & a;
            }, 0)
            .toString(36)
            .replace('-', '_');
        
        // Save to localStorage
        localStorage.setItem('chatbot_user_fingerprint', fingerprint);
        
        return fingerprint;
    }

    /**
     * Save session to database
     */
    saveSession() {
        const formData = new FormData();
        formData.append('sessionId', this.state.sessionId);
        formData.append('userFingerprint', this.state.userFingerprint);
        
        fetch(`${this.config.apiBase}/saveSession`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (this.config.debug) {
                console.log('Session saved:', data);
            }
        })
        .catch(error => {
            console.error('Error saving session:', error);
        });
    }

    /**
     * Load chat history for current user
     */
    loadChatHistory() {
        this.showTypingIndicator();
        
        const formData = new FormData();
        formData.append('sessionId', this.state.sessionId);
        formData.append('userFingerprint', this.state.userFingerprint);
        
        fetch(`${this.config.apiBase}/getChatHistory`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            this.hideTypingIndicator();
            
            if (data.status === 'success' && data.messages && data.messages.length > 0) {
                // Clear existing messages
                this.state.messages = [];
                this.messagesContainer.innerHTML = '';
                
                // Add messages from history
                data.messages.forEach(msg => {
                    const sender = msg.sender === 'user' ? 'user' : 'bot';
                    const message = msg.message;
                    const metadata = msg.metadata ? JSON.parse(msg.metadata) : null;
                    
                    this.addMessage(sender, message, metadata, false);
                });
                
                // Scroll to bottom
                this.scrollToBottom();
            } else {
                // Add welcome message if no history
                this.addMessage('bot', this.config.welcomeMessage);
            }
        })
        .catch(error => {
            console.error('Error loading chat history:', error);
            this.hideTypingIndicator();
            this.addMessage('bot', this.config.welcomeMessage);
        });
    }

    /**
     * Load products for chatbot
     */
    loadProducts() {
        fetch(`${this.config.apiBase}/getProducts`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    this.state.products = data.data;
                    if (this.config.debug) {
                        console.log(`Loaded ${data.count} products`);
                    }
                }
            })
            .catch(error => {
                console.error('Error loading products:', error);
            });
    }

    /**
     * Load Q&A for chatbot
     */
    loadQA() {
        fetch(`${this.config.apiBase}/getQA`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    this.state.qa = data.data;
                    if (this.config.debug) {
                        console.log(`Loaded ${data.count} Q&A items`);
                    }
                }
            })
            .catch(error => {
                console.error('Error loading Q&A:', error);
            });
    }

    /**
     * Handle send button click
     */
    handleSend() {
        const message = this.input.value.trim();
        if (message === '') return;
        
        // Add user message to chat
        this.addMessage('user', message);
        
        // Clear input
        this.input.value = '';
        
        // Save message to database
        this.saveMessage('user', message);
        
        // Generate response
        this.generateResponse(message);
    }

    /**
     * Add message to chat
     */
    addMessage(sender, message, metadata = null, scroll = true) {
        // Create message element
        const messageEl = document.createElement('div');
        messageEl.className = `chatbot-message ${sender}-message`;
        
        // Add message content
        if (sender === 'bot' && metadata && metadata.type === 'products') {
            // Product cards
            messageEl.innerHTML = `
                <div class="chatbot-message-content">
                    <div class="chatbot-message-text">${message}</div>
                    <div class="chatbot-product-carousel">
                        ${this.renderProductCards(metadata.products)}
                    </div>
                </div>
            `;
        } else {
            // Regular text message
            messageEl.innerHTML = `
                <div class="chatbot-message-content">
                    <div class="chatbot-message-text">${message}</div>
                </div>
            `;
        }
        
        // Add timestamp
        const timestamp = document.createElement('div');
        timestamp.className = 'chatbot-message-time';
        timestamp.textContent = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        messageEl.appendChild(timestamp);
        
        // Add to messages container
        this.messagesContainer.appendChild(messageEl);
        
        // Add to state
        this.state.messages.push({
            sender,
            message,
            metadata,
            timestamp: new Date()
        });
        
        // Scroll to bottom
        if (scroll) {
            this.scrollToBottom();
        }
    }

    /**
     * Render product cards for carousel
     */
    renderProductCards(products) {
        return products.map(product => {
            // Use actual product image if available, otherwise use placeholder
            const productImage = product.image_post || product.image_url || '/assets/images/product-placeholder.jpg';
            
            // Format price properly
            const productPrice = product.price && product.price > 0 ? 
                (product.price_formatted || `$${parseFloat(product.price).toFixed(2)}`) : 
                'Price not available';
            
            return `
                <div class="chatbot-product-card">
                    <div class="chatbot-product-image">
                        <img src="${productImage}" alt="${product.product_name || product.name}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="chatbot-product-info">
                        <h4>${product.product_name || product.name}</h4>
                        <p class="chatbot-product-price">${productPrice}</p>
                        <a href="/product/${product.id || product.slug}" class="chatbot-product-link" target="_blank">View Details</a>
                    </div>
                </div>
            `;
        }).join('');
    }

    /**
     * Save message to database
     */
    saveMessage(sender, message, messageType = 'text', metadata = null) {
        const formData = new FormData();
        formData.append('sessionId', this.state.sessionId);
        formData.append('userFingerprint', this.state.userFingerprint);
        formData.append('sender', sender);
        formData.append('message', message);
        formData.append('messageType', messageType);
        
        if (metadata) {
            formData.append('metadata', JSON.stringify(metadata));
        }
        
        fetch(`${this.config.apiBase}/saveMessage`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (this.config.debug) {
                console.log('Message saved:', data);
            }
        })
        .catch(error => {
            console.error('Error saving message:', error);
        });
    }

    /**
     * Generate response based on user message
     */
    generateResponse(message) {
        this.showTypingIndicator();
        
        // First try to match with Q&A
        const qaResponse = this.findQAResponse(message);
        if (qaResponse) {
            setTimeout(() => {
                this.hideTypingIndicator();
                this.addMessage('bot', qaResponse.answer);
                this.saveMessage('bot', qaResponse.answer, 'text', { source: 'qa', qa_id: qaResponse.id });
            }, 500);
            return;
        }
        
        // Then try to find matching products
        const matchingProducts = this.findMatchingProducts(message);
        if (matchingProducts.length > 0) {
            const productResponse = 'Here are some products that might interest you:';
            setTimeout(() => {
                this.hideTypingIndicator();
                this.addMessage('bot', productResponse, { type: 'products', products: matchingProducts });
                this.saveMessage('bot', productResponse, 'products', { 
                    source: 'products', 
                    products: matchingProducts.map(p => p.id) 
                });
            }, 800);
            return;
        }
        
        // Finally, try AI service
        this.getAIResponse(message);
    }

    /**
     * Find matching Q&A response
     */
    findQAResponse(message) {
        const normalizedMessage = message.toLowerCase();
        
        // First try exact match with question
        let match = this.state.qa.find(item => 
            item.question.toLowerCase() === normalizedMessage
        );
        
        if (!match) {
            // Then try keyword matching
            match = this.state.qa.find(item => {
                if (!item.keywords) return false;
                
                const keywords = item.keywords.toLowerCase().split(',');
                return keywords.some(keyword => 
                    normalizedMessage.includes(keyword.trim())
                );
            });
        }
        
        if (!match) {
            // Try partial matching
            match = this.state.qa.find(item => 
                normalizedMessage.includes(item.question.toLowerCase()) ||
                item.question.toLowerCase().includes(normalizedMessage)
            );
        }
        
        return match;
    }

    /**
     * Find matching products
     */
    findMatchingProducts(message) {
        const normalizedMessage = message.toLowerCase();
        
        // Check if message contains product-related keywords
        const productKeywords = ['product', 'buy', 'purchase', 'price', 'cost', 'item', 'order'];
        const isProductQuery = productKeywords.some(keyword => 
            normalizedMessage.includes(keyword)
        );
        
        if (!isProductQuery) {
            return [];
        }
        
        // Find matching products
        return this.state.products.filter(product => {
            const name = product.name.toLowerCase();
            const description = product.description ? product.description.toLowerCase() : '';
            const category = product.category ? product.category.toLowerCase() : '';
            const keywords = product.keywords ? product.keywords.toLowerCase() : '';
            
            return name.includes(normalizedMessage) ||
                   description.includes(normalizedMessage) ||
                   category.includes(normalizedMessage) ||
                   keywords.includes(normalizedMessage) ||
                   normalizedMessage.includes(name);
        }).slice(0, 3); // Limit to 3 products
    }

    /**
     * Get response from AI service
     */
    getAIResponse(message) {
        const formData = new FormData();
        formData.append('message', message);
        
        fetch(`${this.config.apiBase}/getAIResponse`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            this.hideTypingIndicator();
            
            if (data.status === 'success') {
                const response = data.data.response;
                this.addMessage('bot', response);
                this.saveMessage('bot', response, 'text', { source: 'ai' });
            } else {
                // Fallback response
                const fallbackResponse = "I'm not sure how to respond to that. Can you try asking something else about our products or services?";
                this.addMessage('bot', fallbackResponse);
                this.saveMessage('bot', fallbackResponse, 'text', { source: 'fallback' });
            }
        })
        .catch(error => {
            console.error('Error getting AI response:', error);
            this.hideTypingIndicator();
            
            // Fallback response
            const fallbackResponse = "I'm having trouble connecting to my brain right now. Please try again later or ask me something else.";
            this.addMessage('bot', fallbackResponse);
            this.saveMessage('bot', fallbackResponse, 'text', { source: 'error' });
        });
    }

    /**
     * Show typing indicator
     */
    showTypingIndicator() {
        this.typingIndicator.style.display = 'flex';
        this.scrollToBottom();
    }

    /**
     * Hide typing indicator
     */
    hideTypingIndicator() {
        this.typingIndicator.style.display = 'none';
    }

    /**
     * Scroll messages container to bottom
     */
    scrollToBottom() {
        this.messagesContainer.scrollTop = this.messagesContainer.scrollHeight;
    }

    /**
     * Toggle chatbot open/closed
     */
    toggle() {
        if (this.state.isOpen) {
            this.close();
        } else {
            this.open();
        }
    }

    /**
     * Open chatbot
     */
    open() {
        this.widget.classList.add('open');
        this.state.isOpen = true;
        this.state.isMinimized = false;
        this.scrollToBottom();
        this.input.focus();
    }

    /**
     * Close chatbot
     */
    close() {
        this.widget.classList.remove('open');
        this.widget.classList.remove('minimized');
        this.state.isOpen = false;
        this.state.isMinimized = false;
    }

    /**
     * Minimize chatbot
     */
    minimize() {
        if (this.state.isMinimized) {
            this.widget.classList.remove('minimized');
            this.state.isMinimized = false;
        } else {
            this.widget.classList.add('minimized');
            this.state.isMinimized = true;
        }
    }
}

// Initialize chatbot if auto-init data attribute is present
document.addEventListener('DOMContentLoaded', () => {
    const autoinit = document.querySelector('[data-chatbot-autoinit]');
    if (autoinit) {
        window.chatbot = new ChatbotWidget();
    }
});