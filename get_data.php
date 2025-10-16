<?php
include 'db.php';

$sql = "SELECT * FROM sensor_data ORDER BY created_at DESC LIMIT 20";
$result = $conn->query($sql);

$data = [];
while($row = $result->fetch_assoc()) {
  $data[] = $row;
}
echo json_encode(array_reverse($data)); // เรียงเวลาเก่าก่อนไปใหม่
$conn->close();
?>
