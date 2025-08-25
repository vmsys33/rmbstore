<?php

namespace Config;

/**
 * AI Providers Configuration
 * 
 * This file contains configuration for various AI providers that can be used
 * by the chatbot for intelligent responses.
 */

class AIProviders
{
    /**
     * Google AI (Gemini) Configuration
     * Free tier: 15 requests/minute, 1500 requests/day
     * Get API key from: https://makersuite.google.com/app/apikey
     */
    public static $googleAI = [
        'enabled' => true,
        'api_key' => 'AIzaSyDnZ0FYhbTI20V72-zJ8KfYB_qV3p_zy-o',
        'model' => 'gemini-1.5-flash',
        'base_url' => 'https://generativelanguage.googleapis.com/v1/models/',
        'max_tokens' => 150,
        'temperature' => 0.7,
        'timeout' => 10
    ];
    
    /**
     * Hugging Face Configuration
     * Completely free, no API key required
     */
    public static $huggingFace = [
        'enabled' => true,
        'primary_model' => 'facebook/blenderbot-400M-distill',
        'fallback_model' => 'microsoft/DialoGPT-medium',
        'timeout' => 15
    ];
    
    /**
     * OpenAI Configuration (Optional)
     * Free tier: $5 credit monthly (~1000 requests)
     * Get API key from: https://platform.openai.com/api-keys
     */
    public static $openAI = [
        'enabled' => false, // Set to true if you want to use OpenAI
        'api_key' => 'your_openai_api_key_here', // Set via environment variable OPENAI_API_KEY
        'model' => 'gpt-3.5-turbo',
        'max_tokens' => 150,
        'temperature' => 0.7,
        'timeout' => 10
    ];
    
    /**
     * Anthropic Claude Configuration (Optional)
     * Free tier: $5 credit monthly
     * Get API key from: https://console.anthropic.com/
     */
    public static $anthropic = [
        'enabled' => false, // Set to true if you want to use Claude
        'api_key' => 'your_anthropic_api_key_here', // Set via environment variable ANTHROPIC_API_KEY
        'model' => 'claude-3-haiku-20240307',
        'max_tokens' => 150,
        'timeout' => 10
    ];
    
    /**
     * Get all enabled AI providers
     */
    public static function getEnabledProviders()
    {
        $providers = [];
        
        if (self::$googleAI['enabled']) {
            $providers[] = 'google_ai';
        }
        
        if (self::$huggingFace['enabled']) {
            $providers[] = 'hugging_face';
        }
        
        if (self::$openAI['enabled']) {
            $providers[] = 'openai';
        }
        
        if (self::$anthropic['enabled']) {
            $providers[] = 'anthropic';
        }
        
        return $providers;
    }
    
    /**
     * Check if a specific provider is enabled
     */
    public static function isProviderEnabled($provider)
    {
        switch ($provider) {
            case 'google_ai':
                return self::$googleAI['enabled'];
            case 'hugging_face':
                return self::$huggingFace['enabled'];
            case 'openai':
                return self::$openAI['enabled'];
            case 'anthropic':
                return self::$anthropic['enabled'];
            default:
                return false;
        }
    }
}
