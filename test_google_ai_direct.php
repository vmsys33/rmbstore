<?php
/**
 * Direct Test of Google AI Integration
 * This script tests the Google AI API directly to see what's happening
 */

echo "<h1>🧪 Testing Google AI Integration Directly</h1>";

// Test the same API call that the chatbot should be making
$testMessage = "hows the weather today?";
$apiKey = '';
$apiUrl = 'https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent';

// Create the system prompt (same as in ChatbotController)
$systemPrompt = "You are a helpful customer service chatbot for RMB Store, a retail business. Your role is to assist customers with questions and provide helpful information. Always respond as if you work for and represent RMB Store. Be friendly, professional, and helpful. 

For general questions (like time, weather, etc.), provide a helpful answer first, then gently mention how you can help with store-related matters. For store-specific questions, provide detailed, accurate information.

Keep responses concise (2-3 sentences) and always maintain a helpful, customer-service oriented tone. Be genuinely helpful with all questions, not just store-related ones.

IMPORTANT: For time questions, you can provide the current server time or explain that you don't have real-time access, but always be helpful and friendly.";

// Combine system prompt with user message
$fullPrompt = $systemPrompt . "\n\nCustomer Question: " . $testMessage . "\n\nYour response as RMB Store chatbot:";

echo "<h2>📝 Test Details</h2>";
echo "<p><strong>Test Message:</strong> {$testMessage}</p>";
echo "<p><strong>API Key:</strong> " . substr($apiKey, 0, 10) . "...</p>";
echo "<p><strong>API URL:</strong> {$apiUrl}</p>";

// Prepare the request data
$postData = [
    'contents' => [
        [
            'parts' => [
                [
                    'text' => $fullPrompt
                ]
            ]
        ]
    ],
    'generationConfig' => [
        'temperature' => 0.7,
        'topK' => 40,
        'topP' => 0.95,
        'maxOutputTokens' => 1024,
    ]
];

echo "<h2>📤 Request Data</h2>";
echo "<pre>" . json_encode($postData, JSON_PRETTY_PRINT) . "</pre>";

// Make the API call
echo "<h2>🌐 Making API Call...</h2>";

$ch = curl_init($apiUrl . '?key=' . $apiKey);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

echo "<h2>📥 API Response</h2>";
echo "<p><strong>HTTP Status Code:</strong> {$httpCode}</p>";

if ($curlError) {
    echo "<p><strong>cURL Error:</strong> {$curlError}</p>";
}

if ($response) {
    echo "<p><strong>Response Length:</strong> " . strlen($response) . " characters</p>";
    
    // Try to decode JSON response
    $result = json_decode($response, true);
    
    if (json_last_error() === JSON_ERROR_NONE) {
        echo "<p><strong>JSON Decode:</strong> ✅ Success</p>";
        
        if ($httpCode === 200) {
            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                $aiResponse = $result['candidates'][0]['content']['parts'][0]['text'];
                echo "<h3>✅ Google AI Response Success!</h3>";
                echo "<div style='background: #e8f5e8; padding: 15px; border-radius: 8px; border: 1px solid #4caf50;'>";
                echo "<p><strong>AI Response:</strong></p>";
                echo "<p>" . nl2br(htmlspecialchars($aiResponse)) . "</p>";
                echo "</div>";
            } else {
                echo "<h3>❌ Unexpected Response Format</h3>";
                echo "<p>The API returned a 200 status but the response format is unexpected.</p>";
                echo "<pre>" . json_encode($result, JSON_PRETTY_PRINT) . "</pre>";
            }
        } else {
            echo "<h3>❌ API Error</h3>";
            if (isset($result['error']['message'])) {
                echo "<p><strong>Error Message:</strong> " . htmlspecialchars($result['error']['message']) . "</p>";
            }
            echo "<pre>" . json_encode($result, JSON_PRETTY_PRINT) . "</pre>";
        }
    } else {
        echo "<p><strong>JSON Decode Error:</strong> " . json_last_error_msg() . "</p>";
        echo "<p><strong>Raw Response:</strong></p>";
        echo "<pre>" . htmlspecialchars($response) . "</pre>";
    }
} else {
    echo "<p><strong>No Response Received</strong></p>";
}

// Test the chatbot endpoint directly
echo "<h2>🤖 Testing Chatbot Endpoint</h2>";

$chatbotData = [
    'message' => $testMessage,
    'sessionId' => 'test_' . time()
];

echo "<p><strong>Testing:</strong> POST /chatbot/generateResponse</p>";
echo "<p><strong>Data:</strong></p>";
echo "<pre>" . json_encode($chatbotData, JSON_PRETTY_PRINT) . "</pre>";

// Make the request to the chatbot
$ch = curl_init('http://localhost:8080/chatbot/generateResponse');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($chatbotData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$chatbotResponse = curl_exec($ch);
$chatbotHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$chatbotCurlError = curl_error($ch);
curl_close($ch);

echo "<p><strong>Chatbot HTTP Status:</strong> {$chatbotHttpCode}</p>";

if ($chatbotCurlError) {
    echo "<p><strong>Chatbot cURL Error:</strong> {$chatbotCurlError}</p>";
}

if ($chatbotResponse) {
    $chatbotResult = json_decode($chatbotResponse, true);
    
    if (json_last_error() === JSON_ERROR_NONE) {
        echo "<h3>📱 Chatbot Response</h3>";
        echo "<pre>" . json_encode($chatbotResult, JSON_PRETTY_PRINT) . "</pre>";
        
        if (isset($chatbotResult['status']) && $chatbotResult['status'] === 'success') {
            if (isset($chatbotResult['type'])) {
                echo "<p><strong>Response Type:</strong> " . $chatbotResult['type'] . "</p>";
            }
            if (isset($chatbotResult['response'])) {
                echo "<p><strong>Response:</strong> " . htmlspecialchars($chatbotResult['response']) . "</p>";
            }
        }
    } else {
        echo "<p><strong>Chatbot JSON Decode Error:</strong> " . json_last_error_msg() . "</p>";
        echo "<pre>" . htmlspecialchars($chatbotResponse) . "</pre>";
    }
} else {
    echo "<p><strong>No Chatbot Response Received</strong></p>";
}

echo "<h2>🎯 Summary</h2>";
echo "<p>This test shows exactly what's happening with your Google AI integration and chatbot response system.</p>";
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1, h2, h3 { color: #333; }
pre { background: #f5f5f5; padding: 10px; border-radius: 5px; overflow-x: auto; }
</style>
