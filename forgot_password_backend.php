<!-- 
CSD460 Capstone - Red Team
Contributors: Zachariah King, Ryan Monnier, Tabari Harvey, Jacob Achenbach
Instructor: Sue Sampson
Created October-December 2025
-->
<?php
session_start();
require_once 'db_connect.php';
$conn = db_connect(); // PDO connection

// Get email
$email = trim($_POST['email'] ?? '');

// Check if email is provided
if (!$email) {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <link rel='stylesheet' href='moffatbaycss.css'>
        <title>Error</title>
    </head>
    <body>
        <h2>Please provide an email. <a href='forgot_password.php'>Try again</a></h2>
    </body>
    </html>";
    exit;
}

try {
    // Check if email exists
    $stmt = $conn->prepare("SELECT customer_id FROM Customer WHERE email = ?");
    $stmt->execute([$email]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$customer) {
        echo "<!DOCTYPE html>
        <html>
        <head>
            <link rel='stylesheet' href='moffatbaycss.css'>
            <title>Error</title>
        </head>
        <body>
            <h2>Email not found. <a href='forgot_password.php'>Try again</a></h2>
        </body>
        </html>";
        exit;
    }

    // Generate token and expiry (1 hour)
    $token = bin2hex(random_bytes(16));
    $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

    // Store in DB
    $stmt = $conn->prepare("UPDATE Customer SET reset_token = ?, token_expiry = ? WHERE email = ?");
    $stmt->execute([$token, $expiry, $email]);

    // Display reset link (for testing)
    $reset_link = "http://yourdomain.com/reset_password.php?token=$token";

    echo "<!DOCTYPE html>
    <html>
    <head>
        <link rel='stylesheet' href='moffatbaycss.css'>
        <title>Password Reset</title>
    </head>
    <body>
        <h2>Password reset link:</h2>
        <p><a href='$reset_link'>$reset_link</a></p>
    </body>
    </html>";

} catch (PDOException $e) {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <link rel='stylesheet' href='moffatbaycss.css'>
        <title>Error</title>
    </head>
    <body>
        <h2>Database error: " . htmlspecialchars($e->getMessage()) . "</h2>
    </body>
    </html>";
}
?>
