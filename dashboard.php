<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>IoT Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="card shadow p-4">
    <h2 class="text-center">📊 IoT Dashboard</h2>
    <canvas id="lineChart" height="100"></canvas>
    <h4 class="mt-4">Latest Value:</h4>
    <?php
      $result = $conn->query("SELECT * FROM sensor_data ORDER BY timestamp DESC LIMIT 1");
      $row = $result->fetch_assoc();
      echo "<p><b>Sensor:</b> " . $row['sensor'] . " | <b>Value:</b> " . $row['value'] . " | <b>Time:</b> " . $row['timestamp'] . "</p>";
    ?>
    <div class="text-center mt-3">
      <a href="index.php" class="btn btn-secondary">Back to Input</a>
    </div>
  </div>
</div>

<?php
$data = $conn->query("SELECT value, timestamp FROM sensor_data ORDER BY timestamp DESC LIMIT 10");
$timestamps = [];
$values = [];
while($r = $data->fetch_assoc()){
    $timestamps[] = $r['timestamp'];
    $values[] = $r['value'];
}
?>

<script>
const ctx = document.getElementById('lineChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode(array_reverse($timestamps)); ?>,
        datasets: [{
            label: 'Sensor Values',
            data: <?php echo json_encode(array_reverse($values)); ?>,
            borderColor: 'rgba(75, 192, 192, 1)',
            fill: false,
            tension: 0.1
        }]
    }
});
</script>
</body>
</html>
