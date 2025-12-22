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

// Validate phone number format
$phone_pattern = '/^(\(\d{3}\)\s|\d{3}-)\d{3}-\d{4}$/';
if (!preg_match($phone_pattern, $phone)) {
    die("Invalid phone number format. <a href='register.php'>Go back</a>");
}

// Normalize phone number (digits only)
$phone = preg_replace('/\D/', '', $phone);

// Validate password strength
$password_pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
if (!preg_match($password_pattern, $password_raw)) {
    die("Password must be at least 8 characters and include uppercase, lowercase, number, and special character. <a href='register.php'>Go back</a>");
}

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

    // Set success message
    $_SESSION['success_message'] = "Registration successful! You may now log in.";

    // Redirect to login page
    header("Location: login.php");
    exit();

} catch (PDOException $e) {
    die("Database error: " . htmlspecialchars($e->getMessage()));
}
?>