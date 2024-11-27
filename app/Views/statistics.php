<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('styles/global.css') ?>">
    <link rel="stylesheet" href="<?= base_url('styles/root.css') ?>">
    <link rel="stylesheet" href="<?= base_url('styles/main.css') ?>">
    <link rel="stylesheet" href="<?= base_url('styles/charts.css') ?>">

    <title>Statistics</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="Mode">
    <?php $navbar->render('statistics'); ?>

    <div class="container mt-4">
    <h1>Case Metrics</h1>
    <p></p>Initial Findings Based on Metric Analysis</p>

    <div class="form-group">
        <label for="timeRangeDropdown">Time Range:</label>
        <select id="timeRangeDropdown" class="form-select">
            <option value="3 Days" selected>Last 3 Days</option>
            <option value="7 Days">Last 7 Days</option>
            <option value="1 Month">Last 1 Month</option>
            <option value="Older">Older</option>
        </select>
    </div>

    <div class="charts-container d-flex">
   
        <div class="chart-item">
            <h2>Total Cases</h2>
            <canvas id="total-cases-chart"></canvas>
        </div>

      
        <div class="chart-item">
            <h2>High Priority Cases</h2>
            <canvas id="high-cases-chart"></canvas>
        </div>
    </div>


</div>
    <div class="side-panel">
        <button class="close-btn" id="closePanelBtn">✖</button>
        <div id="accountSettingsSection" class="fade-section"></div>
    </div>
    <script src="<?= base_url('scripts/charts.js') ?>"></script>
    <script src="<?= base_url('scripts/sidepanel.js') ?>"></script>
    <script src="<?= base_url('scripts/AccountSettings.js') ?>"></script>
</body>
</html>
