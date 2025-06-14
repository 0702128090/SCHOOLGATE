<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title>SchoolGate</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="https://colorlib.com/etc/lf/Login_v20/images/icons/favicon.ico">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login%20V20_files/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login%20V20_files/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login%20V20_files/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login%20V20_files/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login%20V20_files/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login%20V20_files/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login%20V20_files/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login%20V20_files/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login%20V20_files/util.css">
	<link rel="stylesheet" type="text/css" href="Login%20V20_files/main.css">
<!--===============================================================================================-->
<meta name="robots" content="noindex, follow">
</head>
<body>
<?php

session_start(); // Start session management
require_once 'main/connect.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username']; // Username or email
    $password = $_POST['pass'];     // Password

    // Step 1: Verify credentials in keyfields table
    $stmt_keyfields = $dbh->prepare("SELECT * FROM keyfields WHERE username = :username AND password = :password");
    $stmt_keyfields->bindParam(':username', $username);
    $stmt_keyfields->bindParam(':password', $password); // Use password hashing for better security in production
    $stmt_keyfields->execute();

    if ($stmt_keyfields->rowCount() > 0) {
        // Step 2: Fetch additional details from the users table
        $stmt_users = $dbh->prepare("SELECT rolenumber, role, schoolid, schoollevel FROM users WHERE username = :username AND status = 1");
        $stmt_users->bindParam(':username', $username);
        $stmt_users->execute();

        if ($stmt_users->rowCount() > 0) {
            $user = $stmt_users->fetch(PDO::FETCH_ASSOC);

            // Step 3: Create session variables
            $_SESSION['rolenumber'] = $user['rolenumber'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['schoolid'] = $user['schoolid'];
            $_SESSION['schoollevel'] = $user['schoollevel'];


            // Success message and redirect
            echo "<p style='color: green;'>Login successful! Redirecting...</p>";
            header("refresh:2;url=main/index.php"); // Redirect to dashboard after 2 seconds
        } else {
            // User not found in users table or not active
            echo "<p style='color: red;'>User details not found or account is inactive.</p>";
        }
    } else {
        // Invalid credentials in keyfields table
        echo "<p style='color: red;'>Invalid credentials.</p>";
    }
}
?>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-b-160 p-t-50">
				<form class="login100-form validate-form" method="POST">
    <span class="login100-form-title p-b-43">
        School Gate
    </span>

    <div class="wrap-input100 rs1 validate-input" data-validate="Username is required">
        <input class="input100" type="text" name="username" required>
        <span class="label-input100">Username</span>
    </div>

    <div class="wrap-input100 rs2 validate-input" data-validate="Password is required">
        <input class="input100" type="password" name="pass" required>
        <span class="label-input100">Password</span>
    </div>

    <div class="container-login100-form-btn">
        <button class="login100-form-btn" type="submit">
            Sign in
        </button>
    </div>

					<div class="text-center w-full p-t-23">
    <a href="#" class="txt1" onclick="toggleForgotPassword()">Forgot password?</a>
</div>

<div id="forgot-password" style="display: none;">
    <form method="POST">
        <div class="wrap-input100">
            <input class="input100" type="text" name="phone" placeholder="Enter your phone number">
        </div>
        <button class="login100-form-btn" type="submit">Send SMS Code</button>
    </form>
</div>

			</div>
		</div>
	</div>





<!--===============================================================================================-->
	<script type="text/javascript" async="" src="Login%20V20_files/analytics.js"></script><script src="Login%20V20_files/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="Login%20V20_files/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="Login%20V20_files/popper.js"></script>
	<script src="Login%20V20_files/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="Login%20V20_files/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="Login%20V20_files/moment.min.js"></script>
	<script src="Login%20V20_files/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="Login%20V20_files/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="Login%20V20_files/main.js"></script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async="" src="Login%20V20_files/js"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-23581568-13');
	</script>
	<script>
    function toggleForgotPassword() {
        const section = document.getElementById("forgot-password");
        section.style.display = section.style.display === "none" ? "block" : "none";
    }
</script>



</body></html>