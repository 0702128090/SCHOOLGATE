<?php
date_default_timezone_set('Africa/Kampala');
session_start();
require_once 'connect.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'] ?? null;
    $action = $_POST['action'] ?? null; // Get the action type (arrived/left)
    $our_user = $_SESSION['rolenumber']; // Logged-in user's rolenumber

    // Fetch student details
    $stmt_student = $dbh->prepare("SELECT schoolid, student_fname FROM students WHERE student_id = :student_id");
    $stmt_student->bindParam(':student_id', $student_id);
    $stmt_student->execute();
    $student = $stmt_student->fetch(PDO::FETCH_ASSOC);

    if ($student) {
        $schoolid = $student['schoolid'];
        $student_fname = $student['student_fname'];
        $our_date = date('Y-m-d'); // Current server date
        $our_time = date('H:i:s'); // Current server time

        // Insert attendance record
        $stmt_attendance = $dbh->prepare("INSERT INTO attendance (schoolid, student_id, student_fname, our_date, our_time, our_user, action) 
                                          VALUES (:schoolid, :student_id, :student_fname, :our_date, :our_time, :our_user, :action)");
        $stmt_attendance->bindParam(':schoolid', $schoolid);
        $stmt_attendance->bindParam(':student_id', $student_id);
        $stmt_attendance->bindParam(':student_fname', $student_fname);
        $stmt_attendance->bindParam(':our_date', $our_date);
        $stmt_attendance->bindParam(':our_time', $our_time);
        $stmt_attendance->bindParam(':our_user', $our_user);
        $stmt_attendance->bindParam(':action', $action);

        if ($stmt_attendance->execute()) {
            echo 'Attendance marked successfully for ' . htmlspecialchars($student_fname) . ' (' . htmlspecialchars($action) . ').';
            include ('smslauncher.php');
        } else {
            echo 'Failed to mark attendance. Please try again.';
        }
    } else {
        echo 'Student not found.';
    }
} else {
    echo 'Invalid request method.';
}
?>