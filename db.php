<?php
$servername = "localhost";
$username = "root"; // ถ้าใช้ phpMyAdmin ปกติจะเป็น root
$password = ""; // ถ้ามีรหัสก็ใส่ เช่น "1234"
$dbname = "iot_dashboard";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
