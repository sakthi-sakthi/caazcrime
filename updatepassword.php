<?php
require_once('session_check.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Administration | Verify Password</title>
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
                <input type="hidden" name="password_token" value="<?php if (isset($_GET['token'])) {
                    echo $_GET['token'];
                } ?>">
                <span class="login100-form-title p-b-37">
                    UPDATE PASSWORD
                </span>

                <div class="wrap-input100 validate-input m-b-25" data-validate="Enter Email">
                    <input class="input100" type="email" name="email" value="<?php if (isset($_GET['email'])) {
                        echo $_GET['email'];
                    } ?>" placeholder="Enter Email Address *">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-25" data-validate="Enter password">
                    <input class="input100" type="text" name="password" placeholder="Enter New Password *">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-25" data-validate="Enter confirm password">
                    <input class="input100" type="text" name="cpassword" placeholder="Enter Confirm Password *">
                    <span class="focus-input100"></span>
                </div>

                <div class="container-login100-form-btn p-t-20">
                    <button class="login100-form-btn" type="submit" name="updatepassword">
                        Update Password
                    </button>
                </div>

                <div class="text-center p-t-30 p-b-20">
                    <a href="forgot_password.php" class="txt2 hov1">
                        <i class="fa fa-arrow-left"> Go Back</i>
                    </a>
                </div>
            </form>
        </div>

    </div>

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