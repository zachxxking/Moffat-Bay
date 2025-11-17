<!--Moffat Bay Lodge User Registration page-->
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

            <!-- Registration Form -->
    <form action="register_backend.php" method="POST">
        <h2>User Registration</h2>

        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Register" class="btn-primary">
    </form>

</body>
</html>
