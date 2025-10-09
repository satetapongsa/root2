<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>IoT Dashboard (Interactive Mock)</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f5f7fa;
      margin: 0;
      padding: 20px;
      color: #333;
    }
    h1 {
      text-align: center;
      margin-bottom: 30px;
    }
    .controls {
      display: flex;
      justify-content: center;
      margin-bottom: 30px;
      gap: 15px;
    }
    button {
      padding: 10px 20px;
      font-size: 16px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      color: white;
    }
    #startBtn { background: #28a745; }
    #stopBtn { background: #dc3545; }
    #latestData {
      text-align: center;
      font-size: 18px;
      margin-bottom: 20px;
    }
    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
      gap: 20px;
    }
    .card {
      background: #fff;
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    canvas {
      width: 100%;
      height: 300px;
    }
  </style>
</head>
<body>

  <h1>🌡 IoT Dashboard (Mock Sensor Data)</h1>

  <div class="controls">
    <button id="startBtn">▶ Start Simulation</button>
    <button id="stopBtn">⏹ Stop Simulation</button>
  </div>

  <div id="latestData">
    <strong>Temperature:</strong> <span id="tempVal">-</span> °C |
    <strong>Humidity:</strong> <span id="humidVal">-</span> % |
    <strong>Light:</strong> <span id="lightVal">-</span> lux |
    <strong>Air Quality:</strong> <span id="airVal">-</span> AQI
  </div>

  <div class="grid">
    <div class="card"><canvas id="tempChart"></canvas></div>
    <div class="card"><canvas id="humidChart"></canvas></div>
    <div class="card"><canvas id="lightChart"></canvas></div>
    <div class="card"><canvas id="airChart"></canvas></div>
  </div>

  <script>
    let simInterval = null;

    // === สร้างกราฟแต่ละตัว ===
    const charts = {
      temperature: new Chart(document.getElementById('tempChart'), {
        type: 'line',
        data: { labels: [], datasets: [{ label: 'Temperature (°C)', data: [], borderColor: 'red', borderWidth: 2 }] },
        options: { scales: { y: { beginAtZero: false } } }
      }),
      humidity: new Chart(document.getElementById('humidChart'), {
        type: 'line',
        data: { labels: [], datasets: [{ label: 'Humidity (%)', data: [], borderColor: 'blue', borderWidth: 2 }] },
        options: { scales: { y: { beginAtZero: true } } }
      }),
      light: new Chart(document.getElementById('lightChart'), {
        type: 'line',
        data: { labels: [], datasets: [{ label: 'Light Intensity', data: [], borderColor: 'orange', borderWidth: 2 }] },
        options: { scales: { y: { beginAtZero: true } } }
      }),
      air_quality: new Chart(document.getElementById('airChart'), {
        type: 'line',
        data: { labels: [], datasets: [{ label: 'Air Quality (AQI)', data: [], borderColor: 'green', borderWidth: 2 }] },
        options: { scales: { y: { beginAtZero: true } } }
      })
    };

    // === ฟังก์ชันอัปเดตข้อมูล ===
    async function updateData() {
      try {
        const res = await fetch('get_data.php');
        const data = await res.json();
        const now = new Date().toLocaleTimeString();

        document.getElementById('tempVal').innerText = data.temperature;
        document.getElementById('humidVal').innerText = data.humidity;
        document.getElementById('lightVal').innerText = data.light;
        document.getElementById('airVal').innerText = data.air_quality;

        for (const key in charts) {
          const chart = charts[key];
          chart.data.labels.push(now);
          chart.data.datasets[0].data.push(data[key]);
          if (chart.data.labels.length > 10) {
            chart.data.labels.shift();
            chart.data.datasets[0].data.shift();
          }
          chart.update();
        }
      } catch (err) {
        console.error("Error:", err);
      }
    }

    // === ฟังก์ชันเริ่มจำลอง ===
    async function insertMock() {
      await fetch('insert_mock.php');
    }

    document.getElementById('startBtn').addEventListener('click', () => {
      if (!simInterval) {
        insertMock(); // สร้างข้อมูลก่อนรอบแรก
        simInterval = setInterval(() => {
          insertMock();
          updateData();
        }, 3000);
      }
    });

    document.getElementById('stopBtn').addEventListener('click', () => {
      clearInterval(simInterval);
      simInterval = null;
    });

    // โหลดข้อมูลเริ่มต้น
    updateData();
  </script>

</body>
</html>
