<?php
include 'vendor/autoload.php';
// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Get environment variables
$db_host = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_NAME'];
$db_user = $_ENV['DB_USER'];
$db_pass = $_ENV['DB_PASS'];

$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Google API Configuration
$google_api_key = $_ENV['GOOGLE_API_KEY'];
$mail_user = $_ENV['MAIL_USER'];
$mail_pass = $_ENV['MAIL_PASS'];


