<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Background color */
        body {
            background-color: #f0f8ff; /* Alice blue */
            font-family: 'Arial', sans-serif;
        }

        /* Form container styles */
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-left: 6px solid #007bff;
        }

        /* Form header */
        .form-heading {
            text-align: center;
            color: #007bff;
            font-weight: bold;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Field labels */
        .form-label {
            color: #0056b3;
            font-weight: bold;
        }

        /* Buttons */
        .btn-submit {
            background-color: #007bff;
            color: #fff;
            border: none;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include ('menu.php');?>
    <div class="container">
        <div class="form-container">
            <h2 class="form-heading">Student Form</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="student_class" class="form-label">Student Class</label>
                    <input type="text" class="form-control" name="student_class" id="student_class" placeholder="Enter student class">
            
        <?php
        require_once 'connect.php'; // Include database connection

        // Assuming the current user's `schoollevel` is stored in session
        $schoollevel = $_SESSION['schoollevel']; // Replace with the actual session variable

        // Fetch classes from the scrap table based on the user's schoollevel
        $stmt = $dbh->prepare("SELECT item FROM scrap WHERE type = :schoollevel");
        $stmt->bindParam(':schoollevel', $schoollevel);
        $stmt->execute();
        $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Populate the dropdown with the fetched classes
        foreach ($classes as $class) {
            echo '<option value="' . htmlspecialchars($class['item']) . '">' . htmlspecialchars($class['item']) . '</option>';
        }
        ?>
    </select>
</div>
                <div class="mb-3">
                    <label for="student_fname" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="student_fname" name="student_fname" placeholder="Enter first name">
                </div>
                <div class="mb-3">
                    <label for="student_lname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="student_lname" name="student_lname" placeholder="Enter last name">
                </div>
                <div class="mb-3">
                <label for="student_image" class="form-label">Upload Student Image</label>
               <input type="file" class="form-control" name="student_image" id="student_image" accept="image/*" required>
  

            </div>

                <button type="submit" name="submit" class="btn btn-submit w-100">Submit</button>
            </form>

            <?php
include ("connect.php");
if (isset($_POST['submit'])) {
    // Retrieve form data
    $student_class = $_POST['student_class'];
    $student_fname = $_POST['student_fname'];
    $student_lname = $_POST['student_lname'];

    // Generate incremental student_id based on schoolid
$stmt_last_id = $dbh->prepare("SELECT MAX(CAST(SUBSTRING(student_id, 3) AS UNSIGNED)) AS last_id FROM students WHERE schoolid = :schoolid");
$stmt_last_id->bindParam(':schoolid', $schoolid, PDO::PARAM_STR);
$stmt_last_id->execute();
$last_id = $stmt_last_id->fetch(PDO::FETCH_ASSOC)['last_id'];

// Create new student_id (e.g., st1023)
$new_student_id = 'st' . str_pad(($last_id + 1), 4, '0', STR_PAD_LEFT);

// Ensure 'pics/' directory exists and has proper permissions (e.g., chmod 755 on Linux)
$upload_directory = 'pics/';

if (isset($_FILES['student_image']) && $_FILES['student_image']['error'] == 0) {
    // Ensure the directory exists
    if (!is_dir($upload_directory)) {
        mkdir($upload_directory, 0755, true); // Create the directory if it doesn't exist
    }

    // Set the file path with the new name (student_id.png)
    $image_path = $upload_directory . $new_student_id . '.png';

    // Attempt to move the uploaded file
    if (move_uploaded_file($_FILES['student_image']['tmp_name'], $image_path)) {
        $student_image = $image_path; // Save the new path for database insertion
    } else {
        echo 'Failed to move uploaded file.';
        $student_image = $upload_directory . 'default.png'; // Fallback to a default image
    }
} else {
    echo 'File upload error.';
    $student_image = $upload_directory . 'default.png'; // Fallback to a default image
}
    try {
        // Prepare SQL statement to insert data into the students table
      $sql = "INSERT INTO students (schoolid, student_id, student_class, student_fname, student_lname, student_image) 
        VALUES (:schoolid, :student_id, :student_class, :student_fname, :student_lname, :student_image)";
        $stmt = $dbh->prepare($sql);

        // Bind parameters to the prepared statement
        $stmt->bindParam(':student_class', $student_class, PDO::PARAM_STR);
        $stmt->bindParam(':student_fname', $student_fname, PDO::PARAM_STR);
        $stmt->bindParam(':student_lname', $student_lname, PDO::PARAM_STR);
        $stmt->bindParam(':student_image', $student_image, PDO::PARAM_STR);
        $stmt->bindParam(':schoolid', $schoolid, PDO::PARAM_STR); 
        $stmt->bindParam(':student_id', $new_student_id, PDO::PARAM_STR);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Student data submitted successfully!";
        } else {
            echo "Failed to submit student data.";
        }
    } catch (PDOException $e) {
        // Handle any errors
        echo "Error: " . $e->getMessage();
    }
}
?>



        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>