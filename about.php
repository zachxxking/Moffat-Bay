<?php
/* ---------------------------
   Database Connection
----------------------------*/
$host = "localhost";
$user = "root";
$pass = ""; 
$db   = "moffat_bay_lodge";

try {
    // Create PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About – Moffat Bay Lodge</title>

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Allura&family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- MAIN CSS -->
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
        </ul>

        <!-- Right Side Login & Register Buttons -->
        <div style="display:flex; gap:10px;">
            <a href="login.php">
                <button class="btn-primary">Login</button>
            </a>

            <a href="register.php">
                <button class="btn-primary">Register</button>
            </a>
        </div>

    </nav>
</header>

<!-- ABOUT PAGE HERO -->
<section class="hero" style="background-image: url('images/about-hero.jpg');">
  <div class="hero-content">
    <h1>About Moffat Bay Lodge</h1>
    <p>A Little Slice of Heaven</p>
  </div>
</section>

<!-- ABOUT OVERVIEW -->
<section class="container">
  <h2>Our Story</h2>
  <p>
Nestled in the serene shores of the breathtaking Moffat Bay, our five-star lodge stands strong as a reliable retreat for anyone seeking comfort, adventure, and everything in between. What started as an annual family vacation has grown into a beloved sanctuary for visitors from all over the globe! We pride ourselves in being the best at everything, but especially to our vital guests, so if you have any concerns you may need to address, please use our Contact Us form below.
  </p>
</section>

<!-- HISTORY SECTION -->
<section class="container">
  <h2>History of the Lodge</h2>

  <div class="columns-3">
    <div class="card">
      <img src="images/history1.jpg" alt="Historic Lodge Photo">
      <div class="card-content">
        <h3>Early Beginnings</h3>
        <p>
          <!-- Replace with real text -->
          The original cabin was built in the early 1960s by the Goodwin family. They were immediately drawn to the bay’s natural beauty and abundant wildlife from having the best of both worlds (the mountains and the sea).
        </p>
      </div>
    </div>

    <div class="card">
      <img src="images/history2.jpg" alt="Vintage Dock Photo">
      <div class="card-content">
        <h3>Life on the Water</h3>
        <p>
          Fishing and boating made Moffat Bay a lively gathering place long
          before it became a modern oasis.
        </p>
      </div>
    </div>

    <div class="card">
      <img src="images/history3.jpg" alt="Old Bay Photo">
      <div class="card-content">
        <h3>Preserved Tradition</h3>
        <p>
          Through careful restoration and considerate expansion, the lodge has maintained its rustic
          charm while offering supreme contemporary comfort.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- CONTACT US -->
<section class="container">
  <h2>Contact Us</h2>

  <?php if (isset($_GET['success'])): ?>
  <div style="background:#c8e6c9;color:#2e7d32;padding:1rem;border-radius:8px;text-lign:center;margin-bottom:1.5rem;">
  Your message has been sent successfully!
  </div>
  <?php endif; ?>

  <form class="contact-form" action="send-message.php" method="POST">
    <label for="name">Name</label>
    <input type="text" id="name" name="name" placeholder="Your Name" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" placeholder="youremail@example.com" required>

    <label for="message">Message</label>
    <textarea id="message" name="message" placeholder="How can we help?" rows="6"
      style="width:100%; padding: var(--space-sm); border-radius: var(--radius-md); border: 1px solid var(--color-greenblue);" 
      required></textarea>

    <button type="submit" class="btn-primary">Send Message</button>
  </form>
</section>

<!-- FOOTER -->
<footer>
    <p>&copy; <?php echo date('Y'); ?> Moffat Bay Lodge. All rights reserved.</p>
</footer>

</body>
</html>