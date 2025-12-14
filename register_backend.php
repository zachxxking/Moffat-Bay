<!-- 
CSD460 Capstone - Red Team
Contributors: Zachariah King, Ryan Monnier, Tabari Harvey, Jacob Achenbach
Instructor: Sue Sampson
Created October-December 2025
-->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Use shared PDO connection
require_once 'db_connect.php';
$conn = db_connect(); 

// Retrieve form data safely
$first_name   = trim($_POST['first_name']   ?? '');
$last_name    = trim($_POST['last_name']    ?? '');
$email        = trim($_POST['email']        ?? '');
$phone        = trim($_POST['phone']        ?? '');
$password_raw = $_POST['password']          ?? '';

if (!$first_name || !$last_name || !$email || !$password_raw) {
    die("Missing required fields. <a href='register.php'>Go Back</a>");
}

// Hash password
$password_hash = password_hash($password_raw, PASSWORD_DEFAULT);

try {
    // Check if email already exists
    $check = $conn->prepare("SELECT customer_id FROM Customer WHERE email = ?");
    $check->execute([$email]);

    if ($check->rowCount() > 0) {
        die("<h2>Email already registered. <a href='register.php'>Try again</a></h2>");
    }

    // Insert new customer
    $stmt = $conn->prepare("
        INSERT INTO Customer 
        (first_name, last_name, email, phone_number, password_hash, created_at)
        VALUES (?, ?, ?, ?, ?, NOW())
    ");

    $stmt->execute([
        $first_name,
        $last_name,
        $email,
        $phone,
        $password_hash
    ]);

    echo "<h2>You are registered!</h2>";
    echo "<p>Continue to <a href='login.php'>Login</a></p>";

} catch (PDOException $e) {
    die("Database error: " . htmlspecialchars($e->getMessage()));
}
?>