<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>IoT Sensor Input</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="card shadow p-4">
    <h2 class="text-center">📡 IoT Sensor Data Input</h2>
    <form action="save.php" method="POST" class="mt-4">
      <div class="mb-3">
        <label for="sensor" class="form-label">Sensor Type</label>
        <select class="form-control" id="sensor" name="sensor">
          <option value="temperature">Temperature</option>
          <option value="humidity">Humidity</option>
          <option value="motion">Motion</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="value" class="form-label">Value</label>
        <input type="number" step="0.01" class="form-control" id="value" name="value" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Save Data</button>
    </form>
    <div class="text-center mt-3">
      <a href="dashboard.php" class="btn btn-success">View Dashboard</a>
    </div>
  </div>
</div>
</body>
</html>
