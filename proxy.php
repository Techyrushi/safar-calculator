<?php
require_once 'config.php';

// Check if origin and destination parameters are provided
if (!isset($_GET['origin']) || !isset($_GET['destination'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Origin and destination parameters are required']);
    exit;
}

// Get parameters
$origin = urlencode($_GET['origin']);
$destination = urlencode($_GET['destination']);

// Check if API key is configured
if (!isset($google_api_key) || empty($google_api_key)) {
    http_response_code(500);
    echo json_encode(['error' => 'Google API key is not configured']);
    exit;
}

// Build the Google API URL
$url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$origin}&destinations={$destination}&key={$google_api_key}&mode=driving";

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

// Execute the request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Check for cURL errors
if (curl_errno($ch)) {
    http_response_code(500);
    echo json_encode(['error' => 'cURL error: ' . curl_error($ch)]);
    curl_close($ch);
    exit;
}

curl_close($ch);

// Set the content type header
header('Content-Type: application/json');

// Return the response from Google API
echo $response;
?>