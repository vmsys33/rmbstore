<?php
// Set the content type to JSON
header('Content-Type: application/json');

// Google AI API Configuration
$apiKey = 'AIzaSyDnZ0FYhbTI20V72-zJ8KfYB_qV3p_zy-o';
$apiUrl = 'https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent';

// Get the user's message from the POST request
$data = json_decode(file_get_contents('php://input'), true);
$userMessage = $data['message'];

if (empty($userMessage)) {
    echo json_encode(['reply' => 'Please enter a message.']);
    exit;
}

// Prepare the request data for Google AI API
$postData = [
    'contents' => [
        [
            'parts' => [
                [
                    'text' => $userMessage
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

// Make the API call to Google AI
$ch = curl_init($apiUrl . '?key=' . $apiKey);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $result = json_decode($response, true);
    
    if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
        $botReply = $result['candidates'][0]['content']['parts'][0]['text'];
    } else {
        $botReply = 'Sorry, I received an unexpected response format from the AI service.';
    }
} else {
    // Handle API errors
    $errorData = json_decode($response, true);
    if (isset($errorData['error']['message'])) {
        $botReply = 'AI Service Error: ' . $errorData['error']['message'];
    } else {
        $botReply = 'Sorry, there was an error connecting to the AI service. Please try again.';
    }
}

// Return the response as JSON
echo json_encode(['reply' => $botReply]);
?>
