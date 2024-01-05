<?php require_once('includes/session.php');
require_once('includes/conn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>CAAZ | SECURITY - DASHBOARD</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/awesome/font-awesome.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet"
        type="text/css" />
</head>

<body>



    <div class="wrapper">
        <!-- Sidebar Holder -->
        <nav id="sidebar" class="sammacmedia">
            <div class="sidebar-header">
                <h3>CAT GENIUS</h3>
                <strong>SMS</strong>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="dashboard.php">
                        <i class="fa fa-th"></i>
                        Dashboard
                    </a>
                </li>
                <?php
                if ($_SESSION['permission'] == 1 or $_SESSION['permission'] == 2) {


                    ?>
                    <li class="active">
                        <a href="a_employees.php">
                            <i class="fa fa-plus"></i>
                            Add Criminals
                        </a>

                    </li>
                <?php } ?>
                <li>
                    <a href="all_employees.php">
                        <i class="fa fa-table"></i>
                        All Criminals
                    </a>
                </li>
                <li>
                    <a href="crimeratio.php">
                        <i class="fa fa-bar-chart-o"></i>
                        Crime Ratio Chart
                    </a>
                </li>
                <li>
                    <a href="invest.php">
                        <i class="fa fa-link"></i>
                        Report Issues
                    </a>
                </li>
                <?php
                if ($_SESSION['permission'] == 1 or $_SESSION['permission'] == 2) {


                    ?>
                    <li>
                        <a href="v_issue.php">
                            <i class="fa fa-table"></i>
                            View Issues
                        </a>
                    </li>
                <?php } ?>
                <?php
                if ($_SESSION['permission'] == 1) {
                    ?>
                    <li>
                        <a href="a_users.php">
                            <i class="fa fa-user"></i>
                            Add Users
                        </a>
                    </li>
                    <li>
                        <a href="v_users.php">
                            <i class="fa fa-table"></i>
                            View Users
                        </a>
                    </li>
                <?php } ?>
                <li>
                    <a href="settings.php">
                        <i class="fa fa-cog"></i>
                        Settings
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <i class="fa fa-power-off"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content Holder -->
        <div id="content">

            <div clas="col-md-12">
                <img src="assets/image/ssm.jpg" class="img-thumbnail">
            </div>

            <br />

            <?php
            if (isset($mysqli, $_POST['submit'])) {
                $name = mysqli_real_escape_string($mysqli, $_POST['fname']);
                $date = date('Y-m-d', strtotime($_POST['date']));
                $email = mysqli_real_escape_string($mysqli, $_POST['email']);
                $phon = mysqli_real_escape_string($mysqli, $_POST['phone']);
                $father = mysqli_real_escape_string($mysqli, $_POST['father']);
                $mother = mysqli_real_escape_string($mysqli, $_POST['mother']);
                $place = mysqli_real_escape_string($mysqli, $_POST['place']);
                $address = mysqli_real_escape_string($mysqli, $_POST['address']);
                $description = mysqli_real_escape_string($mysqli, $_POST['description']);
                $gender = mysqli_real_escape_string($mysqli, $_POST['gender']);
                $joined = date(" d M Y ");
                $employee_id = rand(9999999, 1000000);
                $tmp = rand(1, 9999);
                $phone = $phon;
                $file = $_FILES['file'];
                $fileName = $file['name'];
                $fileTmpName = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileError = $file['error'];
                $fileType = $file['type'];
                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));
                $allowed = array('jpg', 'jpeg', 'png');


                $sql_n = "SELECT * FROM employees WHERE phone ='$phone'";
                $res_n = mysqli_query($mysqli, $sql_n);
                $sql_e = "SELECT * FROM employees WHERE email ='$email'";
                $res_e = mysqli_query($mysqli, $sql_e);
                if (mysqli_num_rows($res_e) > 0) {
                    ?>
                    <div class="alert alert-danger samuel animated shake" id="sams1">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong> Danger! </strong>
                        <?php echo 'sorry the email is already registeres for someone'; ?>
                    </div>
                    <?php
                } elseif (mysqli_num_rows($res_n) > 0) {
                    ?>
                    <div class="alert alert-danger samuel animated shake" id="sams1">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong> Danger! </strong>
                        <?php echo 'sorry the phone number is already registered for someone'; ?>
                    </div>
                    <?php
                } else {

                    $sql = "INSERT INTO employees(name,dateofbirth,email,joined,gender,phone,father,mother,place,description,address,tmp,employee_id) VALUES ('$name','$date','$email','$joined','$gender','$phone','$father','$mother','$place','$description','$address','$tmp','$employee_id')";
                    $results = mysqli_query($mysqli, $sql);
                    if (in_array($fileActualExt, $allowed)) {
                        if ($fileError === 0) {
                            if ($fileSize < 1000000) {
                                $fileNameNew = "user" . $tmp . "." . $fileActualExt;
                                $fileDestination = 'assets/image/uploads/' . $fileNameNew;
                                move_uploaded_file($fileTmpName, $fileDestination);
                                $sqli = "INSERT INTO picture(name,tmp)VALUES('$fileNameNew','$tmp')";
                                mysqli_query($mysqli, $sqli);
                                //header('Location:acc.php');
                            }
                        }
                    }


                    if ($results == 1) {
                        ?>
                        <div class="alert alert-success strover animated bounce" id="sams1">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong> Successfully! </strong>
                            <?php echo 'Thank you for adding new Criminal Record'; ?>
                        </div>
                        <?php

                    } else {
                        ?>
                        <div class="alert alert-danger samuel animated shake" id="sams1">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong> Danger! </strong>
                            <?php echo 'OOPS something went wrong'; ?>
                        </div>

                        <?php
                    }
                }
            }

            ?>
            <div class="panel panel-default sammacmedia">
                <div class="panel-heading">Criminials Record Add</div>
                <div class="panel-body">
                    <form method="post" action="a_employees.php" enctype="multipart/form-data"
                        onsubmit="return validateForm()" name="employeeForm">
                        <div class="row form-group">
                            <div class="col-lg-6">
                                <label>Name</label>
                                <input type="text" class="form-control" name="fname" placeholder="Enter a Name">
                            </div>
                            <div class=" col-lg-6">
                                <label>Date of Birth</label>
                                <input class="form-control" type="text" name="date" id="datepicker"
                                    data-date-format="dd-mm-yyyy" autocomplete="off"
                                    placeholder="Enter a Date of Birth" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-6">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter a Valid Email">
                            </div>
                            <div class=" col-lg-6">
                                <label>Phone</label>
                                <input type="text" class="form-control" name="phone" maxlength="10"
                                    placeholder="773452120">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-6">
                                <label>Picture</label>
                                <input type="file" class="form-control" name="file">
                            </div>
                            <div class="col-lg-6">
                                <label>Gender</label>
                                <select class="form-control" name="gender">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-lg-6">
                                <label>Father Name</label>
                                <input type="text" class="form-control" name="father" placeholder="Enter a Father Name">
                            </div>
                            <div class="col-lg-6">
                                <label>Mother Name</label>
                                <input type="text" class="form-control" name="mother" placeholder="Enter a Mother Name">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-lg-6">
                                <label>Place</label>
                                <input type="text" class="form-control" name="place" placeholder="Enter a Place">
                            </div>
                            <div class="col-lg-6">
                                <label>Address</label>
                                <input type="text" class="form-control" name="address" placeholder="Enter a Address">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label>Description</label>
                                <textarea class="form-control" name="description"
                                    placeholder="Enter a Description"></textarea>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" name="submit" class="btn btn-suc btn-block"><span
                                        class="fa fa-plus"></span> &nbsp;Submit</button>
                            </div>
                            <div class="col-md-6">
                                <button type="reset" class="btn btn-dan btn-block"><span class="fa fa-times"></span>
                                    &nbsp;Cancel</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
            <div class="line"></div>
            <footer>
                <p class="text-center">
                    CAAZ Security Matters System &copy;
                    <?php echo date("Y "); ?>Copyright. All Rights Reserved, Powered By SM Systems
                </p>
            </footer>
        </div>

    </div>





    <!-- jQuery CDN -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap Js CDN -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Inside the <head> tag -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script>
        $(function () {
            $("#datepicker").datepicker({
                autoclose: true,
                todayHighlight: true
            });
        });

    </script>

    <script>
        function validateForm() {
            var name = document.forms["employeeForm"]["fname"].value;
            var dateOfBirth = document.forms["employeeForm"]["date"].value;
            var email = document.forms["employeeForm"]["email"].value;
            var phone = document.forms["employeeForm"]["phone"].value;
            var gender = document.forms["employeeForm"]["gender"].value;
            var father = document.forms["employeeForm"]["father"].value;
            var mother = document.forms["employeeForm"]["mother"].value;
            var place = document.forms["employeeForm"]["place"].value;
            var address = document.forms["employeeForm"]["address"].value;
            var description = document.forms["employeeForm"]["description"].value;

            if (name === "" || dateOfBirth === "" || phone === "" || father === "" || mother === "" || place === "" || address === "" || description === "") {
                toastr.error('Please fill in all the fields');
                return false;
            }

            if (!isValidName(name)) {
                toastr.error('Invalid name format');
                return false;
            }

            if (!isValidDateOfBirth(dateOfBirth)) {
                toastr.error('Invalid date of birth');
                return false;
            }

            // Add asynchronous checks for email and phone
            checkIfEmailExists(email);
            checkIfPhoneExists(phone);

            if (!isValidGender(gender)) {
                toastr.error('Please select a valid gender');
                return false;
            }

            if (!isValidAddress(address)) {
                toastr.error('Invalid address format');
                return false;
            }

            if (!isValidDescription(description)) {
                toastr.error('Invalid description format');
                return false;
            }

            // Continue with form submission if all checks pass
            return true;
        }

        function isValidName(name) {
            return /^[A-Za-z\s]+$/.test(name);
        }

        function isValidDateOfBirth(date) {
            var dateRegex = /^\d{2}-\d{2}-\d{4}$/;

            if (!dateRegex.test(date)) {
                return false;
            }
            var dateParts = date.split("-");
            var day = parseInt(dateParts[0], 10);
            var month = parseInt(dateParts[1], 10) - 1;
            var year = parseInt(dateParts[2], 10);

            var inputDate = new Date(year, month, day);
            var currentDate = new Date();
            return inputDate < currentDate;
        }


        function isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email) && /^[^\s@]+\.[^\s@]+$/.test(email);
        }

        function isValidPhoneNumber(phone) {
            return /^[0-9]{10}$/.test(phone) || /^\+[0-9]{1,3}\.[0-9]{10,14}$/.test(phone);
        }

        function isValidGender(gender) {
            return gender === 'male' || gender === 'female';
        }

        function isValidAddress(address) {
            return address.length >= 5;
        }

        function isValidDescription(description) {
            return description.length >= 10;
        }

        function checkIfEmailExists(email) {
            $.post('check_email.php', { email: email }, function (data) {
                if (data === 'exists') {
                    toastr.error('Email already registered');
                }
            });
        }

        function checkIfPhoneExists(phone) {
            $.post('check_phone.php', { phone: phone }, function (data) {
                if (data === 'exists') {
                    toastr.error('Phone number already registered');
                }
            });
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
        $('sams').on('click', function () {
            $('makota').addClass('animated tada');
        });
    </script>
    <script type="text/javascript">

        $(document).ready(function () {

            window.setTimeout(function () {
                $("#sams1").fadeTo(5000, 0).slideUp(1000, function () {
                    $(this).remove();
                });
            }, 8000);

        });
    </script>
</body>

</html>