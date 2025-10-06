<?php
$servername = "localhost";
$username = "root";
$password = ""; // ถ้ามีรหัส MySQL ให้ใส่แทนตรงนี้
$dbname = "sensor_data";

// สร้าง connection
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบ connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// สุ่มค่าอุณหภูมิระหว่าง 20 - 40 องศา
$temp = rand(200, 400) / 10.0;
$time = date("Y-m-d H:i:s");

// บันทึกลงฐานข้อมูล
$sql = "INSERT INTO temperature (temperature, timestamp) VALUES ($temp, '$time')";

if ($conn->query($sql) === TRUE) {
  echo "Saved temperature: $temp °C at $time";
} else {
  echo "Error: " . $conn->error;
}

$conn->close();
?>
