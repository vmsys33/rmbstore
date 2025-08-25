<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class CiciAI extends BaseConfig
{
    /**
     * CICI AI API Key
     */
    public $apiKey = 'your_cici_ai_api_key_here';
    
    /**
     * CICI AI API URL
     */
    public $apiUrl = 'https://api.cici.ai/v1/chat/completions';
    
    /**
     * Default model to use
     */
    public $defaultModel = 'cici-1.0';
    
    /**
     * Maximum tokens for responses
     */
    public $maxTokens = 150;
    
    /**
     * Temperature for response generation (0.0 to 1.0)
     */
    public $temperature = 0.7;
    
    /**
     * System prompt for the chatbot
     */
    public $systemPrompt = 'You are a helpful customer service chatbot for RMB Store, an electronics and fashion retailer. Help customers find products, answer questions, and provide excellent service.';
    
    /**
     * Request timeout in seconds
     */
    public $timeout = 10;
    
    /**
     * Whether to enable CICI AI integration
     */
    public $enabled = true;
    
    /**
     * Fallback responses when CICI AI is unavailable
     */
    public $fallbackResponses = [
        'greeting' => [
            'Hello! Welcome to RMB Store. I\'m here to help you find products, check prices and stock, or answer questions about our store. What can I assist you with today?',
            'Hi there! Welcome to RMB Store. I\'m your AI assistant, ready to help you find the perfect products. What are you looking for today?',
            'Greetings! I\'m here to help you navigate our store and find exactly what you need. How can I assist you today?'
        ],
        'product_search' => [
            'I\'d be happy to help you find products! You can search by name, category, or just describe what you\'re looking for.',
            'Let me help you find the perfect product. What specific item or category are you interested in?',
            'I can search our entire product database for you. Just let me know what you\'re looking for!'
        ],
        'general_help' => [
            'I\'m here to help! I can search for products, show you categories, check prices and stock, or answer questions about our store.',
            'I can assist you with product searches, price checks, stock availability, and general store information. What do you need help with?',
            'I\'m your shopping assistant! I can help you find products, compare options, and get all the information you need to make the best choice.'
        ]
    ];
}
