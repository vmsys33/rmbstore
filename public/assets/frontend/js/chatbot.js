// Chatbot JavaScript
class Chatbot {
    constructor() {
        this.isOpen = false;
        this.messages = [];
        this.typingTimeout = null;
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadConversationHistory();
    }

    bindEvents() {
        // Toggle button
        const toggleBtn = document.getElementById('chatbotToggle');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => this.toggleChat());
        }

        // Close button
        const closeBtn = document.getElementById('chatbotClose');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => this.closeChat());
        }

        // Send button
        const sendBtn = document.getElementById('chatbotSend');
        if (sendBtn) {
            sendBtn.addEventListener('click', () => this.sendMessage());
        }

        // Input field
        const input = document.getElementById('chatbotInput');
        if (input) {
            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    this.sendMessage();
                }
            });

            input.addEventListener('input', () => {
                this.updateSendButton();
            });
        }

        // Close on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen) {
                this.closeChat();
            }
        });

        // Close on outside click
        document.addEventListener('click', (e) => {
            if (this.isOpen && !e.target.closest('.chatbot-container') && !e.target.closest('.chatbot-toggle')) {
                this.closeChat();
            }
        });
    }

    toggleChat() {
        if (this.isOpen) {
            this.closeChat();
        } else {
            this.openChat();
        }
    }

    openChat() {
        this.isOpen = true;
        const container = document.getElementById('chatbotContainer');
        if (container) {
            container.classList.add('active');
            container.style.display = 'flex';
        }
        
        // Focus input
        const input = document.getElementById('chatbotInput');
        if (input) {
            setTimeout(() => input.focus(), 300);
        }

        // Hide notification badge
        this.hideNotificationBadge();
    }

    closeChat() {
        this.isOpen = false;
        const container = document.getElementById('chatbotContainer');
        if (container) {
            container.classList.remove('active');
            container.style.display = 'none';
        }
    }

    sendMessage() {
        const input = document.getElementById('chatbotInput');
        if (!input) return;

        const message = input.value.trim();
        if (!message) return;

        // Add user message
        this.addMessage(message, 'user');
        input.value = '';
        this.updateSendButton();

        // Show typing indicator
        this.showTypingIndicator();

        // Simulate bot response
        setTimeout(() => {
            this.hideTypingIndicator();
            this.generateBotResponse(message);
        }, 1000 + Math.random() * 2000);
    }

    addMessage(text, sender) {
        const messagesContainer = document.getElementById('chatbotMessages');
        if (!messagesContainer) return;

        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender}-message`;

        const contentDiv = document.createElement('div');
        contentDiv.className = 'message-content';

        const textP = document.createElement('p');
        textP.textContent = text;
        contentDiv.appendChild(textP);

        // Add quick replies for bot messages
        if (sender === 'bot') {
            const quickReplies = this.getQuickReplies(text);
            if (quickReplies.length > 0) {
                const quickRepliesDiv = document.createElement('div');
                quickRepliesDiv.className = 'quick-replies';
                
                quickReplies.forEach(reply => {
                    const button = document.createElement('button');
                    button.className = 'quick-reply';
                    button.textContent = reply.text;
                    button.onclick = () => this.sendQuickReply(reply.action);
                    quickRepliesDiv.appendChild(button);
                });
                
                contentDiv.appendChild(quickRepliesDiv);
            }
        }

        const timeDiv = document.createElement('div');
        timeDiv.className = 'message-time';
        timeDiv.textContent = this.getCurrentTime();

        messageDiv.appendChild(contentDiv);
        messageDiv.appendChild(timeDiv);

        messagesContainer.appendChild(messageDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Save to conversation history
        this.messages.push({ text, sender, timestamp: new Date() });
        this.saveConversationHistory();
    }

    getQuickReplies(message) {
        const lowerMessage = message.toLowerCase();
        
        if (lowerMessage.includes('product') || lowerMessage.includes('buy') || lowerMessage.includes('shop')) {
            return [
                { text: '📦 Browse Products', action: 'browse_products' },
                { text: '🏷️ View Categories', action: 'view_categories' },
                { text: '💰 Check Prices', action: 'check_prices' }
            ];
        } else if (lowerMessage.includes('category') || lowerMessage.includes('type')) {
            return [
                { text: '🏷️ All Categories', action: 'all_categories' },
                { text: '🔍 Search Products', action: 'search_products' }
            ];
        } else if (lowerMessage.includes('contact') || lowerMessage.includes('support') || lowerMessage.includes('help')) {
            return [
                { text: '📞 Contact Info', action: 'contact_info' },
                { text: '📧 Send Email', action: 'send_email' },
                { text: '📍 Location', action: 'location' }
            ];
        } else if (lowerMessage.includes('price') || lowerMessage.includes('cost') || lowerMessage.includes('expensive')) {
            return [
                { text: '💰 Price Range', action: 'price_range' },
                { text: '🎯 Best Deals', action: 'best_deals' },
                { text: '📦 Product List', action: 'product_list' }
            ];
        }
        
        return [
            { text: '📦 Products', action: 'products' },
            { text: '🏷️ Categories', action: 'categories' },
            { text: '📞 Contact', action: 'contact' },
            { text: '💰 Pricing', action: 'pricing' }
        ];
    }

    generateBotResponse(userMessage) {
        const lowerMessage = userMessage.toLowerCase();
        let response = '';

        if (lowerMessage.includes('hello') || lowerMessage.includes('hi') || lowerMessage.includes('hey')) {
            response = '👋 Hello! How can I assist you today? I can help you with products, categories, pricing, or any other questions about RMB Store.';
        } else if (lowerMessage.includes('product') || lowerMessage.includes('buy') || lowerMessage.includes('shop')) {
            response = '📦 Great! We have a wide variety of products available. You can browse by category or search for specific items. What type of product are you looking for?';
        } else if (lowerMessage.includes('category') || lowerMessage.includes('type')) {
            response = '🏷️ We offer several product categories including electronics, clothing, home goods, and more. Which category interests you?';
        } else if (lowerMessage.includes('price') || lowerMessage.includes('cost') || lowerMessage.includes('expensive')) {
            response = '💰 Our prices are competitive and we offer various price ranges to suit different budgets. We also have regular sales and promotions. Would you like to see our current deals?';
        } else if (lowerMessage.includes('contact') || lowerMessage.includes('support') || lowerMessage.includes('help')) {
            response = '📞 I\'m here to help! You can reach our support team through email, phone, or visit our store. What specific assistance do you need?';
        } else if (lowerMessage.includes('location') || lowerMessage.includes('address') || lowerMessage.includes('where')) {
            response = '📍 Our store is located in a convenient area. You can find our exact address and directions on our website or contact us for specific location details.';
        } else if (lowerMessage.includes('delivery') || lowerMessage.includes('shipping') || lowerMessage.includes('online')) {
            response = '🚚 We offer both in-store pickup and delivery options. Our delivery service covers local areas and we provide tracking for all shipments.';
        } else if (lowerMessage.includes('payment') || lowerMessage.includes('pay') || lowerMessage.includes('card')) {
            response = '💳 We accept various payment methods including cash, credit cards, debit cards, and digital payments. All transactions are secure and encrypted.';
        } else if (lowerMessage.includes('return') || lowerMessage.includes('refund') || lowerMessage.includes('exchange')) {
            response = '🔄 We have a customer-friendly return policy. Most items can be returned within 30 days with original receipt. Contact us for specific return details.';
        } else if (lowerMessage.includes('sale') || lowerMessage.includes('discount') || lowerMessage.includes('promotion')) {
            response = '🎉 We regularly offer sales and promotions! Check our website or visit the store for current deals. You can also sign up for our newsletter to get notified about special offers.';
        } else {
            response = '🤔 I\'m not sure I understand. Could you please rephrase your question? I can help you with products, categories, pricing, contact information, or general store inquiries.';
        }

        this.addMessage(response, 'bot');
    }

    sendQuickReply(action) {
        let response = '';
        
        switch (action) {
            case 'products':
                response = '📦 Our product catalog includes electronics, clothing, home goods, sports equipment, and much more. What specific category are you interested in?';
                break;
            case 'categories':
                response = '🏷️ We organize our products into categories for easy browsing: Electronics, Clothing, Home & Garden, Sports, Books, and more. Which category would you like to explore?';
                break;
            case 'contact':
                response = '📞 You can reach us through multiple channels: Phone, Email, or visit our store. Our customer service team is available during business hours to assist you.';
                break;
            case 'pricing':
                response = '💰 We offer competitive pricing across all product categories. We also have regular sales, seasonal discounts, and loyalty programs for our valued customers.';
                break;
            case 'browse_products':
                response = '🔍 You can browse our products by category, search by name, or filter by price range. Would you like me to guide you through a specific category?';
                break;
            case 'view_categories':
                response = '🏷️ Our main categories include: Electronics, Fashion, Home & Living, Sports & Outdoor, Books & Media, and Health & Beauty. Which interests you most?';
                break;
            case 'check_prices':
                response = '💰 Our pricing is transparent and competitive. You can check individual product prices on our website or visit the store. We also offer bulk discounts for larger purchases.';
                break;
            case 'all_categories':
                response = '🏷️ Here are all our product categories: Electronics, Fashion, Home & Living, Sports & Outdoor, Books & Media, Health & Beauty, Automotive, and Toys & Games.';
                break;
            case 'search_products':
                response = '🔍 Use our search function to find specific products. You can search by name, brand, or keywords. Our search is smart and will suggest related items too!';
                break;
            case 'contact_info':
                response = '📞 Contact Information: Phone: [Your Phone], Email: [Your Email], Address: [Your Address]. Business Hours: Monday-Saturday 9AM-8PM, Sunday 10AM-6PM.';
                break;
            case 'send_email':
                response = '📧 You can email us at [Your Email] for general inquiries, support, or feedback. We typically respond within 24 hours during business days.';
                break;
            case 'location':
                response = '📍 Our store is located at [Your Address]. We\'re easily accessible by public transport and have parking available for customers.';
                break;
            case 'price_range':
                response = '💰 Our products range from budget-friendly options to premium selections. We have items starting from ₱100 up to ₱50,000+, ensuring there\'s something for every budget.';
                break;
            case 'best_deals':
                response = '🎯 Check out our "Deals of the Day" section for the best current offers! We also have clearance sales, seasonal promotions, and loyalty member discounts.';
                break;
            case 'product_list':
                response = '📋 We have thousands of products across all categories. For a complete list, visit our website or come to the store. I can help you find specific items or categories!';
                break;
            default:
                response = '🤔 I\'m here to help! What would you like to know about our products, services, or store?';
        }

        this.addMessage(response, 'bot');
    }

    showTypingIndicator() {
        const messagesContainer = document.getElementById('chatbotMessages');
        if (!messagesContainer) return;

        const typingDiv = document.createElement('div');
        typingDiv.className = 'message bot-message typing-indicator-container';
        typingDiv.id = 'typingIndicator';

        const contentDiv = document.createElement('div');
        contentDiv.className = 'message-content';

        const typingIndicator = document.createElement('div');
        typingIndicator.className = 'typing-indicator';
        typingIndicator.innerHTML = '<span></span><span></span><span></span>';

        contentDiv.appendChild(typingIndicator);
        typingDiv.appendChild(contentDiv);
        messagesContainer.appendChild(typingDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    hideTypingIndicator() {
        const typingIndicator = document.getElementById('typingIndicator');
        if (typingIndicator) {
            typingIndicator.remove();
        }
    }

    updateSendButton() {
        const input = document.getElementById('chatbotInput');
        const sendBtn = document.getElementById('chatbotSend');
        
        if (!input || !sendBtn) return;

        const hasText = input.value.trim().length > 0;
        sendBtn.disabled = !hasText;
    }

    getCurrentTime() {
        const now = new Date();
        return now.toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });
    }

    showNotificationBadge() {
        const badge = document.getElementById('chatbotBadge');
        if (badge && !this.isOpen) {
            badge.style.display = 'flex';
        }
    }

    hideNotificationBadge() {
        const badge = document.getElementById('chatbotBadge');
        if (badge) {
            badge.style.display = 'none';
        }
    }

    saveConversationHistory() {
        try {
            localStorage.setItem('chatbot_history', JSON.stringify(this.messages));
        } catch (e) {
            console.log('Could not save conversation history');
        }
    }

    loadConversationHistory() {
        try {
            const saved = localStorage.getItem('chatbot_history');
            if (saved) {
                this.messages = JSON.parse(saved);
            }
        } catch (e) {
            console.log('Could not load conversation history');
        }
    }

    // Public method to trigger notification
    notify() {
        this.showNotificationBadge();
    }
}

// Initialize chatbot when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.chatbot = new Chatbot();
    
    // Auto-notification after 5 seconds (optional)
    setTimeout(() => {
        if (window.chatbot && !window.chatbot.isOpen) {
            window.chatbot.notify();
        }
    }, 5000);
});

// Global function for quick replies (for backward compatibility)
window.sendQuickReply = function(action) {
    if (window.chatbot) {
        window.chatbot.sendQuickReply(action);
    }
};
