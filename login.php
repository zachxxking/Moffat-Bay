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
