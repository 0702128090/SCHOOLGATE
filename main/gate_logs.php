<?php
require_once 'connect.php';

// Fetch attendance data
$stmt = $dbh->prepare("SELECT * FROM attendance WHERE schoolid = :schoolid ORDER BY our_date DESC, our_time DESC");
$stmt->bindParam(':schoolid', $_SESSION['schoolid']); // School ID from the session
$stmt->execute();
$attendance_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<body>
    <?php require_once ('menu.php')?>
    <div class="container mt-5">
        <h1 class="mb-4">Attendance Logs</h1>
        <p><strong>Date:</strong> <?php echo date('Y-m-d'); ?> | <strong>Time:</strong> <?php echo date('H:i:s'); ?></p>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>School ID</th>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Checked By</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($attendance_data)) { ?>
                    <?php foreach ($attendance_data as $row) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['schoolid']); ?></td>
                            <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['student_fname']); ?></td>
                            <td><?php echo htmlspecialchars($row['our_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['our_time']); ?></td>
                            <td><?php echo htmlspecialchars($row['our_user']); ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="6" class="text-center">No attendance records found.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>