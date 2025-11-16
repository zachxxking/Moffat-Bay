<?php
/* ---------------------------
   Database Connection
----------------------------*/
$host = "localhost";
$user = "root";
$pass = "Your Mysql DB"; // Put Your MySql Password Here
$db   = "moffat_bay_lodge";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("DB Connection Failed: " . $conn->connect_error);
}

/* ---------------------------
   Get Staff
----------------------------*/
$staff_sql = "SELECT first_name, last_name, role FROM Staff";
$staff_result = $conn->query($staff_sql);
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

        <!-- Left Moffat Logo -->
        <a href="index.php" class="lodge-logo">Moffat Bay Lodge</a>

        <!-- Center Nav Links -->
        <ul>
            <li><a href="about.php">About</a></li>
            <li><a href="attractions.php">Attractions</a></li>
            <li><a href="lodging.php">Lodging</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>

        <!-- Right Side Login & Register Buttons -->
        <div style="display:flex; gap:10px;">
            <a href="loginPage.php">
                <button class="btn-primary">Login</button>
            </a>

            <a href="registerPage.php">
                <button class="btn-primary">Register</button>
            </a>
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
    <h2>Meet Our Staff</h2>
    <p>Our amazing team is here to make your stay unforgettable.</p>

    <div class="columns-3">

        <?php
        if ($staff_result->num_rows > 0) {
            while ($s = $staff_result->fetch_assoc()) {

                $name = $s['first_name'] . " " . $s['last_name'];
                $role = $s['role'];

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
    <div class="container" style="text-align:left; display:grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">

        <div>
            <h3>Use cases</h3>
            <p>UI design</p>
            <p>UX design</p>
            <p>Wireframing</p>
            <p>Diagramming</p>
            <p>Brainstorming</p>
        </div>

        <div>
            <h3>Explore</h3>
            <p>Design</p>
            <p>Prototyping</p>
            <p>Development features</p>
            <p>Design systems</p>
            <p>Collaboration features</p>
        </div>

        <div>
            <h3>Resources</h3>
            <p>Blog</p>
            <p>Best practices</p>
            <p>Colors</p>
            <p>Color wheel</p>
            <p>Support</p>
        </div>

    </div>

    <p style="margin-top: 2rem;">&copy; <?php echo date('Y'); ?> Moffat Bay Lodge. All Rights Reserved.</p>
</footer>


</body>
</html>
