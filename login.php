<?php
session_start();
?>
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
<title>Moffat Bay Lodge - Login</title>
<link rel="stylesheet" href="moffatbaycss.css">
</head>
<body>
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

<div class="container">
    <?php if (isset($_GET['registered'])): ?>
        <div class="success-message">
            Account created sucessfully! Please Log in.
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error']) && $_GET['error'] == 'invalid'):?>
        <div class="error-message">
            Invalid email or password. Please try again.
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error']) && $_GET['error'] == 'notfound'): ?>
        <div class="error-message">
            Email not found. Please register for an account.
        </div>
    <?php endif; ?>
   
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="success-message">
            <?php 
                echo htmlspecialchars($_SESSION['success_message']); 
                unset($_SESSION['success_message']); 
            ?>
        </div>
    <?php endif; ?>

    <form action="login_backend.php" method="POST">
        <h2 style="text-align:center;">Login</h2>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" class="btn-primary">Login</button>

        <p style="text-align:center; margin-top:1rem;">
            <a href="forgot_password.php">Forgot Password?</a> | 
            <a href="register.php">Register</a>
        </p>
    </form>
</div>

</body>
</html>