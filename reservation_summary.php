<?php
// reservation_summary.php
session_start();


require_once 'db_connect.php';
$conn = db_connect();

$sql = "
SELECT r.reservation_id, c.first_name, c.last_name, c.email, c.phone_number,
       rt.type_name AS room_type, r.check_in_date, r.check_out_date, r.num_guests, r.total_price, r.status, r.created_at
FROM Reservation r
LEFT JOIN Customer c ON r.customer_id = c.customer_id
LEFT JOIN Rooms rm ON r.room_id = rm.room_id
LEFT JOIN Room_type rt ON rm.room_type_id = rt.room_type_id
ORDER BY r.created_at DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Reservation Summary - Moffat Bay</title>
  <link rel="stylesheet" href="moffatbaycss.css">
  <style>
    .table-wrap { max-width: 1100px; margin: 30px auto; }
    table {width: 100%; border-collapse: collapse;}
    th, td {padding: 8px 10px; border: 1px solid #ddd; text-align: left; font-size: 14px;}
    th {background: #6b2f7f; color: #fff;}
    .no-data {text-align: center; padding: 25px;}
    .small {font-size: 12px; color:#666;}
  </style>
</head>
<body>
  <div class="table-wrap">
    <h2>Reservation Summary</h2>
    <p class="small">Showing all reservations. Total: <?php echo ($result ? $result->num_rows : 0); ?></p>

    <?php if (!$result): ?>
      <div class="no-data">Database query failed: <?php echo htmlspecialchars($conn->error); ?></div>
    <?php elseif ($result->num_rows === 0): ?>
      <div class="no-data">No reservations found.</div>
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
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo (int)$row['reservation_id']; ?></td>
              <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
              <td><?php echo htmlspecialchars($row['email']) . '<br>' . htmlspecialchars($row['phone_number']); ?></td>
              <td><?php echo htmlspecialchars($row['room_type']); ?></td>
              <td><?php echo htmlspecialchars($row['check_in_date']); ?></td>
              <td><?php echo htmlspecialchars($row['check_out_date']); ?></td>
              <td><?php echo (int)$row['num_guests']; ?></td>
              <td>$<?php echo number_format((float)$row['total_price'], 2); ?></td>
              <td><?php echo htmlspecialchars($row['status']); ?></td>
              <td><?php echo htmlspecialchars($row['created_at']); ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php endif; ?>

  </div>

<?php $conn->close(); ?>
</body>
</html>
