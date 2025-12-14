<!-- 
CSD460 Capstone - Red Team
Contributors: Zachariah King, Ryan Monnier, Tabari Harvey, Jacob Achenbach
Instructor: Sue Sampson
Created October-December 2025
-->

<?php
// Include the shared PDO connection
require_once 'db_connect.php';
$conn = db_connect(); // $conn is a PDO object
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
       <div class="nav-left">
           <img src="images/salmon.png" alt="Salmon Logo" class="salmon-logo">
           <a href="index.php" class="lodge-logo">Moffat Bay Lodge</a>
       </div>

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
          The original cabin was built in the early 1960s by the Goodwin family. They were immediately drawn to the bay’s natural beauty and abundant wildlife from having the best of both worlds (the mountains and the sea).
        </p>
      </div>
    </div>

    <div class="card">
      <img src="images/history2.jpg" alt="Vintage Dock Photo">
      <div class="card-content">
        <h3>Life on the Water</h3>
        <p>
          Fishing and boating made Moffat Bay a lively gathering place long before it became a modern oasis.
        </p>
      </div>
    </div>

    <div class="card">
      <img src="images/history3.jpg" alt="Old Bay Photo">
      <div class="card-content">
        <h3>Preserved Tradition</h3>
        <p>
          Through careful restoration and considerate expansion, the lodge has maintained its rustic charm while offering supreme contemporary comfort.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- LODGE CONTACT INFORMATION -->
<section class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
    <h2>Lodge Contact Information</h2>

    <div style="font-size: 1.1rem; line-height: 1.6; max-width: 700px;">
        <p><strong>Moffat Bay Lodge</strong></p>
        <p>112 Marina View Drive<br>
           Moffat Bay, Joviedsa Island, WA 98262</p>

        <p><strong>Phone:</strong> (360) 555-4821</p>
        <p><strong>Email:</strong> info@moffatbaylodge.com</p>

        <p><strong>Front Desk Hours:</strong><br>
           Sunday – Thursday: 7:00 AM – 9:00 PM<br>
           Friday – Saturday: 7:00 AM – 11:00 PM
        </p>

        <p><strong>Marina Office:</strong> (360) 555-4877</p>

        <p><strong>Emergency Line (On-Island Guests Only):</strong> (360) 555-0009</p>

        <p><strong>Ferry Schedule Assistance:</strong><br>
           Reach out 24/7 for help arranging transport to Joviedsa Island.</p>

        <p>
            Moffat Bay Lodge and Marina operate under the guidance of the
            <em>San Juan Islands First Nations Development Committee</em>.
        </p>
    </div>
</section>
<!-- CONTACT US -->
<section class="container">
  <h2>Contact Us</h2>

  <?php if (isset($_GET['success'])): ?>
  <div style="background:#c8e6c9;color:#2e7d32;padding:1rem;border-radius:8px;text-align:center;margin-bottom:1.5rem;">
    Your message has been sent successfully!
  </div>
  <?php endif; ?>

  <form class="contact-form" action="send_message.php" method="POST">
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
