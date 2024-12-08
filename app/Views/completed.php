<!-- app/Views/completed.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed Cases</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php 
    // Include the navbar component and pass 'complete' as the active page
    $navbar = new \App\Libraries\navbar();
    $navbar->render('complete'); 
    ?>

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
                <?= $caseRows ?>
            </tbody>
        </table>
    </div>
</body>
</html>
