<!-- 
CSD460 Capstone - Red Team
Contributors: Zachariah King, Ryan Monnier, Tabari Harvey, Jacob Achenbach
Instructor: Sue Sampson
Created October-December 2025
-->
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>

    <!-- Link to your shared CSS file -->
    <link href="https://fonts.googleapis.com/css2?family=Allura&family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="moffatbaycss.css">
</head>
<body>

<!-- Header / Nav -->
<header>
    <nav>
        <a href="index.php" class="lodge-logo">Moffat Bay Lodge</a>
        <ul>
            <li><a href="about.php">About</a></li>
            <li><a href="attractions.php">Attractions</a></li>
            <li><a href="room_reservation.php">Lodging</a></li>
        </ul>
        <div style="display:flex; gap:10px;">
            <a href="login.php"><button class="btn-primary">Login</button></a>
            <a href="register.php"><button class="btn-primary">Register</button></a>
        </div>
    </nav>
</header>

<div class="box">
    <h2>Forgot Your Password?</h2>
    <p>Enter your email to receive a reset link.</p>

    <form action="forgot_password_backend.php" method="POST">
        <input type="email" name="email" placeholder="Enter your email" required><br>
        <input type="submit" value="Send Reset Link">
    </form>

</div>
<!-- FOOTER -->
<footer>
    <p>&copy; <?php echo date('Y'); ?> Moffat Bay Lodge. All rights reserved.</p>
</footer>

</body>
</html>