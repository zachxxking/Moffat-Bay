<!--Moffat Bay Lodge User Registration Backend-->
<?php

// Database connection parameters
$host = "localhost";
$dbname = "moffat_bay_lodge";
$dbuser = "root";
$password = "";

// Create connection
$conn = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone_number = $_POST['phone'];
$password = $_POST['password'];

// Hash the password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (first_name, last_name, email, phone_number, password) VALUES (:first_name, :last_name, :email, :phone_number, :password_hash)";

$stmt = $conn->prepare($sql);

$stmt->bind_param("sssss", $first_name, $last_name, $email, $phone_number, $password_hash);

// Execute the statement
if ($stmt->execute()) {
    echo "<h2>You are registered!</h2>";
    echo "<p>Continue to <a href='login.php'>Login</a></p>";
} else {
    echo "<h2>Error:</h2>" . $stmt->error;
}

$stmt->close();
$conn->close(); 

$check = $conn->prepare("SELECT customer_id FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo "<h2>Email already registered. Please use a different email.</h2>";
    $check->close();
    $conn->close(); 
    exit();
} 
$conn->close();
    
?>

