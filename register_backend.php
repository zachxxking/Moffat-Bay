<?php
// Start session
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

// Get form data
$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);
$email = trim($_POST['email']);
$phone_number = trim($_POST['phone_number']);
$password = $_POST['password'];

// Check if email already exists
$stmt = $conn->prepare("SELECT customer_id FROM Customer WHERE email = :email");
$stmt->bindParam(":email", $email);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    die("<h2>Email already registered. <a href='register.php'>Try a different email</a></h2>");
}

// Hash the password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insert new customer
$stmt = $conn->prepare("INSERT INTO Customer (first_name, last_name, email, phone_number, password_hash) 
                        VALUES (:first_name, :last_name, :email, :phone_number, :password_hash)");
$stmt->bindParam(":first_name", $first_name);
$stmt->bindParam(":last_name", $last_name);
$stmt->bindParam(":email", $email);
$stmt->bindParam(":phone_number", $phone_number);
$stmt->bindParam(":password_hash", $password_hash);

if ($stmt->execute()) {
    echo "<h2>Registration successful!</h2>";
    echo "<p>Go to <a href='login.php'>Login</a></p>";
} else {
    echo "<h2>Registration failed. Please try again.</h2>";
}
?>
