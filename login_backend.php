<!-- 
CSD460 Capstone - Red Team
Contributors: Zachariah King, Ryan Monnier, Tabari Harvey, Jacob Achenbach
Instructor: Sue Sampson
Created October-December 2025
-->

<?php
session_start();

require_once 'db_connect.php'; // Use shared connection script
$conn = db_connect();          // Get PDO connection

// Get form data safely
$email = trim($_POST['email']);
$password = $_POST['password'];

// ----------------------------
// 1. Check Staff table
// ----------------------------
try {
    $stmt = $conn->prepare("SELECT * FROM Staff WHERE email = :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $staff = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $staff['password_hash'])) {

            // Staff login success
            $_SESSION['staff_id'] = $staff['staff_id'];
            $_SESSION['user_type'] = 'staff';
            $_SESSION['user_name'] = $staff['first_name'];

            header("Location: dashboard_staff.php");
            exit();
        } else {
            die("Incorrect password for staff. <a href='login.php'>Try again</a>");
        }
    }
} catch (PDOException $e) {
    die("Database error: " . htmlspecialchars($e->getMessage()));
}

// ----------------------------
// 2. Check Customer table
// ----------------------------
try {
    $stmt = $conn->prepare("SELECT * FROM Customer WHERE email = :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $customer['password_hash'])) {

            // Customer login success
            $_SESSION['customer_id'] = $customer['customer_id'];
            $_SESSION['user_type'] = 'customer';
            $_SESSION['user_name'] = $customer['first_name'];

            header("Location: dashboard_customer.php");
            exit();
        } else {
            die("Incorrect password for customer. <a href='login.php'>Try again</a>");
        }
    } else {
        die("Email not found. <a href='register.php'>Register here</a>");
    }
} catch (PDOException $e) {
    die("Database error: " . htmlspecialchars($e->getMessage()));
}
?>