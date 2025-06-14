<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Container for forms */
        .form-container {
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            padding: 20px;
        }

        /* Individual card styles */
        .card {
            flex: 1;
            margin: 10px;
            max-width: 700px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Styling for the student image */
        .student-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        /* Form label styling */
        .form-label {
            font-weight: bold;
        }

        /* Button styling */
        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Input field styling */
        .form-control {
            height: 40px;
            padding: 10px;
        }
    </style>
</head>
<body>
    <?php require_once 'menu.php'; ?>
    <div class="container mt-5 form-container">
        <?php
        require_once 'kfunctions.php';
        include("connect.php");

        // Check if student_id is provided in the URL
        if (isset($_GET['student_id'])) {
            $student_id = $_GET['student_id'];

            try {
                // Fetch the student details including school ID
                $sql = "SELECT student_class, student_fname, student_lname, student_image, credits, schoolid FROM students WHERE student_id = :student_id";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);
                $stmt->execute();

                // Fetch the student details
                $student = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$student) {
                    echo "<p>No student found with the given ID.</p>";
                    exit;
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                exit;
            }
        } else {
            echo "<p>No student ID provided.</p>";
            exit;
        }
        ?>

        <!-- Student Details Form -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3>Student Details</h3>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="student_class" class="form-label">Student Class</label>
                        <input type="text" class="form-control" id="student_class" name="student_class" value="<?= htmlspecialchars($student['student_class'] ?? 'N/A'); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="student_fname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="student_fname" name="student_fname" value="<?= htmlspecialchars($student['student_fname'] ?? 'N/A'); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="student_lname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="student_lname" name="student_lname" value="<?= htmlspecialchars($student['student_lname'] ?? 'N/A'); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="credits" class="form-label">Credits</label>
                        <input type="text" class="form-control" id="credits" name="credits" value="<?= htmlspecialchars($student['credits'] ?? 'N/A'); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="student_image" class="form-label">Student Image</label>
                        <?php if (!empty($student['student_image']) && file_exists($student['student_image'])): ?>
                            <img src="<?= htmlspecialchars($student['student_image']); ?>" alt="Student Image" class="student-image">
                        <?php else: ?>
                            <p>No image available</p>
                        <?php endif; ?>
                    </div>
                    <a href="list_students.php" class="btn btn-secondary">Back to Students List</a>
                </form>
            </div>
        </div>

        <!-- Recipient Details Form -->
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h3>Recipients Details</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter recipient's name" required>
                    </div>
                    <div class="mb-3">
                        <label for="relationship" class="form-label">Relationship</label>
                        <input type="text" class="form-control" id="relationship" name="relationship" placeholder="Enter relationship to student" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
                    </div>
                    <input type="hidden" name="schoolid" value="<?= htmlspecialchars($student['schoolid']); ?>"> <!-- Hidden input for schoolid -->
                    <input type="hidden" name="student_id" value="<?= htmlspecialchars($student_id); ?>"> <!-- Hidden input for student_id -->
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

                <?php
                // Handle form submission
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $name = $_POST['name'];
                    $relationship = $_POST['relationship'];
                    $phone = $_POST['phone'];
                    $email = $_POST['email'];
                    $schoolid = $_POST['schoolid'];
                    $student_id = $_POST['student_id'];

                    try {
                        // Generate recipient_id
                        $stmt = $dbh->query("SELECT COUNT(*) as count FROM recipients");
                        $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
                        $recipient_id = 'PR' . str_pad(($count + 1), 3, '0', STR_PAD_LEFT);

                        // Prepare SQL statement to insert data into the recipients table
                        $sql = "INSERT INTO recipients (recipient_id, student_id, schoolid, name, relationship, phone, email) VALUES (:recipient_id, :student_id, :schoolid, :name, :relationship, :phone, :email)";
                        $stmt = $dbh->prepare($sql);

                        // Bind parameters
                        $stmt->bindParam(':recipient_id', $recipient_id, PDO::PARAM_STR);
                        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);
                        $stmt->bindParam(':schoolid', $schoolid, PDO::PARAM_STR);
                        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                        $stmt->bindParam(':relationship', $relationship, PDO::PARAM_STR);
                        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
                        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

                        // Execute the statement
                        if ($stmt->execute()) {
                            echo "<p class='text-success'>Recipient added successfully!</p>";
                        } else {
                            echo "<p class='text-danger'>Failed to add recipient.</p>";
                        }
                    } catch (PDOException $e) {
                        echo "<p class='text-danger'>Error: " . $e->getMessage() . "</p>";
                    }
                }
                ?>
            </div>
        </div>

        <!-- Recipient Information Display Form -->
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h3>Recipient Information</h3>
            </div>
            <div class="card-body">
                <?php
                // Check if there are any recipients for the student
                try {
                    $sql = "SELECT name, relationship, phone, email FROM recipients WHERE student_id = :student_id";
                    $stmt = $dbh->prepare($sql);
                    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);
                    $stmt->execute();

                    $recipients = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($recipients) {
                        echo "<h5>All Recipients Details:</h5>";
                        foreach ($recipients as $recipient) {
                            echo "<p>Name: " . htmlspecialchars($recipient['name']) . "</p>";
                            echo "<p>Relationship: " . htmlspecialchars($recipient['relationship']) . "</p>";
                            echo "<p>Phone: " . htmlspecialchars($recipient['phone']) . "</p>";
                            echo "<p>Email: " . htmlspecialchars($recipient['email']) . "</p>";
                            echo "<hr>";
                        }
                    } else {
                        echo "<p>No recipient details found for this student. Please enter recipient details for the student.</p>";
                    }
                } catch (PDOException $e) {
                    echo "<p class='text-danger'>Error: " . $e->getMessage() . "</p>";
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>