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
