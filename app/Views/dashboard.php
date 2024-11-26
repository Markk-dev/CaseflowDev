<?php
use App\Libraries\DataTableComponent;

$dataTableComponent = new DataTableComponent();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('styles/main.css') ?>">
    <link rel="stylesheet" href="<?= base_url('styles/Dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('styles/root.css') ?>">


    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body class="Mode">
    <div class="navbar">
        <p class="logo"><span style="font-weight:290;">Case</span><span style="font-weight:bold;">Flow</span></p> 
        <div class="navHeader">
            <p>Lorem</p>
            <p>Lorem</p>
            <p>Lorem</p>
            <button class="sidebar-toggle" id="sidebarToggle" style="position: fixed; top: 20px; right: 20px;">☰</button>
        </div>
    </div>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mt-5">
            <h1>
                <span style="font-weight: 290;">Welcome,</span> 
                <span id="userName" style="font-weight: 650;">
                    <?= session()->get('fname') ? esc(session()->get('fname')) : 'User'; ?>
                </span> 
            </h1>

            <div class="addbtn">
                <span class="material-symbols-outlined" style="font-size: 2.5rem;color: var(--blue);">add</span>
                <a href="<?= base_url('cases/create') ?>" class="addCaseBtn">Add Case</a>
            </div>  

        </div>
        <p class="subHeader">It’s a pleasure to have you back on the team.</p>

        <div class="Cases" style="margin-top: 3rem;">
            <div class="row my-4">

                <div class="col-md-4">
                    <div class="cardBody1">
                        <div class="cardBodyHolder" style="padding: .5rem;">
                            <span class="material-symbols-outlined" style="font-size: 3.4rem;color: var(--blue);">cases</span>
                            <h1 style="font-weight: 650; color: var(--blue); font-size: 3rem;"><?= esc($totalCases) ?></h1>
                        </div>
                        <p class="cardTextBlue">Total number of cases</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="cardBody2">
                        <div class="cardBodyHolder" style="padding: .5rem;">
                            <span class="material-symbols-outlined" style="font-size: 3.4rem;color: var(--red);">warning</span>
                            <h1 style="font-weight: 650; color: var(--red); font-size: 3rem;"><?= esc($highPriorityCases) ?></h1>
                        </div>
                        <p class="cardTextRed">Total number of high-priority cases</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="cardBody3">
                        <div class="cardBodyHolder" style="padding: .5rem;">
                            <span class="material-symbols-outlined" style="font-size: 3.4rem;color: var(--green);">task</span>
                            <h1 style="font-weight: 650; color: var(--green); font-size: 3rem;"><?= esc($completedCases) ?></h1>
                        </div>
                        <p class="cardTextGreen">Total number of completed cases</p>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="SearchFieldContainer">
            <input type="text" id="searchField" class="form-control" placeholder="Search Case" />

            <div class="SearchFieldSelect">
                <select id="filterPriority" class="form-control" placeholder="Placeholder">
                <option value="">Place Holder</option>
                <option value="High">Place Holder</option>
                <option value="Medium">Place Holder</option>
                <option value="Low">Place Holder</option>
                </select>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Case Type</th>
                        <th>Description</th>
                        <th style="padding-left: 30px;">Priority</th>
                        <th style="padding-left: 1px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?= $dataTableComponent->generateTableRows($cases) ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="side-panel">
    <button class="close-btn" id="closePanelBtn">✖</button>
        <div id="accountSettingsSection" class="fade-section">
      
        </div>
    </div>

    

    <script src="<?= base_url('scripts/sidepanel.js') ?>"></script> 
    <script src="<?= base_url('scripts/AccountSettings.js') ?>"></script>
    <script src="<?= base_url('scripts/backDrop.js') ?>"></script>
</body>
</html>
