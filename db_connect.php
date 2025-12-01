<!-- 
CSD460 Capstone - Red Team
Contributors: Zachariah King, Ryan Monnier, Tabari Harvey, Jacob Achenbach
Instructor: Sue Sampson
Created October-December 2025
-->
<?php
function db_connect() {
    $host = "localhost";
    $dbname = "moffat_bay_lodge";
    $dbuser = "root";
    $dbpass = "root"; // Your password here

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn; 
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
?>