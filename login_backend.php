<!-- 
CSD460 Capstone - Red Team
Contributors: Zachariah King, Ryan Monnier, Tabari Harvey, Jacob Achenbach
Instructor: Sue Sampson
Created October-December 2025
-->

<?php
session_start();

require_once 'db_connect.php';
$conn = db_connect();

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    header("Location: login.php?error=invalid");
    exit();
}

/* =========================
   1. Check Staff table
   ========================= */
try {
    $stmt = $conn->prepare("SELECT * FROM Staff WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id']   = $user['staff_id'];
        $_SESSION['user_type'] = 'staff';
        $_SESSION['user_name'] = $user['first_name'];

        header("Location: index.php");
        exit();
    }
} catch (PDOException $e) {
    die("Database error: " . htmlspecialchars($e->getMessage()));
}

/* =========================
   2. Check Customer table
   ========================= */
try {
    $stmt = $conn->prepare("SELECT * FROM Customer WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id']   = $user['customer_id'];
        $_SESSION['user_type'] = 'customer';
        $_SESSION['user_name'] = $user['first_name'];

        header("Location: index.php");
        exit();
    }
} catch (PDOException $e) {
    die("Database error: " . htmlspecialchars($e->getMessage()));
}

/* =========================
   3. Login failed
   ========================= */
header("Location: login.php?error=invalid");
exit();