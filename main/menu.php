<?php
// Ensure session is started
require_once ('kfunctions.php');

// Check if the role is set in the session
if (!isset($_SESSION['role'])) {
    echo "Unauthorized access! Please log in.";
    header("refresh:3;url=../logout.php"); // Redirect to login page
    exit();
}

$role = $_SESSION['role']; // Get the user's role
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Gate</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- Logo and System Name -->
            <a class="navbar-brand" href="#">
                <img src="logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
                School Gate System
            </a>

            <!-- Mobile Menu Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Items -->
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <!-- Universal Items -->
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Dashboard</a>
                    </li>
                    

                    <!-- Role-Based Items -->
                    <?php if ($role == 'tech') { ?>
                
                        <li class="nav-item">
                            <a class="nav-link" href="multi_inputs.php">Multi Inputs</a>
                        </li>

                       
                         <li class="nav-item">
                            <a class="nav-link" href="schools_list.php">Schools list</a>
                        </li>
                        
                
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="logsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Logs
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="logsDropdown">
                                <li><a class="dropdown-item" href="sms.php">SMS</a></li>
                                <li><a class="dropdown-item" href="payments.php">Payments</a></li>
                                <li><a class="dropdown-item" href="income_summary.php">Income Summary</a></li>
                            </ul>
                        </li>
                    <?php } ?>


  <?php if ($role == 'sca') { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="students.php">Add student</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="list_students.php">Student List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="parent list.php">Parent List</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="logsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Logs
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="logsDropdown">
                                <li><a class="dropdown-item" href="sms.php">SMS</a></li>
                                <li><a class="dropdown-item" href="payments.php">Payments</a></li>
                                <li><a class="dropdown-item" href="income_summary.php">Income Summary</a></li>
                            </ul>
                        </li>
                    <?php } ?>


                    <?php if ($role == 'dev') { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="logsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Logs
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="logsDropdown">
                                <li><a class="dropdown-item" href="sms.php">SMS</a></li>
                                <li><a class="dropdown-item" href="payments.php">Payments</a></li>
                                <li><a class="dropdown-item" href="income_summary.php">Income Summary</a></li>
                            </ul>
                        </li>


                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>