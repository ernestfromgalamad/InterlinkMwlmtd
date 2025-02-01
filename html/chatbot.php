<?php
header("Content-Type: application/json");

$apiKey = "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"; // Replace with your valid OpenAI API key
$data = json_decode(file_get_contents("php://input"), true);
$userMessage = $data['message'] ?? '';

// Log input data for debugging
error_log("Input Data: " . print_r($data, true));

// Make API request
$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $apiKey",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    "model" => "gpt-3.5-turbo",
    "messages" => [
        ["role" => "system", "content" => "You are a helpful chatbot."],
        ["role" => "user", "content" => $userMessage]
    ]
]));

$response = curl_exec($ch);

// Check for cURL errors
if ($response === false) {
    $error = curl_error($ch);
    error_log("cURL Error: " . $error);
    curl_close($ch);
    echo json_encode(["reply" => "Sorry, there was an error processing your request."]);
    exit;
}

curl_close($ch);

// Log API response for debugging
error_log("API Response: " . $response);

$decodedResponse = json_decode($response, true);

// Check if the response contains the expected data
if (isset($decodedResponse['choices'][0]['message']['content'])) {
    $botReply = $decodedResponse['choices'][0]['message']['content'];
} else {
    // Log the decoded response for debugging
    error_log("Decoded Response: " . print_r($decodedResponse, true));
    $botReply = "Sorry, I couldn't process that.";
}

echo json_encode(["reply" => $botReply]);
?>