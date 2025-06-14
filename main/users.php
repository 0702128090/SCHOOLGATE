<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Body background */
        body {
            background-color: #eaf4fc;
            font-family: Arial, sans-serif;
        }

        /* Form container styles */
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        /* Form heading styles */
        .form-heading {
            font-size: 26px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            color: #333333;
        }

        /* Field label styles */
        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #0066cc;
        }

        /* Custom submit button */
        .btn-submit {
            background-color: #0066cc;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
        }

        .btn-submit:hover {
            background-color: #004c99;
        }
    </style>
</head>
<body>
    <?php include('menu.php'); ?>
    <div class="container">
        <div class="form-container">
            <h2 class="form-heading">Users Form</h2>
            <?php
            include("connect.php");
            $successMessage = "";

            if (isset($_POST['submit'])) {
                // Retrieve form data
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $username = $_POST['username'];
                $password = $_POST['password']; // Plain text password
                $role = $_POST['role'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $schoolId = $_POST['schoolId'];

                function generateRoleNumber($role, $dbh) {
                    try {
                        // Query to get the last inserted rolenumber for the given role
                        $sql = "SELECT rolenumber FROM users WHERE role = :role ORDER BY autoid DESC LIMIT 1";
                        $stmt = $dbh->prepare($sql);
                        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
                        $stmt->execute();
                        $lastRoleNumber = $stmt->fetchColumn();

                        if ($lastRoleNumber) {
                            // Extract the numeric part of the last rolenumber
                            $lastNumber = (int)substr($lastRoleNumber, strlen($role));
                            // Increment the numeric part
                            $newNumber = $lastNumber + 1;
                        } else {
                            // Start with 0001 if no previous rolenumber exists
                            $newNumber = 1;
                        }

                        // Generate the new rolenumber by appending the 4-digit number to the role
                        $newRoleNumber = $role . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

                        return $newRoleNumber;
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                        return null;
                    }
                }

                // Generate the new role number
                $newRoleNumber = generateRoleNumber($role, $dbh);

                try {
                    // Insert data into the 'users' table
                    $sql_users = "INSERT INTO users (fname, lname, username, rolenumber, role, email, phone, schoolid, status) 
                                  VALUES (:fname, :lname, :username, :rolenumber, :role, :email, :phone, :schoolId, 1)";
                    $stmt_users = $dbh->prepare($sql_users);
                    $stmt_users->bindParam(':fname', $fname, PDO::PARAM_STR);
                    $stmt_users->bindParam(':lname', $lname, PDO::PARAM_STR);
                    $stmt_users->bindParam(':username', $username, PDO::PARAM_STR);
                    $stmt_users->bindParam(':rolenumber', $newRoleNumber, PDO::PARAM_STR);
                    $stmt_users->bindParam(':role', $role, PDO::PARAM_STR);
                    $stmt_users->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt_users->bindParam(':phone', $phone, PDO::PARAM_STR);
                    $stmt_users->bindParam(':schoolId', $schoolId, PDO::PARAM_STR);
                    $stmt_users->execute();
                
                    // Insert data into the 'keyfields' table
                    $sql_keyfields = "INSERT INTO keyfields (rolenumber, email, username, password, expiry, status) 
                                      VALUES (:rolenumber, :email, :username, :password, NULL, 1)";
                    $stmt_keyfields = $dbh->prepare($sql_keyfields);
                    $stmt_keyfields->bindParam(':rolenumber', $newRoleNumber, PDO::PARAM_STR);
                    $stmt_keyfields->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt_keyfields->bindParam(':username', $username, PDO::PARAM_STR);
                    $stmt_keyfields->bindParam(':password', $password, PDO::PARAM_STR); // Store plain text password
                    $stmt_keyfields->execute();

                    $successMessage = "<div class='alert alert-success'>User added successfully!</div>";
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            }
            ?>

            <?php echo $successMessage; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="fname" class="form-label">First Name</label>
                    <input type="text" name="fname" class="form-control" id="fname" placeholder="Enter first name" required>
                </div>
                <div class="mb-3">
                    <label for="lname" class="form-label">Last Name</label>
                    <input type="text" name="lname" class="form-control" id="lname" placeholder="Enter last name" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" id="username" placeholder="Enter username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" name="role" id="role" required>
                        <option value="">Select option</option>
                        <option value="sca">School Administrator</option>
                        <option value="ask">Askari</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" id="phone" placeholder="Enter your phone number" required>
                </div>
                <input type="hidden" name="schoolId" value="<?php echo htmlspecialchars($_GET['schoolId']); ?>"> <!-- Hidden field for schoolId -->
                <button type="submit" name="submit" class="btn btn-submit w-100">Submit</button>
            </form>
        </div>
    </div>
    <!-- Bootstrap JS (optional, for interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>