<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('./styles/main.css') ?>"> <!-- Link to your main CSS -->
    <link rel="stylesheet" href="styles/sidepanel.css"> <!-- Link to the side panel CSS -->
    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body class="light-mode">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mt-4">
            <h2>Welcome, <span id="userName">User</span></h2>
            <a href="<?= base_url('cases/create') ?>" class="btn btn-primary">Add Case</a>
        </div>

        <!-- Statistics Section -->
        <div class="row my-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h2><?= esc($totalCases) ?></h2>
                        <p>Total number of cases</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h2><?= esc($highPriorityCases) ?></h2>
                        <p>Total number of high-priority cases</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h2><?= esc($completedCases) ?></h2>
                        <p>Total number of completed cases</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cases Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Case Type</th>
                    <th>Description</th>
                    <th>Priority</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($cases)) : ?>
                    <?php foreach ($cases as $case): ?>
                        <tr>
                            <td><?= esc($case['id']) ?></td>
                            <td><?= esc($case['case_type']) ?></td>
                            <td><?= esc($case['description']) ?></td>
                            <td><?= esc($case['case_priority']) ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="editCase(<?= esc($case['id']) ?>)">Edit</button>
                                <button class="btn btn-sm btn-success" onclick="completeCase(<?= esc($case['id']) ?>)">Complete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center">No cases found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Side Panel -->
    <div class="side-panel">
        <button class="close-btn" id="closePanelBtn">✖</button>
        <ul>
            <li id="settingsTab">Settings</li>
            <li id="accountSettingsTab">Account Settings</li>
        </ul>
    </div>

    <!-- Settings Section -->
    <div class="container mt-5">

        <div id="accountSettingsSection" class="fade-section">
        </div>
    </div>

    <!-- Button to Toggle Side Panel -->
    <button class="btn btn-secondary" id="togglePanelBtn" style="position: fixed; top: 20px; right: 20px;">☰</button>

    <!-- Scripts -->
    <script src="scripts/sidepanel.js"></script> <!-- Link to your sidepanel.js -->
    <script src="scripts/AccountSettings.js"></script> <!-- Link to your AccountSettings.js -->
</body>
</html>
