<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class HuggingFace extends BaseConfig
{
    /**
     * Hugging Face API Configuration
     * Completely FREE - No API key required!
     */
    
    /**
     * Primary model for chatbot responses
     */
    public $primaryModel = 'facebook/blenderbot-400M-distill';
    
    /**
     * Alternative model if primary fails
     */
    public $alternativeModel = 'microsoft/DialoGPT-medium';
    
    /**
     * API base URL
     */
    public $apiBaseUrl = 'https://api-inference.huggingface.co/models/';
    
    /**
     * Request timeout in seconds
     */
    public $timeout = 15;
    
    /**
     * Whether to wait for model to load
     */
    public $waitForModel = true;
    
    /**
     * Maximum retry attempts
     */
    public $maxRetries = 2;
    
    /**
     * User agent for API requests
     */
    public $userAgent = 'RMBStore-Chatbot/1.0';
    
    /**
     * Available models for different use cases
     */
    public $availableModels = [
        'chatbot' => [
            'facebook/blenderbot-400M-distill' => 'Good for general conversation',
            'microsoft/DialoGPT-medium' => 'Alternative chatbot model',
            'EleutherAI/gpt-neo-125M' => 'Small but fast model'
        ],
        'product_search' => [
            'distilbert-base-uncased' => 'Good for understanding product queries',
            'sentence-transformers/all-MiniLM-L6-v2' => 'Semantic search model'
        ]
    ];
    
    /**
     * Fallback responses when AI is unavailable
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
        ],
        'error' => [
            'I\'m having trouble connecting to my AI brain right now, but I can still help you with basic questions and product searches!',
            'Let me use my local knowledge to help you while my AI connection is being restored.',
            'I\'m experiencing a temporary AI connection issue, but I\'m still here to assist you!'
        ]
    ];
    
    /**
     * Model-specific settings
     */
    public $modelSettings = [
        'facebook/blenderbot-400M-distill' => [
            'max_length' => 100,
            'temperature' => 0.7,
            'do_sample' => true
        ],
        'microsoft/DialoGPT-medium' => [
            'max_length' => 100,
            'temperature' => 0.8,
            'do_sample' => true
        ]
    ];
}
