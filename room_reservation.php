<!-- 
CSD460 Capstone - Red Team
Contributors: Zachariah King, Ryan Monnier, Tabari Harvey, Jacob Achenbach
Instructor: Sue Sampson
Created October-December 2025
-->
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

// Fetch room types dynamically
$roomStmt = $conn->query("SELECT room_type_id, type_name, price_per_night, max_occupancy FROM Room_type ORDER BY room_type_id ASC");
$room_types = $roomStmt->fetchAll(PDO::FETCH_ASSOC);

$today = date('Y-m-d');

// -------------------------------
// Calculate total price if "Calculate Price" button clicked
// -------------------------------
$total_price = 0;
$nights = 0;
$selected_room_type = $_POST['room_type'] ?? '';
$check_in = $_POST['check_in'] ?? '';
$check_out = $_POST['check_out'] ?? '';

if (isset($_POST['calculate_price']) && $selected_room_type && $check_in && $check_out) {
    $checkin_dt = new DateTime($check_in);
    $checkout_dt = new DateTime($check_out);
    $nights = $checkin_dt->diff($checkout_dt)->days;

    // Prevent negative or zero nights
    if ($nights > 0) {
        foreach ($room_types as $room) {
            if ($room['room_type_id'] == $selected_room_type) {
                $total_price = $nights * $room['price_per_night'];
                break;
            }
        }
    }
}
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
    .reservation-form { max-width: 600px; margin: 30px auto; display: flex; flex-direction: column; gap: 12px; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    .reservation-form input, .reservation-form select, .reservation-form button { padding: 10px; font-size: 16px; }
    .reservation-form button { background-color: #6b2f7f; color: #fff; border: none; cursor: pointer; transition: background 0.3s; }
    .reservation-form button:hover { background-color: #50215f; }
    .reservation-form label { font-weight: bold; }
    .readonly-box { padding: 12px; background: #f7f7f7; border: 1px solid #ccc; border-radius: 6px; margin-bottom: 10px; }
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
            <?php if (isset($_SESSION['customer_id'])): ?>
                <li><a href="dashboard_customer.php">Dashboard</a></li>
            <?php endif; ?>
        </ul>
        <div style="display:flex; gap:10px;">
            <?php if (isset($_SESSION['customer_id'])): ?>
                <a href="logout.php"><button class="btn-primary">Logout</button></a>
            <?php else: ?>
                <a href="login.php"><button class="btn-primary">Login</button></a>
            <?php endif; ?>
        </div>
    </nav>
</header>

<form action="room_reservation.php" method="POST" class="reservation-form">

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
        <?php foreach ($room_types as $room): ?>
            <option value="<?= $room['room_type_id']; ?>" <?= ($room['room_type_id'] == $selected_room_type) ? 'selected' : '' ?>>
                <?= htmlspecialchars($room['type_name']); ?> - $<?= number_format($room['price_per_night'], 2); ?>/night
            </option>
        <?php endforeach; ?>
    </select>

    <label for="check_in">Check-in</label>
    <input type="date" name="check_in" id="check_in" min="<?= $today ?>" value="<?= htmlspecialchars($check_in) ?>" required>

    <label for="check_out">Check-out</label>
    <input type="date" name="check_out" id="check_out" min="<?= $today ?>" value="<?= htmlspecialchars($check_out) ?>" required>

    <label for="guests">Guests</label>
    <input type="number" name="guests" id="guests" min="1" max="10" value="<?= htmlspecialchars($_POST['guests'] ?? 1) ?>" required>

    <button type="submit" name="calculate_price">Calculate Price</button>

    <?php if ($nights > 0 && $total_price > 0): ?>
        <div class="readonly-box">
            Total Price for <?= $nights ?> night(s): $<?= number_format($total_price, 2); ?>
        </div>
    <?php endif; ?>

    <!-- Actual reservation submit button -->
    <button type="submit" formaction="reservation_backend.php">Reserve</button>
</form>
</body>
</html>
