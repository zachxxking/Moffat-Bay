<?php
session_start();
require_once "db_connect.php";

try {
    $conn = db_connect();

    // Get email safely
    $email = trim($_POST['email'] ?? '');

    if (!$email) {
        die("<h2>Email is required. <a href='forgot_password.php'>Try again</a></h2>");
    }

    // Check if email exists
    $stmt = $conn->prepare("SELECT customer_id FROM Customer WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("<h2>Email not found. <a href='forgot_password.php'>Try again</a></h2>");
    }

    // Generate reset token + expiry (1 hour)
    $token = bin2hex(random_bytes(16));
    $expiry = date("Y-m-d H:i:s", time() + 3600);

    // Store token in database
    $stmt = $conn->prepare("
        UPDATE Customer 
        SET reset_token = :token, token_expiry = :expiry 
        WHERE email = :email
    ");
    $stmt->execute([
        ':token' => $token,
        ':expiry' => $expiry,
        ':email'  => $email
    ]);

    // Reset link (change to your actual domain)
    $reset_link = "http://localhost/MoffatBayProject/reset_password.php?token=$token";

} catch (Exception $e) {
    die("<h2>Error: " . htmlspecialchars($e->getMessage()) . "</h2>");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset Link</title>
    <link rel="stylesheet" href="moffatbaycss.css">
</head>
<body>
    <div class="container" style="max-width:600px;margin:40px auto;">
        <h2>Your password reset link is ready</h2>
        <p>Click below to reset your password:</p>

        <p>
            <a href="<?= htmlspecialchars($reset_link); ?>" style="font-size:18px;">
                <?= htmlspecialchars($reset_link); ?>
            </a>
        </p>

        <p style="margin-top:20px;">
            <a class="btn-primary" href="login.php">Back to Login</a>
        </p>
    </div>
</body>
</html>