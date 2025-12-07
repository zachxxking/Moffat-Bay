<?php
// 
// CSD460 Capstone - Red Team
// Contributors: Zachariah King, Ryan Monnier, Tabari Harvey, Jacob Achenbach
// Instructor: Sue Sampson
// Created October–December 2025
//

require_once "db_connect.php";

function attractions_backend() {
    try {
        
        $conn = db_connect();  

        $sql = "SELECT attraction_id, attraction_name, description, distance_from_lodge, photo_url
                FROM Attractions
                ORDER BY attraction_name ASC";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

       
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        
        echo "<p style='color:red; font-weight:bold;'>Database Error: " . 
              htmlspecialchars($e->getMessage()) . "</p>";
        return [];
    }
}
?>
