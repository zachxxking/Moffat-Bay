<!-- 
CSD460 Capstone - Red Team
Contributors: Zachariah King, Ryan Monnier, Tabari Harvey, Jacob Achenbach
Instructor: Sue Sampson
Created October-December 2025
-->

<?php
// reservation_backend.php (Improved)
// CSD460 Capstone - Red Team
session_start();
require_once 'db_connect.php';

$conn = db_connect();

// Require login
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

// Get customer info
$stmt = $conn->prepare("SELECT first_name, last_name, email, phone_number FROM Customer WHERE customer_id = ?");
$stmt->execute([$customer_id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$customer) {
    die("<p>Customer not found. <a href='room_reservation.php'>Go back</a></p>");
}

$first = $customer['first_name'];
$last = $customer['last_name'];
$email = $customer['email'];
$phone = $customer['phone_number'] ?? '';

// Collect and validate form inputs
$room_type_id = intval($_POST['room_type'] ?? 0);
$checkin = trim($_POST['check_in'] ?? '');
$checkout = trim($_POST['check_out'] ?? '');
$guests = intval($_POST['guests'] ?? 0);

if (!$room_type_id || !$checkin || !$checkout || !$guests) {
    die("<p style='max-width:600px;margin:20px auto;color:#900'>All fields are required. <a href='room_reservation.php'>Go back</a></p>");
}

if ($checkout <= $checkin) {
    die("<p style='max-width:600px;margin:20px auto;color:#900'>Check-out must be after check-in. <a href='room_reservation.php'>Go back</a></p>");
}

$checkin_dt = new DateTime($checkin);
$checkout_dt = new DateTime($checkout);
$nights = $checkin_dt->diff($checkout_dt)->days;

if ($nights <= 0) {
    die("<p style='max-width:600px;margin:20px auto;color:#900'>Invalid dates provided. <a href='room_reservation.php'>Go back</a></p>");
}

try {
    $conn->beginTransaction();

    // Get room type info
    $stmt = $conn->prepare("SELECT type_name, price_per_night, max_occupancy FROM Room_type WHERE room_type_id = ?");
    $stmt->execute([$room_type_id]);
    $room_type_info = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$room_type_info) {
        throw new Exception("Invalid room type selected.");
    }

    $type_name = $room_type_info['type_name'];
    $price_per_night = $room_type_info['price_per_night'];
    $max_occupancy = $room_type_info['max_occupancy'];

    if ($guests > $max_occupancy) {
        throw new Exception("Number of guests exceeds room occupancy limit ($max_occupancy).");
    }

    // Check for available room using NOT EXISTS
    $roomQuery = "
        SELECT r.room_id
        FROM Rooms r
        WHERE r.room_type_id = :room_type_id
        AND NOT EXISTS (
            SELECT 1
            FROM Reservation res
            WHERE res.room_id = r.room_id
            AND (:checkin < res.check_out_date AND :checkout > res.check_in_date)
        )
        LIMIT 1
    ";
    $stmt = $conn->prepare($roomQuery);
    $stmt->execute([
        ':room_type_id' => $room_type_id,
        ':checkin' => $checkin,
        ':checkout' => $checkout
    ]);
    $room = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$room) {
        $conn->rollBack();
        die("<p style='max-width:600px;margin:20px auto;color:#900'>No available rooms of that type for the selected dates. Please choose another type or contact us. <a href='room_reservation.php'>Back</a></p>");
    }

    $room_id = $room['room_id'];

    // Calculate total price
    $total_price = $nights * (float)$price_per_night;

    // Insert reservation
    $status = 'Pending';
    $created_at = date('Y-m-d H:i:s');

    $insRes = $conn->prepare("
        INSERT INTO Reservation 
        (customer_id, room_id, check_in_date, check_out_date, num_guests, total_price, status, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $insRes->execute([$customer_id, $room_id, $checkin, $checkout, $guests, $total_price, $status, $created_at]);
    $reservation_id = $conn->lastInsertId();

    $conn->commit();

    // Show confirmation
    echo "<!doctype html><html><head><meta charset='utf-8'><title>Reservation Confirmed</title>
          <link rel='stylesheet' href='moffatbaycss.css'></head><body>";
    echo "<div class='container' style='max-width:800px;margin:40px auto;'><div class='card'><div class='card-content'>";
    echo "<h2>Reservation Confirmed</h2>";
    echo "<p>Thanks, <strong>" . htmlspecialchars($first) . " " . htmlspecialchars($last) . "</strong>.</p>";
    echo "<p>Your reservation #<strong>" . (int)$reservation_id . "</strong> is pending confirmation.</p>";
    echo "<ul>";
    echo "<li>Room Type: " . htmlspecialchars($type_name) . "</li>";
    echo "<li>Check-in: " . htmlspecialchars($checkin) . "</li>";
    echo "<li>Check-out: " . htmlspecialchars($checkout) . " (" . $nights . " nights)</li>";
    echo "<li>Guests: " . (int)$guests . "</li>";
    echo "<li>Total: $" . number_format($total_price, 2) . "</li>";
    echo "</ul>";
    echo "<p><a class='btn-primary' href='reservation_summary.php'>View Reservations</a></p>";
    echo "</div></div></div></body></html>";

} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    die("<p style='max-width:600px;margin:20px auto;color:#900'>An error occurred: " . htmlspecialchars($e->getMessage()) . "</p>");
}
?>