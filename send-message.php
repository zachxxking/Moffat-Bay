<!-- 
CSD460 Capstone - Red Team
Contributors: Zachariah King, Ryan Monnier, Tabari Harvey, Jacob Achenbach
Instructor: Sue Sampson
Created October-December 2025
-->

<?php
require_once "db_connect.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request.");
}

// Connect using shared PDO
$conn = db_connect();

// Pull inputs
$name    = trim($_POST["name"] ?? "");
$email   = trim($_POST["email"] ?? "");
$message = trim($_POST["message"] ?? "");

// Basic validation
if (!$name || !$email || !$message) {
    die("All fields are required.");
}

try {

    $stmt = $conn->prepare("
        INSERT INTO contact_messages (name, email, message, created_at)
        VALUES (:name, :email, :message, NOW())
    ");

    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":message", $message);
    $stmt->execute();

    // redirect back with success message
    header("Location: about.php?success=1");
    exit();

} catch (PDOException $e) {
    die("Error: " . htmlspecialchars($e->getMessage()));
}
?>
