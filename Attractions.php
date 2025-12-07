<?php
require_once "attractions_backend.php";
$attractions = attractions_backend();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Moffat Bay Lodge - Attractions</title>

    <!-- google font -->
    <link href="https://fonts.googleapis.com/css2?family=Allura&family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- moffatbaycss -->
    <link rel="stylesheet" href="moffatbaycss.css">
</head>

<body>

<!-- 
CSD460 Capstone - Red Team
Contributors: Zachariah King, Ryan Monnier, Tabari Harvey, Jacob Achenbach
Instructor: Sue Sampson
Created October-December 2025
-->

<header>
    <nav>
        <a href="index.php" class="lodge-logo">Moffat Bay Lodge</a>
        <ul>
            <li><a href="about.php">About</a></li>
            <li><a href="attractions.php">Attractions</a></li>
            <li><a href="room_reservation.php">Lodging</a></li>
        </ul>
        <div style="display:flex; gap:10px;">
            <a href="login.php"><button class="btn-primary">Login</button></a>
            <a href="register.php"><button class="btn-primary">Register</button></a>
        </div>
    </nav>
</header>

<div class="container">
    <h2>Nearby Attractions</h2>
    <p>Explore the beautiful scenery and landmarks around Moffat Bay.</p>

    <div class="columns-3">

        <?php
        // Need to change database names to match these file names
        $imageMap = [
            "lake.jpg"    => "lake_windermere.jpg",
            "mountain.jpg" => "mount-rainier.jpg",
            "house.jpg"    => "vista_house.jpg"
        ];

        foreach ($attractions as $row):
            $file = $imageMap[$row['photo_url']] ?? $row['photo_url'];
        ?>

        <div class="card">
            <img src="images/<?php echo $file; ?>" 
                 alt="<?php echo htmlspecialchars($row['attraction_name']); ?>">

            <div class="card-content">
                <h3><?php echo htmlspecialchars($row['attraction_name']); ?></h3>

                <p><?php echo htmlspecialchars($row['description']); ?></p>

                <p><strong>Distance:</strong> 
                    <?php echo htmlspecialchars($row['distance_from_lodge']); ?>
                </p>
            </div>
        </div>

        <?php endforeach; ?>

    </div>
</div>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Moffat Bay Lodge. All Rights Reserved.</p>
</footer>

</body>
</html>
