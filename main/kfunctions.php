<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gate Logs</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="assets/images/schoolgate_kingline_favicon.png">
    <link href="assets/css/main.css?v=1.0" rel="stylesheet">

</head>
<?php
session_start();
$schoollevel=$_SESSION['schoollevel'];
$rolenumber=$_SESSION['rolenumber'];
$schoolid = $_SESSION['schoolid']; // Assuming it's stored in the session
require_once 'connect.php'; // Database connection
date_default_timezone_set('Africa/Kampala');


// Check if the user is logged in
if (!isset($_SESSION['role'])) {
    echo "Unauthorized access! Please log in.";
    header("refresh:3;url=../index.php"); // Redirect to login page
    exit();
}


//echo "<span style'font-size:100px;'>".$schoollevel."</span>";
?>