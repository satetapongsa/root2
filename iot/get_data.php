<?php
include 'db_connect.php';

$sql = "SELECT * FROM sensor_data ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

echo json_encode($data);
$conn->close();
?>
