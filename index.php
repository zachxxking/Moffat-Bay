<!-- 
CSD460 Capstone - Red Team
Contributors: Zachariah King, Ryan Monnier, Tabari Harvey, Jacob Achenbach
Instructor: Sue Sampson
Created October-December 2025
-->
<?php
require_once 'db_connect.php';
$conn = db_connect(); // PDO connection

// Fetch staff
try {
    $stmt = $conn->query("SELECT first_name, last_name, role FROM Staff");
    $staff_result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Moffat Bay Lodge</title>

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Allura&family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="moffatbaycss.css">

</head>

<body>


<!-- Header / Nav -->
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

       <div style="display:flex; gap:10px;">
            <a href="login.php"><button class="btn-primary">Login</button></a>
            <a href="register.php"><button class="btn-primary">Register</button></a>
       </div>
    </nav>
</header>

<!-- HERO SECTION -->
<div class="hero" style="background-image: url('images/BackgroundWoods.jpg');">
    <div class="hero-content">
        <h1>Welcome to Moffat Bay Lodge!</h1>
    </div>
</div>

<!-- STAFF SECTION -->
<div class="container">
    <h2>Are you ready for next-level paradise?!</h2>
    <p>Our amazing team is here to make your stay unforgettable.</p>

    <div class="columns-3">
        <?php
        if (!empty($staff_result)) {
            foreach ($staff_result as $s) {
                $name = htmlspecialchars($s['first_name'] . " " . $s['last_name']);
                $role = htmlspecialchars($s['role']);

                // Auto Role for Setting Images
                $image = "images/default.jpg";
                if ($role === "Maid") {
                    $image = "images/Maid.jpg";
                } elseif ($role === "Maintenance") {
                    $image = "images/MaintanceGuy.jpg";
                } elseif ($role === "Manager") {
                    $image = "images/manager.jpg";
                }

                echo "
                <div class='card'>
                    <img src='$image' alt='$role'>
                    <div class='card-content'>
                        <h3>$name</h3>
                        <p>$role</p>
                    </div>
                </div>
                ";
            }
        }
        ?>
    </div>
</div>

<!-- FOOTER -->
<footer>
    <p>&copy; <?php echo date('Y'); ?> Moffat Bay Lodge. All rights reserved.</p>
</footer>