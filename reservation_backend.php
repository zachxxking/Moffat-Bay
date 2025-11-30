<!-- 
CSD460 Capstone - Red Team
Contributors: Zachariah King, Ryan Monnier, Tabari Harvey, Jacob Achenbach
Instructor: Sue Sampson
Created October-December 2025
-->

<?php
// reservation_backend.php
require_once 'db_connect.php';

$conn = db_connect();

// Collect and sanitize form inputs
$first = trim($_POST['first_name'] ?? '');
$last = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$room_type = trim($_POST['room_type'] ?? '');
$checkin = trim($_POST['check_in'] ?? '');
$checkout = trim($_POST['check_out'] ?? '');
$guests = intval($_POST['guests'] ?? 0);

// The validation
if (!$first || !$last || !$email || !$phone || !$room_type || !$checkin || !$checkout || !$guests) {
    die("<p style='max-width:600px;margin:20px auto;color:#900'>All fields are required. <a href='room_reservation.php'>Go back</a></p>");
}

if ($checkout <= $checkin) {
    die("<p style='max-width:600px;margin:20px auto;color:#900'>Check-out must be after check-in. <a href='room_reservation.php'>Go back</a></p>");
}

// Convert dates and calculate nights
$checkin_dt = new DateTime($checkin);
$checkout_dt = new DateTime($checkout);
$interval = $checkin_dt->diff($checkout_dt);
$nights = (int)$interval->format('%a');
if ($nights <= 0) {
    die("<p style='max-width:600px;margin:20px auto;color:#900'>Invalid dates provided. <a href='room_reservation.php'>Go back</a></p>");
}

// Start transaction
$conn->begin_transaction();

try {
    // Find or create customer by email 
    $stmt = $conn->prepare("SELECT customer_id FROM Customer WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($customer_id);
        $stmt->fetch();
        $stmt->close();
    } else {
        $stmt->close();
        $created_at = date('Y-m-d H:i:s');
        $password_placeholder = ''; // no password created here; registration handles that
        $ins = $conn->prepare("INSERT INTO Customer (first_name, last_name, email, phone_number, password_hash, created_at) VALUES (?, ?, ?, ?, ?, ?)");
        $ins->bind_param("ssssss", $first, $last, $email, $phone, $password_placeholder, $created_at);
        if (!$ins->execute()) throw new Exception("Failed to create customer: " . $ins->error);
        $customer_id = $ins->insert_id;
        $ins->close();
    }

    // Find an available room of requested type
    
    $roomQuery = "
        SELECT r.room_id, rt.price_per_night
        FROM Rooms r
        JOIN Room_type rt ON r.room_type_id = rt.room_type_id
        WHERE rt.type_name = ? AND r.availability_status = 'available'
        LIMIT 1
    ";
    $rq = $conn->prepare($roomQuery);
    $rq->bind_param("s", $room_type);
    $rq->execute();
    $rq->store_result();

    if ($rq->num_rows === 0) {
        $rq->close();
        $conn->rollback();
        die("<p style='max-width:600px;margin:20px auto;color:#900'>No available rooms of that type for the selected dates. Please choose another type or contact us. <a href='room_reservation.php'>Back</a></p>");
    }
    $rq->bind_result($room_id, $price_per_night);
    $rq->fetch();
    $rq->close();

   

    // Calculate total price
    $total_price = $nights * (float)$price_per_night;

    // Insert reservation
    $status = 'Pending';
    $created_at = date('Y-m-d H:i:s');

    $insRes = $conn->prepare("INSERT INTO Reservation (customer_id, room_id, check_in_date, check_out_date, num_guests, total_price, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $insRes->bind_param("iissidss", $customer_id, $room_id, $checkin, $checkout, $guests, $total_price, $status, $created_at);

    if (!$insRes->execute()) {
        throw new Exception("Failed to create reservation: " . $insRes->error);
    }
    $reservation_id = $insRes->insert_id;
    $insRes->close();

    // Mark room as booked
    $upd = $conn->prepare("UPDATE Rooms SET availability_status = 'booked' WHERE room_id = ?");
    $upd->bind_param("i", $room_id);
    if (!$upd->execute()) {
        throw new Exception("Failed to update room status: " . $upd->error);
    }
    $upd->close();

    // Commit transaction
    $conn->commit();

    // Shows success through CSS
    echo "<!doctype html><html><head><meta charset='utf-8'><title>Reservation Confirmed</title><link rel='stylesheet' href='moffatbaycss.css'></head><body>";
    echo "<div class='container' style='max-width:800px;margin:40px auto;'><div class='card'><div class='card-content'>";
    echo "<h2>Reservation Confirmed</h2>";
    echo "<p>Thanks, <strong>" . htmlspecialchars($first) . " " . htmlspecialchars($last) . "</strong>.</p>";
    echo "<p>Your reservation #<strong>" . (int)$reservation_id . "</strong> is pending confirmation.</p>";
    echo "<ul>";
    echo "<li>Room Type: " . htmlspecialchars($room_type) . "</li>";
    echo "<li>Check-in: " . htmlspecialchars($checkin) . "</li>";
    echo "<li>Check-out: " . htmlspecialchars($checkout) . " (" . $nights . " nights)</li>";
    echo "<li>Guests: " . (int)$guests . "</li>";
    echo "<li>Total: $" . number_format($total_price, 2) . "</li>";
    echo "</ul>";
    echo "<p><a class='btn-primary' href='reservation_summary.php'>View Reservations</a></p>";
    echo "</div></div></div></body></html>";

} catch (Exception $e) {
    $conn->rollback();
    // Log the error server-side 
    die("<p style='max-width:600px;margin:20px auto;color:#900'>An error occurred: " . htmlspecialchars($e->getMessage()) . "</p>");
}

// Close connection
$conn->close();
?>
