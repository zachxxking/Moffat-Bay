<!-- 
CSD460 Capstone - Red Team
Contributors: Zachariah King, Ryan Monnier, Tabari Harvey, Jacob Achenbach
Instructor: Sue Sampson
Created October-December 2025
-->

<!-- Moffat Bay Lodge User Registration page -->
<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moffat Bay Lodge - User Registration</title>

    <!-- Team shared fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Allura&family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Team shared stylesheet -->
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

<form action="register_backend.php" method="POST" class="form-card">
    <h2>User Registration</h2>

    <label for="first_name">First Name:</label>
    <input type="text" id="first_name" name="first_name" required>

    <label for="last_name">Last Name:</label>
    <input type="text" id="last_name" name="last_name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="phone">Phone Number:</label>
    <input 
        type="tel"
        id="phone"
        name="phone"
        required
        pattern="^(\(\d{3}\)\s|\d{3}-)\d{3}-\d{4}$"
        placeholder="123-456-7890 or (123) 456-7890"
        title="Phone number must be in the format 123-456-7890 or (123) 456-7890">

    <label for="password">Password:</label>
    <input 
        type="password"
        id="password"
        name="password"
        required
        minlength="8"
        pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}"
        title="Password must be at least 8 characters and include uppercase, lowercase, number, and special character">

    <input type="submit" value="Register" class="btn-primary">

    <p style="text-align:center; margin-top:1rem;">
        Already have an account? <a href="login.php">Login here</a> |
        <a href="index.php">Home</a>
    </p>
</form>

<!-- FOOTER -->
<footer>
    <p>&copy; <?php echo date('Y'); ?> Moffat Bay Lodge. All rights reserved.</p>
</footer>

</body>
</html>