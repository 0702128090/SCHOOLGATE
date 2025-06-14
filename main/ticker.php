<?php
require_once 'connect.php'; // Include database connection

// Fetch all classes of type 'seniorclass' from the scrap table
$stmt_classes = $dbh->prepare("SELECT item FROM scrap WHERE type = 'seniorclass'");
$stmt_classes->execute();
$classes = $stmt_classes->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Ticker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        .collapsible {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            padding: 15px 20px;
            margin: 5px 0;
            font-size: 20px;
            border: none;
            border-radius: 4px;
            text-align: left;
            display: block;
            width: 100%;
        }

        .collapsible:hover {
            background-color: #0056b3;
        }

        .content {
            display: none;
            overflow: hidden;
            background-color: #f1f1f1;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 8px 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }


    </style>

 
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
<script>
    $(document).ready(function () {
        // Handle attendance action button clicks
        $('.attendance-action').on('click', function () {
            const studentId = $(this).data('student-id'); // Get student ID from button
            const action = $(this).data('action'); // Get action type (arrived/left)

            // Send the request using AJAX
            $.ajax({
                url: 'mark_attendance.php', // The server-side script
                method: 'POST',
                data: {
                    student_id: studentId,
                    action: action // Send action type (arrived/left)
                },
                success: function (response) {
                    alert(response); // Display success or error message
                },
                error: function () {
                    alert('An error occurred while marking attendance.');
                }
            });
        });
    });
</script>
</head>
<body>
    <?php include ("menu.php");?>
    <div class="container">
        <h1>Attendance Mgt.</h1>
        <?php foreach ($classes as $index => $class) { 
            $class_name = htmlspecialchars($class['item']);
        ?>
        <!-- Collapsible header -->
        <button class="collapsible" data-index="<?php echo $index; ?>"><?php echo $class_name; ?></button>
        <div class="content">
          
            <table>
                <thead>
                    <tr>
                      
                        <th>Student</th>
                        
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch students for the current class
                    $stmt_students = $dbh->prepare("SELECT schoolid, student_id, student_class, student_fname, student_lname, student_image, credits, status FROM students WHERE student_class = :class_name");
                    $stmt_students->bindParam(':class_name', $class_name);
                    $stmt_students->execute();
                    $students = $stmt_students->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($students)) {
                        foreach ($students as $student) { ?>
                            <tr>
                             <td>
    <?php if (!empty($student['student_image'])) { ?>
        <img src="<?php echo htmlspecialchars($student['student_image']); ?>" alt="Student Image" width="150" height="150">
    <?php } else { ?>
        No Image
    <?php } ?>
    <?php echo htmlspecialchars($student['student_id'])."<br>".htmlspecialchars($student['student_fname'])." ".htmlspecialchars($student['student_lname']); ?>
</td>
<td>
    <!-- Mark Arrived Button -->
    <button class="attendance-action btn btn-success" data-student-id="<?php echo $student['student_id']; ?>" data-action="arrived">Mark Arrived</button>

    <!-- Mark Left Button -->
    <button class="attendance-action btn btn-danger" data-student-id="<?php echo $student['student_id']; ?>" data-action="left">Mark Left</button>
</td>                        
                                
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="7" class="text-center">No students found in this class.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } ?>
    </div>

    <script>
        // Get all collapsible buttons and their contents
        const collapsibles = document.querySelectorAll('.collapsible');
        const contents = document.querySelectorAll('.content');

        collapsibles.forEach((button, index) => {
            button.addEventListener('click', () => {
                // Hide all content sections first
                contents.forEach((content, i) => {
                    if (i !== index) {
                        content.style.display = 'none';
                    }
                });

                // Toggle the display of the clicked section
                const currentContent = button.nextElementSibling;
                currentContent.style.display = currentContent.style.display === 'block' ? 'none' : 'block';
            });
        });
    </script>
</body>
</html>