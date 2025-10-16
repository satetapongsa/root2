<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>IoT Sensor Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { font-family: Arial; background: #f5f5f5; text-align: center; }
    h1 { color: #222; }
    .btn {
      background: #007bff; color: white; padding: 10px 20px;
      border: none; border-radius: 5px; cursor: pointer;
    }
    .btn:hover { background: #0056b3; }
    canvas { max-width: 800px; margin: 20px auto; display: block; }
  </style>
</head>
<body>
  <h1>🌡️ IoT Sensor Dashboard</h1>
  <button class="btn" onclick="simulateData()">จำลองค่า Sensor</button>
  <p id="status"></p>

  <canvas id="sensorChart"></canvas>

  <script>
  async function simulateData() {
    const res = await fetch('insert_data.php');
    const text = await res.text();
    document.getElementById('status').innerText = text;
    updateChart();
  }

  async function updateChart() {
    const res = await fetch('get_data.php');
    const data = await res.json();

    const labels = data.map(row => row.created_at);
    const temp = data.map(row => row.temperature);
    const hum = data.map(row => row.humidity);
    const pres = data.map(row => row.pressure);

    new Chart(document.getElementById('sensorChart'), {
      type: 'line',
      data: {
        labels: labels,
        datasets: [
          { label: 'Temperature (°C)', data: temp, borderColor: 'red', fill: false },
          { label: 'Humidity (%)', data: hum, borderColor: 'blue', fill: false },
          { label: 'Pressure (hPa)', data: pres, borderColor: 'green', fill: false }
        ]
      },
      options: { responsive: true }
    });
  }

  updateChart();
  setInterval(updateChart, 5000); // อัปเดตทุก 5 วินาที
  </script>
</body>
</html>
