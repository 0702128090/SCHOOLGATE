<?php
// Include database connection and functions
require_once 'connect.php';
require_once 'kfunctions.php'; // This file should handle session management

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if school ID is set in session
if (!isset($_SESSION['schoolid'])) {
    die("No school ID found in session.");
}

$schoolid = $_SESSION['schoolid']; // Retrieve school ID from session

// Fetch recipients for the specific school
$stmt = $dbh->prepare("SELECT name, relationship, phone, email FROM recipients WHERE schoolid = :schoolid");
$stmt->bindParam(':schoolid', $schoolid, PDO::PARAM_STR);
$stmt->execute();
$recipients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parents List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .table-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <?php include('menu.php'); ?>
    <div class="table-container">
        <h1>Parents List</h1>

        <?php if ($recipients): ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Relationship</th>
                        <th>Phone</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recipients as $recipient): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($recipient['name']); ?></td>
                        <td><?php echo htmlspecialchars($recipient['relationship']); ?></td>
                        <td><?php echo htmlspecialchars($recipient['phone']); ?></td>
                        <td><?php echo htmlspecialchars($recipient['email']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No recipients found for this school.</p>
        <?php endif; ?>
    </div>
</body>
</html>