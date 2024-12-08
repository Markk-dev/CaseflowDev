<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed Cases</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Completed Cases</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Case Type</th>
                    <th>Description</th>
                    <th>Priority</th>
                    <th>Completed At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($completedCases as $case): ?>
                    <tr>
                        <td><?= $case['case_type'] ?></td>
                        <td><?= $case['description'] ?></td>
                        <td><?= $case['case_priority'] ?></td>
                        <td><?= $case['completed_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html> 