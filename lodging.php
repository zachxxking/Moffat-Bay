<!-- 
CSD460 Capstone - Red Team
Contributors: Zachariah King, Ryan Monnier, Tabari Harvey, Jacob Achenbach
Instructor: Sue Sampson
Created October-December 2025
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lodging | Moffat Bay Lodge</title>

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Allura&family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="moffatbaycss.css">
</head>

<body>

<!-- Header / Nav -->
<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header>
   <nav>
       <div class="nav-left">
           <img src="images/salmon.png" alt="Salmon Logo" class="salmon-logo">
           <a href="index.php" class="lodge-logo">Moffat Bay Lodge</a>
       </div>

       <ul>
           <li><a href="about.php">About</a></li>
           <li><a href="attractions.php">Attractions</a></li>
           <li><a href="lodging.php">Lodging</a></li>
       </ul>

       <div style="display:flex; gap:10px; align-items:center;">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <!-- Show Login/Register for guests -->
                <a href="login.php"><button class="btn-primary">Login</button></a>
                <a href="register.php"><button class="btn-primary">Register</button></a>
            <?php else: ?>
                <!-- Show welcome and logout for logged-in users -->
                <span style="color:white; font-weight:bold;">
                    Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
                </span>
                <a href="logout.php"><button class="btn-secondary">Logout</button></a>
            <?php endif; ?>
       </div>
    </nav>
</header>

<!-- HERO SECTION -->
<div class="hero" style="background-image: url('images/room-hero.jpg');">
    <div class="hero-content">
        <h1>Our Accommodations</h1>
    </div>
</div>

<!-- ROOMS SECTION -->
<div class="container">
    <h2>Comfort for Every Kind of Stay</h2>
    <p>Whether you're visiting with family or escaping for a quiet retreat, we have the perfect room.</p>

    <div class="columns-3">

        <!-- FAMILY ROOM -->
        <div class="card">
            <img src="images/family-room.jpg" alt="Family Room">
            <div class="card-content">
                <h3>Family Room</h3>
                <p>Spacious lodging ideal for families, featuring multiple beds and extra living space.</p>
                <p><strong>$138.86 / night</strong></p>
                <a href="room_reservation.php">
                    <button class="btn-primary">Book Now</button>
                </a>
            </div>
        </div>

        <!-- QUEEN ROOM -->
        <div class="card">
            <img src="images/queen-room.jpg" alt="Queen Room">
            <div class="card-content">
                <h3>Queen Room</h3>
                <p>A cozy and comfortable room with a queen-sized bed, perfect for couples.</p>
                <p><strong>$120.75 / night</strong></p>
                <a href="room_reservation.php">
                    <button class="btn-primary">Book Now</button>
                </a>
            </div>
        </div>

        <!-- KING ROOM -->
        <div class="card">
            <img src="images/king-room.jpg" alt="King Room">
            <div class="card-content">
                <h3>King Room</h3>
                <p>Our premium option offering extra space, luxury amenities, and a king-sized bed.</p>
                <p><strong>$315 / night</strong></p>
                <a href="room_reservation.php">
                    <button class="btn-primary">Book Now</button>
                </a>
            </div>
        </div>

    </div>
</div>

<!-- FOOTER -->
<footer>
    <p>&copy; <?php echo date('Y'); ?> Moffat Bay Lodge. All rights reserved.</p>
</footer>

</body>
</html>