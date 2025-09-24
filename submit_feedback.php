<?php
session_start();
include("config.php"); // MySQLi connection

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$email  = isset($_POST['email'])  ? trim($_POST['email'])  : '';
$rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
$review = isset($_POST['review']) ? trim($_POST['review']) : '';

if (empty($email) || $rating <= 0 || empty($review)) {
    header("Location: index?status=missing_fields");
    exit;
}

// Save feedback
$stmt = mysqli_prepare($con, "INSERT INTO feedback (email, rating, review) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sis", $email, $rating, $review);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// Build star rating for email
$stars = str_repeat('⭐', $rating);

// Prepare PHPMailer
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $mail_user; 
    $mail->Password   = $mail_pass;
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom($email, 'Safar Travel Solution');
    $mail->addAddress($mail_user, 'Admin');
    $mail->addReplyTo($email);

    $mail->isHTML(true);
    $mail->Subject = "New Feedback - Safar Travel Solution";

    // Styled HTML body
    $mail->Body = "
    <div style='font-family: Arial, sans-serif; max-width:600px; margin:0 auto; border:1px solid #e0e0e0; border-radius:10px; overflow:hidden;'>
      <div style='background:#ff6f00; padding:20px; text-align:center; color:white;'>
        <h2 style='margin:0;'>Safar Travel Solution</h2>
        <p style='margin:0; font-size:14px;'>Customer Feedback Notification</p>
      </div>
      <div style='padding:20px;'>
        <h3 style='color:#333;'>You've received new feedback!</h3>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Rating:</strong> <span style='color:#ff9800; font-size:18px;'>{$stars}</span></p>
        <p><strong>Review/Suggestion:</strong></p>
        <div style='background:#f9f9f9; padding:15px; border-radius:5px; border-left:4px solid #ff6f00;'>
          {$review}
        </div>
      </div>
      <div style='background:#f5f5f5; padding:10px; text-align:center; font-size:12px; color:#888;'>
        © " . date('Y') . " Safar Travel Solution. All rights reserved.
      </div>
    </div>";

    $mail->AltBody = "Safar Travel Solution Feedback\nEmail: {$email}\nRating: {$rating} stars\nReview: {$review}";

    $mail->send();
    header("Location: index?status=success");
    exit;
} catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}";
}

mysqli_close($con);
