<!-- 
CSD460 Capstone - Red Team
Contributors: Zachariah King, Ryan Monnier, Tabari Harvey, Jacob Achenbach
Instructor: Sue Sampson
Created October-December 2025
-->
<?php
session_start();

// Must be logged in as a customer
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'customer') {
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Customer Dashboard - Moffat Bay</title>

<link href="https://fonts.googleapis.com/css2?family=Allura&family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="moffatbaycss.css">

<style>
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: var(--space-lg);
    margin-top: var(--space-lg);
}

.dashboard-card {
    background: var(--color-white);
    box-shadow: var(--shadow-soft);
    border-radius: var(--radius-md);
    padding: var(--space-lg);
    text-align: center;
    transition: 0.25s;
}

.dashboard-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-strong);
}

.dashboard-card a {
    text-decoration: none;
    color: var(--color-deep-blue);
    font-size: 1.15rem;
    font-weight: bold;
}

.dashboard-icon {
    font-size: 2.5rem;
    margin-bottom: var(--space-sm);
    color: var(--color-mauve);
}
</style>

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
    <h1>Customer Dashboard</h1>
    <p>Manage your account and reservations below.</p>

    <div class="dashboard-grid">

        <div class="dashboard-card">
            <div class="dashboard-icon">🛏️</div>
            <a href="room_reservation.php">Make a Reservation</a>
        </div>

        <div class="dashboard-card">
            <div class="dashboard-icon">📘</div>
            <a href="reservation_summary.php">My Reservations</a>
        </div>

        <div class="dashboard-card">
            <div class="dashboard-icon">👤</div>
            <a href="customer_profile.php">Update Profile</a>
        </div>

        <div class="dashboard-card" style="background:#b13838;color:white;">
            <div class="dashboard-icon">🚪</div>
            <a href="logout.php" style="color:white;">Logout</a>
        </div>

    </div>
</div>

<!-- FOOTER -->
<footer>
    <p>&copy; <?php echo date('Y'); ?> Moffat Bay Lodge. All rights reserved.</p>
</footer>

</body>
</html>