<?php
session_start();

// Database connection
$host = "localhost";
$dbname = "moffat_bay_lodge";
$dbuser = "root";
$dbpass = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get email
$email = trim($_POST['email']);

// Check if email exists
$stmt = $conn->prepare("SELECT customer_id FROM Customer WHERE email = :email");
$stmt->bindParam(":email", $email);
$stmt->execute();

if ($stmt->rowCount() === 0) {
    die("<h2>Email not found. <a href='forgot_password.php'>Try again</a></h2>");
}

// Generate token and expiry (1 hour)
$token = bin2hex(random_bytes(16));
$expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

// Store in DB
$stmt = $conn->prepare("UPDATE Customer SET reset_token = :token, token_expiry = :expiry WHERE email = :email");
$stmt->bindParam(":token", $token);
$stmt->bindParam(":expiry", $expiry);
$stmt->bindParam(":email", $email);
$stmt->execute();

// Display reset link (replace with email sending in production)
$reset_link = "http://yourdomain.com/reset_password.php?token=$token";
echo "<h2>Password reset link:</h2>";
echo "<p><a href='$reset_link'>$reset_link</a></p>";
?>
