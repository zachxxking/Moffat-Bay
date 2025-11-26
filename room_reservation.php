<?php
// room_reservation.php
session_start();

require_once "db_connect.php";

// Require login
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

// Get customer info (optional to display)
$conn = db_connect();
$stmt = $conn->prepare("SELECT first_name, last_name, email FROM Customer WHERE customer_id = ?");
$stmt->execute([$customer_id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

$today = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reserve a Room - Moffat Bay</title>
  <link href="https://fonts.googleapis.com/css2?family=Allura&family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="moffatbaycss.css">

  <style>
    .reservation-form {
        max-width: 600px;
        margin: 30px auto;
        display: flex;
        flex-direction: column;
        gap: 12px;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .reservation-form input,
    .reservation-form select,
    .reservation-form button {
        padding: 10px;
        font-size: 16px;
    }
    .reservation-form button {
        background-color: #6b2f7f;
        color: #fff;
        border: none;
        cursor: pointer;
        transition: background 0.3s;
    }
    .reservation-form button:hover {
        background-color: #50215f;
    }
    .reservation-form label {
        font-weight: bold;
    }
    .readonly-box {
        padding: 12px;
        background: #f7f7f7;
        border: 1px solid #ccc;
        border-radius: 6px;
        margin-bottom: 10px;
    }
  </style>
</head>

<body>

<header>
    <nav>
        <a href="index.php" class="lodge-logo">Moffat Bay Lodge</a>
        <ul>
            <li><a href="about.php">About</a></li>
            <li><a href="attractions.php">Attractions</a></li>
            <li><a href="room_reservation.php">Lodging</a></li>
        </ul>
        <div style="display:flex; gap:10px;">
            <a href="logout.php"><button class="btn-primary">Logout</button></a>
        </div>
    </nav>
</header>

<form action="reservation_backend.php" method="POST" class="reservation-form">

    <h2>Room Reservation</h2>

    <!-- Logged-in customer info display only -->
    <div class="readonly-box">
        <strong>Reservation for:</strong><br>
        <?= htmlspecialchars($customer['first_name'] . ' ' . $customer['last_name']); ?><br>
        <?= htmlspecialchars($customer['email']); ?>
    </div>

    <label for="room_type">Room Type</label>
    <select name="room_type" id="room_type" required>
        <option value="">-- Select Room Type --</option>
        <option value="Family room">Family room</option>
        <option value="Queen room">Queen room</option>
        <option value="King room">King room</option>
        <option value="Standard">Standard</option>
        <option value="Deluxe">Deluxe</option>
        <option value="Suite">Suite</option>
    </select>

    <label for="check_in">Check-in</label>
    <input type="date" name="check_in" id="check_in" min="<?= $today ?>" required>

    <label for="check_out">Check-out</label>
    <input type="date" name="check_out" id="check_out" min="<?= $today ?>" required>

    <label for="guests">Guests</label>
    <input type="number" name="guests" id="guests" min="1" max="10" value="1" required>

    <button type="submit" class="btn-primary">Reserve</button>
</form>

</body>
</html>
