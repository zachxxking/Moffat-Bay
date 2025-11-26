<?php
function db_connect() {
    $host = "localhost";
    $dbname = "moffat_bay_lodge";
    $dbuser = "root";
    $dbpass = ""; // Your password here

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn; 
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
?>