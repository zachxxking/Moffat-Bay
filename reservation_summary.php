<?php
// reservation_summary.php
session_start();

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

require_once 'db_connect.php';
$conn = db_connect();

/* -----------------------------------------
   Fetch reservations ONLY for logged-in user
------------------------------------------ */

$sql = "
SELECT 
    r.reservation_id,
    c.first_name, c.last_name, c.email, c.phone_number,
    rt.type_name AS room_type,
    r.check_in_date, r.check_out_date,
    r.num_guests, r.total_price, r.status, r.created_at
FROM Reservation r
LEFT JOIN Customer c ON r.customer_id = c.customer_id
LEFT JOIN Rooms rm ON r.room_id = rm.room_id
LEFT JOIN Room_type rt ON rm.room_type_id = rt.room_type_id
WHERE r.customer_id = ?
ORDER BY r.created_at DESC
";

$stmt = $conn->prepare($sql);
$stmt->execute([$customer_id]);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Your Reservation Summary - Moffat Bay</title>
  <link href="https://fonts.googleapis.com/css2?family=Allura&family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="moffatbaycss.css">
  <style>
    .table-wrap { max-width: 1100px; margin: 30px auto; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 8px 10px; border: 1px solid #ddd; text-align: left; font-size: 14px; }
    th { background: #6b2f7f; color: #fff; }
    .no-data { text-align: center; padding: 25px; }
    .small { font-size: 12px; color:#666; }
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

<div class="table-wrap">
    <h2>Your Reservations</h2>
    <p class="small">You have <?php echo count($reservations); ?> reservation(s).</p>

    <?php if (!$reservations): ?>
        <div class="no-data">You have no reservations yet.</div>

    <?php else: ?>
        <table aria-label="Reservations table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Guest</th>
                    <th>Email / Phone</th>
                    <th>Room Type</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Guests</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $row): ?>
                    <tr>
                        <td><?= (int)$row['reservation_id']; ?></td>
                        <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                        <td>
                            <?= htmlspecialchars($row['email']); ?><br>
                            <?= htmlspecialchars($row['phone_number']); ?>
                        </td>
                        <td><?= htmlspecialchars($row['room_type']); ?></td>
                        <td><?= htmlspecialchars($row['check_in_date']); ?></td>
                        <td><?= htmlspecialchars($row['check_out_date']); ?></td>
                        <td><?= (int)$row['num_guests']; ?></td>
                        <td>$<?= number_format((float)$row['total_price'], 2); ?></td>
                        <td><?= htmlspecialchars($row['status']); ?></td>
                        <td><?= htmlspecialchars($row['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
