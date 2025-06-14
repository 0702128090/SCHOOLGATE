<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Menu styles */
        .menu {
            background-color: #333;
            color: white;
            padding: 15px 0;
            text-align: center;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .menu a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }

        .menu a:hover {
            text-decoration: underline;
        }

        .content {
            padding: 80px 20px;
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
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <?php include('menu.php'); ?>

    <div class="content">
        <div class="table-container">
            <h1>Students List</h1>

            <?php
            include("connect.php");

            // Check if the school ID is provided
            if (isset($_GET['schoolId'])) {
                $schoolid = $_GET['schoolId'];

                try {
                    // Fetch students for the specific school
                    $stmt_fetch = $dbh->prepare("SELECT student_id, student_class, student_fname, student_lname, student_image FROM students WHERE schoolid = :schoolid");
                    $stmt_fetch->bindParam(':schoolid', $schoolid, PDO::PARAM_STR);
                    $stmt_fetch->execute();
                    $students = $stmt_fetch->fetchAll(PDO::FETCH_ASSOC);

                    if ($students): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Class</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($students as $student): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                                    <td><?php echo htmlspecialchars($student['student_class']); ?></td>
                                    <td><?php echo htmlspecialchars($student['student_fname']); ?></td>
                                    <td><?php echo htmlspecialchars($student['student_lname']); ?></td>
                                    <td>
                                        <img src="<?php echo htmlspecialchars($student['student_image']); ?>" alt="Student Image">
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No students found for this school.</p>
                    <?php endif; ?>
                <?php } catch (PDOException $e) {
                    echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
                }
            } else { ?>
                <p>Invalid school ID.</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>