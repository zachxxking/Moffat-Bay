<!-- room_reservation.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Reserve a Room - Moffat Bay</title>
  <link rel="stylesheet" href="moffatbaycss.css">
</head>
<body>

  <form action="reservation_backend.php" method="POST" class="reservation-form">
    <h2>Room Reservation</h2>

    <input type="text" name="first_name" placeholder="First Name" required>
    <input type="text" name="last_name" placeholder="Last Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="phone" placeholder="Phone" required>

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

    <label>Check-in:</label>
    <input type="date" name="check_in" required>

    <label>Check-out:</label>
    <input type="date" name="check_out" required>

    <label>Guests</label>
    <input type="number" name="guests" min="1" max="10" value="1" required>

    <button type="submit" class="btn-primary">Reserve</button>
  </form>

</body>
</html>
