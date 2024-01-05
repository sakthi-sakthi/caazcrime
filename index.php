<?php
require_once('includes/db.php');

if (isset($mysqli, $_POST['submit'])) {
	$username = mysqli_real_escape_string($mysqli, $_POST['username']);
	$password = mysqli_real_escape_string($mysqli, $_POST['password']);

	$query1 = mysqli_query($mysqli, "SELECT username, password, type, permission, name, surname, email FROM users WHERE username = '$username'");

	if ($row = mysqli_fetch_array($query1)) {
		$db_name = $row["name"];
		$db_surname = $row["surname"];
		$db_username = $row["username"];
		$db_password = $row["password"];
		$db_type = $row["type"];
		$db_per = $row["permission"];
		$db_email = $row["email"];

		if ($password == $db_password) {
			session_start();
			$_SESSION["username"] = $db_username;
			$_SESSION["type"] = $db_type;
			$_SESSION["permission"] = $db_per;
			$_SESSION["name"] = $db_name;
			$_SESSION["surname"] = $db_surname;

			if ($_SESSION["type"] == 'user') {
				$otp = mt_rand(100000, 999999);
				$updateQuery = mysqli_query($mysqli, "UPDATE users SET otp = '$otp' WHERE username = '$db_username'");

				if (!$updateQuery) {
					die('Error updating OTP in the database: ' . mysqli_error($mysqli));
				}
				$url = 'https://api.sendinblue.com/v3/smtp/email';
				$apiKey = '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';

				$headers = array(
					'Content-Type: application/json',
					'api-key: ' . $apiKey
				);

				$subject = 'Your OTP for Login';
				$message = '
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>' . $subject . '</title>
                        <style>
							body {
								font-family: Arial, sans-serif;
								background-color: #ecf0f1;
								margin: 0;
								padding: 0;
								text-align: center;
							}

							.container {
								max-width: 600px;
								margin: 0 auto;
								padding: 20px;
								background-color: #fff;
								border-radius: 10px;
								box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
							}

							h1 {
								color: #2c3e50;
								font-size: 28px;
								margin-bottom: 10px;
							}

							p {
								color: #34495e;
								font-size: 16px;
								line-height: 1.6;
							}

							.otp-container {
								background-color: #4CAF50;
								color: #fff;
								padding: 10px;
								border-radius: 5px;
								margin-top: 20px;
								display: inline-block;
							}

							.footer {
								margin-top: 20px;
								color: #777;
								font-size: 14px;
							}
						</style>
                    </head>
                    <body>
                       <div class="container">
							<h1 style="color: #2c3e50; font-size: 28px; margin-bottom: 10px;">' . $subject . '</h1>
							<p style="color: #34495e; font-size: 16px;">Hi ' . $db_name . ' ' . $db_surname . ' 👋</p>
							<p style="color: #34495e; font-size: 16px;">Your Requested OTP is : <span class="otp-container">' . $otp . '</span></p>
							<p style="color: #555; font-size: 16px;">Please use this OTP to complete your login.</p>
							<p style="color: #555; font-size: 16px;">If you didnt request this, please ignore this email.</p>

							<div style="margin-top: 30px;">
								<button style="background-color: #3498db; color: #fff; padding: 10px 20px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer;">Login Now</button>
							</div>

							<p class="footer" style="margin-top: 20px; color: #777; font-size: 14px;">Best regards,<br>CAAZ Information Security</p>
						</div>
                    </body>
                    </html>
                ';

				$data = array(
					'sender' => array('name' => 'CAAZ Information Security', 'email' => 'sakthiganapathis97@gmail.com'),
					'to' => array(array('email' => $db_email)),
					'subject' => $subject,
					'htmlContent' => $message
				);

				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch);
				curl_close($ch);

				echo '<script>';
				echo 'alert("Email sent successfully. Please check your inbox for the OTP.");';
				echo 'var encodedOTP = btoa("' . $otp . '");';
				echo 'window.location.href = "otp_verify.php?otp=" + encodedOTP;';
				echo '</script>';
			}
		} else {
			echo '<script>alert("Invalid password. Please try again.");</script>';
		}
	} else {
		echo '<script>alert("Invalid username. Please try again.");</script>';
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Administration | Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<!--===============================================================================================-->
</head>

<body>

	<div class="container-login100">
		<div class="wrap-login100 p-l-55 p-r-55 p-t-80 p-b-30">
			<form class="login100-form validate-form" method="post" action="index.php">
				<span class="login100-form-title p-b-37">
					ADMIN LOGIN
				</span>

				<div class="wrap-input100 validate-input m-b-20" data-validate="Enter username ">
					<input class="input100" type="text" name="username" placeholder="username * ">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input m-b-25" data-validate="Enter password">
					<input class="input100" type="password" name="password" placeholder="password *">
					<span class="focus-input100"></span>
				</div>

				<div class="container-login100-form-btn">
					<button class="login100-form-btn" type="submit" name="submit">
						Sign In
					</button>
				</div>

				<div class="text-center p-t-30 p-b-20">
					<a href="forgot_password.php" class="txt2 hov1">
						Forgot your password ?
					</a>
				</div>
			</form>
		</div>

	</div>
	<script>
		<?php
		if (isset($_GET['sent']) && $_GET['sent'] == 'success') {
			echo 'alert("Email sent successfully. Please check your inbox for the OTP.");';
		}
		?>
	</script>

	<div id="dropDownSelect1"></div>

	<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
	<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>

</html>