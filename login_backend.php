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
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Get form data
$email = trim($_POST['email']);
$password = $_POST['password'];

// First, check if email exists in Staff table
$stmt = $conn->prepare("SELECT * FROM Staff WHERE email = :email");
$stmt->bindParam(":email", $email);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (password_verify($password, $user['password_hash'])) {
        // Successful staff login
        $_SESSION['user_id'] = $user['staff_id'] ?? $user['id'] ?? null;
        $_SESSION['user_type'] = 'staff';
        $_SESSION['user_name'] = $user['first_name'];

        header("Location: dashboard_staff.php");
        exit();
    } else {
        die("Incorrect password for staff. <a href='login.php'>Try again</a>");
    }
}

// If not staff, check Customer table
$stmt = $conn->prepare("SELECT * FROM Customer WHERE email = :email");
$stmt->bindParam(":email", $email);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (password_verify($password, $user['password_hash'])) {
        // Successful customer login
        $_SESSION['user_id'] = $user['customer_id'];
        $_SESSION['user_type'] = 'customer';
        $_SESSION['user_name'] = $user['first_name'];

        header("Location: dashboard_customer.php");
        exit();
    } else {
        die("Incorrect password for customer. <a href='login.php'>Try again</a>");
    }
} else {
    die("Email not found. <a href='register.php'>Register here</a>");
}
?>
