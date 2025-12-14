<!-- 
CSD460 Capstone - Red Team
Contributors: Zachariah King, Ryan Monnier, Tabari Harvey, Jacob Achenbach
Instructor: Sue Sampson
Created October-December 2025
-->

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
   Fetch ONLY upcoming reservations for logged-in user
------------------------------------------ */
$today = date('Y-m-d');

$sqlUpcoming = "
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
WHERE r.customer_id = :customer_id
  AND r.check_out_date >= :today
ORDER BY r.check_in_date ASC
";

$stmtUpcoming = $conn->prepare($sqlUpcoming);
$stmtUpcoming->execute([
    ':customer_id' => $customer_id,
    ':today' => $today
]);
$upcomingReservations = $stmtUpcoming->fetchAll(PDO::FETCH_ASSOC);

/* -----------------------------------------
   Handle search for historic or future reservations
------------------------------------------ */
$searchResults = [];
if (!empty($_GET['search_reservation_id']) || !empty($_GET['search_email'])) {
    $searchId = trim($_GET['search_reservation_id'] ?? '');
    $searchEmail = trim($_GET['search_email'] ?? '');

    $sqlSearch = "
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
        WHERE r.customer_id = :customer_id
    ";

    $params = [':customer_id' => $customer_id];

    if ($searchId !== '') {
        $sqlSearch .= " AND r.reservation_id = :res_id";
        $params[':res_id'] = $searchId;
    } elseif ($searchEmail !== '') {
        $sqlSearch .= " AND c.email = :email";
        $params[':email'] = $searchEmail;
    }

    $sqlSearch .= " ORDER BY r.check_in_date DESC";

    $stmtSearch = $conn->prepare($sqlSearch);
    $stmtSearch->execute($params);
    $searchResults = $stmtSearch->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Reservation Summary - Moffat Bay</title>
  <link href="https://fonts.googleapis.com/css2?family=Allura&family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="moffatbaycss.css">
  <style>
    .table-wrap { max-width: 1100px; margin: 30px auto; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 8px 10px; border: 1px solid #ddd; text-align: left; font-size: 14px; }
    th { background: #6b2f7f; color: #fff; }
    .no-data { text-align: center; padding: 25px; }
    .small { font-size: 12px; color:#666; }
    form input, form button { padding: 8px; font-size: 14px; }
    form { display:flex; gap:10px; flex-wrap:wrap; margin-bottom: 20px; }
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

<!-- UPCOMING RESERVATIONS -->
<div class="table-wrap">
    <h2>Upcoming Reservations</h2>
    <p class="small">Below are your upcoming reservations. For historic reservations, use the search feature below.</p>
    <p class="small">You have <?php echo count($upcomingReservations); ?> upcoming reservation(s).</p>

    <?php if (!$upcomingReservations): ?>
        <div class="no-data">You have no upcoming reservations.</div>
    <?php else: ?>
        <table aria-label="Upcoming Reservations table">
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
                <?php foreach ($upcomingReservations as $row): ?>
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

<!-- HISTORIC / SEARCH RESERVATIONS -->
<div class="table-wrap" style="margin-top: 50px;">
    <h2>Search Past or Upcoming Reservations</h2>
    <p class="small">Enter a reservation ID or email address to look up a reservation.</p>

    <form method="GET">
        <input type="text" name="search_reservation_id" placeholder="Reservation ID" style="flex:1; min-width:150px;">
        <input type="email" name="search_email" placeholder="Email address" style="flex:2; min-width:200px;">
        <button type="submit" class="btn-primary">Search</button>
    </form>

    <?php if (!empty($searchResults)): ?>
        <p class="small">Found <?= count($searchResults); ?> reservation(s).</p>
        <table aria-label="Search Reservations table">
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
                <?php foreach ($searchResults as $row): ?>
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
    <?php elseif (isset($_GET['search_reservation_id']) || isset($_GET['search_email'])): ?>
        <div class="no-data">No reservations found for that search.</div>
    <?php endif; ?>
</div>

<!-- FOOTER -->
<footer>
    <p>&copy; <?php echo date('Y'); ?> Moffat Bay Lodge. All rights reserved.</p>
</footer>

</body>
</html>
