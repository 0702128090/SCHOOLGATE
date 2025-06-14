<?php require_once 'kfunctions.php'; ?>
<body>
    <?php include('menu.php'); ?>
    <div class="container table-container">
        <h2 class="text-center text-primary mb-4">Students</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student Class</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Credits</th>
                    <th>Student Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include the database connection
                require_once 'connect.php';

                // Assuming schoolid is stored in the session after the admin logs in
                $schoolid = $_SESSION['schoolid']; // Make sure this is set appropriately

                try {
                    // Query to retrieve data for a specific school
                    $sql = "SELECT student_id, student_class, student_fname, student_lname, credits, student_image FROM students WHERE schoolid = :schoolid";
                    $stmt = $dbh->prepare($sql);
                    $stmt->bindParam(':schoolid', $schoolid, PDO::PARAM_STR);
                    $stmt->execute();

                    // Initialize a counter for row numbering
                    $counter = 1;

                    // Fetch the first row
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Check if there are rows in the table
                    if ($row) {
                        // Use a do-while loop to display rows
                        do {
                            echo "<tr style='height: 60px;'>"; // Increased row height
                            echo "<td>" . $counter++ . "</td>";
                            echo "<td>" . (!is_null($row['student_class']) ? htmlspecialchars($row['student_class']) : 'N/A') . "</td>";
                            echo "<td>" . (!is_null($row['student_fname']) ? htmlspecialchars($row['student_fname']) : 'N/A') . "</td>";
                            echo "<td>" . (!is_null($row['student_lname']) ? htmlspecialchars($row['student_lname']) : 'N/A') . "</td>";
                            echo "<td>" . (!is_null($row['credits']) ? htmlspecialchars($row['credits']) : 'N/A') . "</td>";
                            
                            // Display student image or fallback image
                            if (!empty($row['student_image']) && file_exists($row['student_image'])) {
                                echo "<td><img src='" . htmlspecialchars($row['student_image']) . "' alt='Student Image' class='student-image'></td>";
                            } else {
                                echo "<td><img src='default-image.png' alt='Default Image' class='student-image'></td>";
                            }

                            // Change button text to "Details" and link to edit_student.php with student_id
                            echo "<td><a href='edit_student.php?student_id=" . htmlspecialchars($row['student_id']) . "' class='btn btn-primary'>Details</a></td>";
                            echo "</tr>";
                        } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
                    } else {
                        // Display a message if no data is available
                        echo "<tr><td colspan='7' class='text-center'>No students found</td></tr>";
                    }
                } catch (PDOException $e) {
                    echo "<tr><td colspan='7' class='text-center'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>