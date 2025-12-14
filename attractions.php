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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attractions – Moffat Bay Lodge</title>

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Allura&family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="moffatbaycss.css"> 

    <style>

        .attraction-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 12px;
        }
    </style>
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
<section class="hero" style="background-image: url('images/attractions-hero.jpg');">
    <div class="hero-content">
        <h1>Discover Moffat Bay Adventures</h1>
        <p>Exciting Activities for Every Visitor</p>
    </div>
</section>

<!-- ATTRACTIONS SECTION -->
<section class="container">
    <h2>Island Activities</h2>
    <p>Whether you’re looking for adventure or relaxation, Moffat Bay has something for everyone. Explore our top activities below!</p>

    <div class="columns-3">
        <!-- Hiking -->
        <div class="card attraction-card">
            <img src="images/hiking.jpg" alt="Hiking">
            <div class="card-content">
                <h3>Hiking Trails</h3>
                <p>Explore lush forests and scenic viewpoints on our well-marked trails. Perfect for both beginners and seasoned hikers.</p>
            </div>
        </div>

        <!-- Kayaking -->
        <div class="card attraction-card">
            <img src="images/kayaking.jpg" alt="Kayaking">
            <div class="card-content">
                <h3>Kayaking</h3>
                <p>Paddle along the pristine coastline, discover hidden coves, and enjoy the calm waters of Moffat Bay.</p>
            </div>
        </div>

        <!-- Whale Watching -->
        <div class="card attraction-card">
            <img src="images/whale-watching.jpg" alt="Whale Watching">
            <div class="card-content">
                <h3>Whale Watching</h3>
                <p>Join our guided boat tours for a chance to see majestic whales and other marine life in their natural habitat.</p>
            </div>
        </div>

        <!-- Scuba Diving -->
        <div class="card attraction-card">
            <img src="images/scuba-diving.jpg" alt="Scuba Diving">
            <div class="card-content">
                <h3>Scuba Diving</h3>
                <p>Experience the underwater wonders of Joviedsa Island with our professional scuba diving excursions.</p>
            </div>
        </div>
    </div>
    <p>See something perfect for you and want to schedule a session? Use the Contact Us section on our <a href="about.php">About</a> page to inquire!</p>
</section>

<!-- FOOTER -->
<footer>
    <p>&copy; <?php echo date('Y'); ?> Moffat Bay Lodge. All rights reserved.</p>
</footer>

</body>
</html>
