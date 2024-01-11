<?php
require_once('includes/db.php');

if (isset($mysqli, $_POST['submit'])) {
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $checkEmailQuery = mysqli_query($mysqli, "SELECT email, name, surname FROM users WHERE email = '$email'");
    $userData = mysqli_fetch_assoc($checkEmailQuery);

    if ($userData) {
        $db_email = $userData['email'];
        $db_name = $userData['name'];
        $db_surname = $userData['surname'];
        $resetToken = bin2hex(random_bytes(32));
        mysqli_query($mysqli, "UPDATE users SET reset_token = '$resetToken' WHERE email = '$email'");
        $resetLink = "http://localhost/caaz/updatepassword.php?email=$db_email&token=$resetToken";
    }

    $numRows = mysqli_num_rows($checkEmailQuery);

    if ($numRows > 0) {
        $url = 'https://api.sendinblue.com/v3/smtp/email';
        $apiKey = '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';

        $headers = array(
            'Content-Type: application/json',
            'api-key: ' . $apiKey
        );

        $subject = 'Your Link for Password Reset';
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
                            <p style="color: #555; font-size: 16px;">Please use the following link to reset your password:</p>
                            <p style="color: #555; font-size: 16px;"><a href="' . $resetLink . '">Reset Password</a></p>
                            <p style="color: #555; font-size: 16px;">If you didn\'t request this, please ignore this email.</p>
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
        echo 'alert("Email sent successfully. Please check your inbox for the password reset link.");';
        echo 'window.location.href = "index.php";';
        echo '</script>';
    } else {
        echo '<script>';
        echo 'alert("Email not found. Please enter a valid email address.");';
        echo '</script>';
    }
}

if (isset($_POST['updatepassword'])) {
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $new_password = mysqli_real_escape_string($mysqli, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($mysqli, $_POST['cpassword']);
    $token = mysqli_real_escape_string($mysqli, $_POST['password_token']);

    if (!empty($token)) {
        if (!empty($email) && !empty($new_password) && !empty($confirm_password)) {
            // checking token is valid or not
            $check_token = "SELECT reset_token FROM users WHERE reset_token='$token' LIMIT 1";
            $check_token_run = mysqli_query($mysqli, $check_token);

            if (mysqli_num_rows($check_token_run) > 0) {
                if ($new_password == $confirm_password) {
                    $update_password = "UPDATE users SET password='$new_password' WHERE reset_token='$token' LIMIT 1";
                    $update_password_run = mysqli_query($mysqli, $update_password);

                    if ($update_password_run) {
                        echo '<script>';
                        echo 'alert("Password Updated Successfully");';
                        echo 'window.location.href = "index.php";';
                        echo '</script>';
                    } else {
                        echo '<script>';
                        echo 'alert("Did not Update Password. Something went wrong");';
                        echo 'window.location.href = "updatepassword.php?token=' . $token . '&email=' . $email . '";';
                        echo '</script>';
                    }
                } else {
                    echo '<script>';
                    echo 'alert("Password and Confirm Password doesnot match");';
                    echo 'window.location.href = "updatepassword.php?token=' . $token . '&email=' . $email . '";';
                    echo '</script>';
                }
            } else {
                echo '<script>';
                echo 'alert("Invalid Token");';
                echo 'window.location.href = "updatepassword.php?token=' . $token . '&email=' . $email . '";';
                echo '</script>';
            }
        } else {
            echo '<script>';
            echo 'alert("All Fields are Required");';
            echo 'window.location.href = "updatepassword.php?token=' . $token . '&email=' . $email . '";';
            echo '</script>';
        }
    } else {
        echo '<script>';
        echo 'alert("No Token Available.");';
        echo 'window.location.href = "updatepassword.php";';
        echo '</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Administration | Reset</title>
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
            <form class="login100-form validate-form" method="post" action="forgot_password.php">
                <span class="login100-form-title p-b-37">
                    RESET PASSWORD
                </span>

                <div class="wrap-input100 validate-input m-b-20" data-validate="Enter Email Address ">
                    <input class="input100" type="text" name="email" placeholder="Enter Your Email * ">
                    <span class="focus-input100"></span>
                </div>

                <div class="container-login100-form-btn p-t-20">
                    <button class="login100-form-btn" type="submit" name="submit">
                        Send Reset Link
                    </button>
                </div>

                <div class="text-center p-t-30 p-b-20">
                    <a href="index.php" class="txt2 hov1">
                        <i class="fa fa-home"> Go Home</i>
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