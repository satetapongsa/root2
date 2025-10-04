<?php
$host = "localhost";
$user = "root";   // default XAMPP
$pass = "";       // default ว่าง
$db   = "iotdb";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
