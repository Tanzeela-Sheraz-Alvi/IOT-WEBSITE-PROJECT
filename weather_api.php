<?php
$apiKey = $_GET['apikey'];
$city = $_GET['city'];
$units = $_GET['units']; // "metric" for Celsius or "imperial" for Fahrenheit

// API URL to get current weather data
$apiUrl = "https://api.openweathermap.org/data/2.5/weather?q={$city}&units={$units}&appid={$apiKey}";

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute cURL and get the response
$response = curl_exec($ch);

// Check for cURL errors
if ($response === false) {
    echo json_encode(['success' => false, 'message' => 'Error fetching data']);
    exit;
}

// Decode the JSON response
$data = json_decode($response, true);

// Check if the response contains the necessary data
if (isset($data['main']['temp']) && isset($data['main']['humidity'])) {
    $currentTemperature = $data['main']['temp'];
    $currentHumidity = $data['main']['humidity'];

    // Round the humidity to avoid small discrepancies (optional)
    $currentHumidity = round($currentHumidity);

    // Check if humidity or temperature has an invalid value (e.g., zero or below)
    if ($currentHumidity < 0 || $currentHumidity > 100) {
        echo json_encode(['success' => false, 'message' => 'Invalid humidity value']);
        exit;
    }

    // Send the data back to the frontend as JSON
    echo json_encode([
        'success' => true,
        'temp' => $currentTemperature,
        'humidity' => $currentHumidity
    ]);
} else {
    // Handle case where API response doesn't contain necessary data
    echo json_encode(['success' => false, 'message' => 'Unable to fetch weather data or missing data']);
}

// Close cURL session
curl_close($ch);
?>
