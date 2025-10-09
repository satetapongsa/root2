<?php
include 'db_connect.php';

$temp = rand(20, 35);
$humid = rand(40, 90);
$light = rand(100, 900);
$air = rand(20, 200);

$sql = "INSERT INTO sensor_data (temperature, humidity, light, air_quality, created_at)
        VALUES ($temp, $humid, $light, $air, NOW())";
$conn->query($sql);

$conn->close();
?>
