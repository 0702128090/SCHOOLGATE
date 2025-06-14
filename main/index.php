<?php
require_once ('kfunctions.php');
//require_once ('menu.php');
//session_start();



// Include the appropriate file based on the role
$role = $_SESSION['role'];

if ($role == 'sca' || $role == 'par' || $role == 'tech' || $role == 'dev') {
    include 'gate_logs.php';
} elseif ($role == 'ask') {
    include 'ticker.php';
} else {
    echo "Invalid role detected!";
}
?>