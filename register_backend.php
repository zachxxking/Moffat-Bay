<?php
// Moffat Bay Lodge User Registration Backend

// Database connection parameters
require_once 'db_connect.php';

try {
    // Create connection using PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request method");
}

// Retrieve form data
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$email = $_POST['email'] ?? '';
$phone_number = $_POST['phone_number'] ?? '';
$password = $_POST['password'] ?? '';

// Validate required fields
if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
    die("<h2>Error:</h2><p>All fields are required.</p>");
}

// Check for duplicate email BEFORE inserting
$check = $conn->prepare("SELECT customer_id FROM Customer WHERE email = ?");
$check->execute([$email]);

if ($check->rowCount() > 0) {
    die("<h2>Email already registered. Please use a different email.</h2>");
}

// Hash the password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insert new user into Customer table
$sql = "INSERT INTO Customer (first_name, last_name, email, phone_number, password_hash, created_at) 
        VALUES (:first_name, :last_name, :email, :phone_number, :password_hash, NOW())";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':first_name' => $first_name,
        ':last_name' => $last_name,
        ':email' => $email,
        ':phone_number' => $phone_number,
        ':password_hash' => $password_hash
    ]);
    
    echo "<h2>You are registered!</h2>";
    echo "<p>Continue to <a href='login.php'>Login</a></p>";
} catch (PDOException $e) {
    echo "<h2>Error:</h2><p>" . $e->getMessage() . "</p>";
}

$conn = null;
?>