<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Information Form</title>
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
            padding: 15px;
            text-align: center;
            width: 100%;
        }

        .menu a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }

        .menu a:hover {
            text-decoration: underline;
        }

        .form-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 40px auto; /* Added margin to separate from menu */
            padding: 60px;
            border: 1px solid #ddd;
            height: auto;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border 0.3s;
        }

        input[type="text"]:focus,
        select:focus {
            border-color: #28a745;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
            margin-top: 20px;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
        <?php include ('menu.php');?>
    

    <div class="form-container">
        <h1>School Information</h1>
        <form id="schoolForm" method="POST">
            <div class="form-group">
                <label for="school">School:</label>
                <select id="school" name="school" required>
                    <option value="" disabled selected>Select Option</option>
                    <option value="Prisch">Primary School</option>
                    <option value="Secsch">Secondary School</option>
                </select>
            </div>
            <div class="form-group">
                <label for="schoolName">School Name:</label>
                <input type="text" id="schoolName" name="schoolName" required>
            </div>
            <button type="submit" name="submit">Submit</button>
        </form>
    </div>

    <?php
    include("connect.php");
    if (isset($_POST['submit'])) {
        // Retrieve form data
        $school = $_POST['school'];
        $schoolName = $_POST['schoolName'];

        // Generate the school ID based on the selected type
        try {
            // Determine the correct prefix based on school type
            $prefix = ($school === "Prisch") ? "PR" : "SC";

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
            $stmt->bindParam(':school', $school, PDO::PARAM_STR);
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
</body>
</html>