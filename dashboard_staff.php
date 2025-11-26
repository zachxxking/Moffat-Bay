<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'staff') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Staff Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Allura&family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">
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
    <h1>Staff Dashboard</h1>
    <p>Welcome, staff member. You can manage bookings, view customer data, and handle lodge operations here.</p>
</div>

</body>
</html>
