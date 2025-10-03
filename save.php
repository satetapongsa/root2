<?php
include 'db.php';

$sensor = $_POST['sensor'];
$value  = $_POST['value'];

$sql = "INSERT INTO sensor_data (sensor, value) VALUES ('$sensor', '$value')";

if ($conn->query($sql) === TRUE) {
    header("Location: dashboard.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
