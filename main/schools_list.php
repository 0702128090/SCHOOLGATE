<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School List</title>
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

        button {
            padding: 6px 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        /* Form styles */
        .form-container {
            display: none; /* Hidden by default */
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            width: 100%;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
    <script>
        function toggleForm() {
            var form = document.getElementById('schoolFormContainer');
            form.style.display = form.style.display === 'block' ? 'none' : 'block';
        }
    </script>
</head>
<body>

<?php
include('menu.php');
?>
<div class="content">
    <button onclick="toggleForm()" style="margin-bottom: 20px;">Add School</button>

    <div class="form-container" id="schoolFormContainer">
        <h1>School Information</h1>
        <form id="schoolForm" method="POST">
            <div class="form-group">
                <label for="school">School:</label>
                <select id="school" name="school" required>
                    <option value="" disabled selected>Select Option</option>
                    <option value="Primary School">Primary School</option>
                    <option value="Secondary School">Secondary School</option>
                </select>
            </div>
            <div class="form-group">
                <label for="schoolName">School Name:</label>
                <input type="text" id="schoolName" name="schoolName" required>
            </div>
            <button type="submit" name="submit">Submit</button>
        </form>
    </div>

    <div class="table-container">
        <h1>School List</h1>

        <?php
        include("connect.php");

        // Fetch all columns from the scrap table
        $stmt_fetch = $dbh->query("SELECT * FROM scrap");
        $rows = $stmt_fetch->fetchAll(PDO::FETCH_ASSOC);

        if ($rows): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>School ID</th>
                    <th>School Type</th>
                    <th>School Name</th>
                    <th>No. of Students</th>
                    <th>Add User</th>
                    <th>Students</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $index => $row):
                    $item2 = $row['item2'];
                    $stmt_students = $dbh->prepare("SELECT COUNT(*) AS student_count FROM students WHERE schoolid = :schoolId");
                    $stmt_students->bindParam(':schoolId', $item2, PDO::PARAM_STR);
                    $stmt_students->execute();
                    $student_count = $stmt_students->fetchColumn();
                ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($item2); ?></td>
                    <td><?php echo htmlspecialchars($row['type']); ?></td> <!-- Displays the full School Type -->
                    <td><?php echo htmlspecialchars($row['item']); ?></td>
                    <td><?php echo $student_count; ?></td>
                    <td>
                        <a href="users.php?schoolId=<?php echo htmlspecialchars($item2); ?>">
                            <button>Add User</button>
                        </a>
                    </td>
                    <td>
                        <a href="students_list.php?schoolId=<?php echo htmlspecialchars($item2); ?>">
                            <button>View Students</button>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>No schools found.</p>
        <?php endif; ?>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    // Retrieve form data
    $school = $_POST['school']; // This will now be "Primary School" or "Secondary School"
    $schoolName = $_POST['schoolName'];

    // Generate the school ID based on the selected type
    try {
        // Determine the correct prefix based on school type
        $prefix = ($school === "Primary School") ? "PR" : "SC";

        // Get the last ID for the specific school type
        $stmt_last_id = $dbh->prepare("SELECT MAX(CAST(SUBSTRING(item2, 3) AS UNSIGNED)) AS last_id FROM scrap WHERE item2 LIKE :prefix");
        $stmt_last_id->bindValue(':prefix', $prefix . '%', PDO::PARAM_STR);
        $stmt_last_id->execute();
        $last_id = $stmt_last_id->fetch(PDO::FETCH_ASSOC)['last_id'];

        // Create new schoolID (e.g., PR001, SC001)
        $new_school_id = $prefix . str_pad(($last_id + 1), 3, '0', STR_PAD_LEFT);

        // Prepare SQL statement to insert data into the scrap table
        $sql = "INSERT INTO scrap (type, item, item2) VALUES (:school, :schoolName, :item2)";
        $stmt = $dbh->prepare($sql);

        // Bind parameters to the prepared statement
        $stmt->bindParam(':school', $school, PDO::PARAM_STR); // This will now be the full name
        $stmt->bindParam(':schoolName', $schoolName, PDO::PARAM_STR);
        $stmt->bindParam(':item2', $new_school_id, PDO::PARAM_STR);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<p style='text-align: center; color: green;'>School data submitted successfully!</p>";
        } else {
            echo "<p style='text-align: center; color: red;'>Failed to submit school data.</p>";
        }
    } catch (PDOException $e) {
        // Handle any errors
        echo "<p style='text-align: center; color: red;'>Error: " . $e->getMessage() . "</p>";
    }
}
?>