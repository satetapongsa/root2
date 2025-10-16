<?php
include 'db.php';

// สุ่มค่าจำลอง sensor
$temp = rand(20, 40) + (rand(0, 99) / 100);
$humidity = rand(40, 90) + (rand(0, 99) / 100);
$pressure = rand(950, 1050) + (rand(0, 99) / 100);

// บันทึกค่า
$sql = "INSERT INTO sensor_data (temperature, humidity, pressure)
        VALUES ('$temp', '$humidity', '$pressure')";

if ($conn->query($sql) === TRUE) {
  echo "จำลองค่าจาก Sensor แล้วบันทึกเรียบร้อย ✅";
} else {
  echo "Error: " . $conn->error;
}
$conn->close();
?>
