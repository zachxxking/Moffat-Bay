<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'customer') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Customer Dashboard</title>
<link rel="stylesheet" href="moffatbaycss.css">
</head>
<body>

<header>
    <nav>
        <a href="#" class="lodge-logo">Moffat Bay Lodge</a>
        <ul>
            <li>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <h1>Customer Dashboard</h1>
    <p>Welcome to your account. Here you can make reservations, view your bookings, and update your profile.</p>
</div>

</body>
</html>
