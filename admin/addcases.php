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
                    <li>
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
                    <a href="criminalsearch.php">
                        <i class="fa fa-search"></i>
                        Search Criminals
                    </a>
                </li>
                <li class="active">
                    <a href="addcases.php">
                        <i class="fa fa-plus"></i>
                        Add Cases
                    </a>

                </li>
                <li>
                    <a href="allcases.php">
                        <i class="fa fa-book"></i>
                        All Cases
                    </a>
                </li>
                <li>
                    <a href="casesearch.php">
                        <i class="fa fa-search"></i>
                        Search Cases
                    </a>
                </li>
                <li>
                    <a href="caseratio.php">
                        <i class="fa fa-bar-chart-o"></i>
                        Case Ratio Chart
                    </a>
                </li>
                <li>
                    <a href="casetracker.php">
                        <i class="fa fa-search"></i>
                        Find all Cases
                    </a>
                </li>
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
                    <a href="#" onclick="logoutConfirmation()">
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

            <nav class="navbar navbar-default sammacmedia">
                <div class="container-fluid">

                    <div class="navbar-header" id="sams">
                        <button type="button" id="sidebarCollapse" id="makota"
                            class="btn btn-sam animated tada navbar-btn">
                            <i class="glyphicon glyphicon-align-left"></i>
                            <span>Menu</span>
                        </button>
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right  makotasamuel">
                            <li><a href="#" style="color:white;">
                                    <?php require_once('includes/name.php'); ?>
                                </a></li>
                            <li><a href="logout.php"><i class="fa fa-power-off" style="color:white;"> Logout</i></a>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>

            <br />

            <?php
            if (isset($mysqli, $_POST['submit'])) {
                $name = mysqli_real_escape_string($mysqli, $_POST['name']);
                $dob = date('Y-m-d', strtotime($_POST['date']));
                $phon = mysqli_real_escape_string($mysqli, $_POST['phone']);
                $address = mysqli_real_escape_string($mysqli, $_POST['address']);
                $location = mysqli_real_escape_string($mysqli, $_POST['location']);
                $incident = mysqli_real_escape_string($mysqli, $_POST['incident']);
                $witness = mysqli_real_escape_string($mysqli, $_POST['witness']);
                $evidence = mysqli_real_escape_string($mysqli, $_POST['evidence']);
                $officer = mysqli_real_escape_string($mysqli, $_POST['officer']);
                $status = mysqli_real_escape_string($mysqli, $_POST['status']);
                $addcontact = mysqli_real_escape_string($mysqli, $_POST['addcontact']);
                $priority = mysqli_real_escape_string($mysqli, $_POST['priority']);
                $city = mysqli_real_escape_string($mysqli, $_POST['city']);
                $state = mysqli_real_escape_string($mysqli, $_POST['state']);
                $country = mysqli_real_escape_string($mysqli, $_POST['country']);
                $description = mysqli_real_escape_string($mysqli, $_POST['description']);
                $criminalname = mysqli_real_escape_string($mysqli, $_POST['criminalname']);
                $criminaldetails = mysqli_real_escape_string($mysqli, $_POST['criminaldetails']);
                $criminalidentity = mysqli_real_escape_string($mysqli, $_POST['criminalidentity']);
                $case_id = rand(9999999, 1000000);
                $tmp = rand(1, 9999);
                $phone = $phon;
                $joined = date(" d M Y ");

                $sql = "INSERT INTO cases(case_id,name,dob,phone,address,location,incident,witness,evidence,officer,status,addcontact,priority,city,state,country,description,criminalname,criminaldetails,criminalidentity,joined) VALUES ('$case_id','$name','$dob','$phone','$address','$location','$incident','$witness','$evidence','$officer','$status','$addcontact','$priority','$city','$state','$country','$description','$criminalname','$criminaldetails','$criminalidentity','$joined')";
                $results = mysqli_query($mysqli, $sql);

                if ($results == 1) {
                    ?>
                    <div class="alert alert-success strover animated bounce" id="sams1">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong> Successfully! </strong>
                        <?php echo 'Thank you for adding new Case'; ?>
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

            ?>
            <div class="panel panel-default sammacmedia">
                <div class="panel-heading">Guardian's Ledger - Add a Police Case</div>
                <div class="panel-body">
                    <form method="post" action="addcases.php" enctype="multipart/form-data"
                        onsubmit="return validateForm()" name="caseForm">
                        <div class="row form-group">
                            <div class="col-lg-4">
                                <label>Complainant Name <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="name" placeholder="Enter a Name">
                            </div>
                            <div class=" col-lg-4">
                                <label>Date of Birth <span style="color:red;">*</span></label>
                                <input class="form-control" type="text" name="date" id="datepicker"
                                    data-date-format="dd-mm-yyyy" autocomplete="off"
                                    placeholder="Enter a Date of Birth" />
                            </div>
                            <div class=" col-lg-4">
                                <label>Phone <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="phone" maxlength="10"
                                    placeholder="773452120">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-4">
                                <label>Address <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="address" placeholder="Enter a Address">
                            </div>
                            <div class="col-lg-4">
                                <label>Incident Location <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="location" placeholder="Enter Location">
                            </div>
                            <div class="col-lg-4">
                                <label>Type of Incident <span style="color:red;">*</span></label>
                                <select id="incidentType" name="incident" class="form-control">
                                    <option value="theft">Theft</option>
                                    <option value="assault">Assault</option>
                                    <option value="vandalism">Vandalism</option>
                                    <option value="burglary">Burglary</option>
                                    <option value="fraud">Fraud</option>
                                    <option value="hit-and-run">Hit and Run</option>
                                    <option value="domestic-violence">Domestic Violence</option>
                                    <option value="kidnapping">Kidnapping</option>
                                    <option value="robbery">Robbery</option>
                                    <option value="cybercrime">Cybercrime</option>
                                    <option value="carjacking">Carjacking</option>
                                    <option value="arson">Arson</option>
                                    <option value="homicide">Homicide</option>
                                    <option value="sexual-assault">Sexual Assault</option>
                                    <option value="drug-trafficking">Drug Trafficking</option>
                                    <option value="cyber-extortion">Cyber Extortion</option>
                                    <option value="stalking">Stalking</option>
                                    <option value="white-collar-crime">White Collar Crime</option>
                                    <option value="identity-theft">Identity Theft</option>
                                    <option value="assault-with-a-weapon">Assault with a Weapon</option>
                                    <option value="corruption">Corruption</option>
                                    <option value="kidnapping">Kidnapping</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-4">
                                <label>Criminal Name <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="criminalname"
                                    placeholder="Enter Criminal Name">
                            </div>
                            <div class="col-lg-4">
                                <label>Criminal Details <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="criminaldetails"
                                    placeholder="Enter Criminal Details">
                            </div>
                            <div class="col-lg-4">
                                <label>Criminal Identity<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="criminalidentity"
                                    placeholder="Enter a Criminal Identity">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-4">
                                <label>Witness Information <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="witness"
                                    placeholder="witness information">
                            </div>
                            <div class="col-lg-4">
                                <label>Evidence <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="evidence"
                                    placeholder="Enter the Evidence">
                            </div>
                            <div class="col-lg-4">
                                <label>Reporting Officer <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="officer"
                                    placeholder="Enter a Reporting Officer Name">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-4">
                                <label>Case Status <span style="color:red;">*</span></label>
                                <select class="form-control" name="status">
                                    <option value="open">Open</option>
                                    <option value="close">Close</option>
                                    <option value="underinvestigation">Under Investigation</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label>Additional Contacts <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" name="addcontact" maxlength="10"
                                    placeholder="773452120">
                            </div>
                            <div class="col-lg-4">
                                <label>Priority Level <span style="color:red;">*</span></label>
                                <select id="priority" name="priority" class="form-control">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-lg-4">
                                <label>Country <span style="color:red;">*</span></label>
                                <select class="countries form-control" id="countryId" name="country">
                                    <option value="">Select Country</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label>Incident State <span style="color:red;">*</span></label>
                                <select class="states form-control" id="stateId" name="state">
                                    <option value="">Select State</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label>Incident City <span style="color:red;">*</span></label>
                                <select class="cities form-control" id="cityId" name="city">
                                    <option value="">Select City</option>
                                </select>
                            </div>
                        </div>


                        <div class="row form-group">
                            <div class="col-lg-12">
                                <label>Incident Description <span style="color:red;">*</span></label>
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
    <script type="text/javascript">
        function logoutConfirmation() {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = "logout.php";
            }
        }
    </script>
    <script>
        $(document).ready(function () {
            $.ajax({
                url: "https://api.countrystatecity.in/v1/countries",
                method: "GET",
                headers: {
                    "accept": "application/json",
                    "X-CSCAPI-KEY": "MUQzMEptNEE3bXZTNVhSQUVtNEVBNk9ZakgzRk9wcUdFYnJjT0EwNQ=="
                },
                success: function (data) {
                    var countryDropdown = $("#countryId");
                    $.each(data, function (index, country) {
                        countryDropdown.append("<option value='" + country.iso2 + "'>" + country.name + "</option>");
                    });
                    countryDropdown.change(function () {
                        var selectedCountry = $(this).val();
                        $.ajax({
                            url: "https://api.countrystatecity.in/v1/countries/" + selectedCountry + "/states",
                            method: "GET",
                            headers: {
                                "accept": "application/json",
                                "X-CSCAPI-KEY": "MUQzMEptNEE3bXZTNVhSQUVtNEVBNk9ZakgzRk9wcUdFYnJjT0EwNQ=="
                            },
                            success: function (states) {
                                var stateDropdown = $("#stateId");
                                stateDropdown.empty();
                                stateDropdown.append("<option value=''>Select State</option>");
                                $.each(states, function (index, state) {
                                    stateDropdown.append("<option value='" + state.iso2 + "'>" + state.name + "</option>");
                                });
                            },
                            error: function (error) {
                                console.log("Error fetching states: " + JSON.stringify(error));
                            }
                        });
                    });
                    $("#stateId").change(function () {
                        var selectedCountry = $("#countryId").val();
                        var selectedState = $(this).val();
                        $.ajax({
                            url: "https://api.countrystatecity.in/v1/countries/" + selectedCountry + "/states/" + selectedState + "/cities",
                            method: "GET",
                            headers: {
                                "accept": "application/json",
                                "X-CSCAPI-KEY": "MUQzMEptNEE3bXZTNVhSQUVtNEVBNk9ZakgzRk9wcUdFYnJjT0EwNQ=="
                            },
                            success: function (cities) {
                                var cityDropdown = $("#cityId");
                                cityDropdown.empty();
                                cityDropdown.append("<option value=''>Select City</option>");
                                $.each(cities, function (index, city) {
                                    cityDropdown.append("<option value='" + city.name + "'>" + city.name + "</option>");
                                });
                            },
                            error: function (error) {
                                console.log("Error fetching cities: " + JSON.stringify(error));
                            }
                        });
                    });
                },
                error: function (error) {
                    console.log("Error fetching countries: " + JSON.stringify(error));
                }
            });
        });
    </script>

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
            var name = document.forms["caseForm"]["name"].value;
            var dob = document.forms["caseForm"]["date"].value;
            var phone = document.forms["caseForm"]["phone"].value;
            var address = document.forms["caseForm"]["address"].value;
            var location = document.forms["caseForm"]["location"].value;
            var incident = document.forms["caseForm"]["incident"].value;
            var witness = document.forms["caseForm"]["witness"].value;
            var evidence = document.forms["caseForm"]["evidence"].value;
            var officer = document.forms["caseForm"]["officer"].value;
            var status = document.forms["caseForm"]["status"].value;
            var officer = document.forms["caseForm"]["officer"].value;
            var addcontact = document.forms["caseForm"]["addcontact"].value;
            var priority = document.forms["caseForm"]["priority"].value;
            var description = document.forms["caseForm"]["description"].value;
            var city = document.forms["caseForm"]["city"].value;
            var state = document.forms["caseForm"]["state"].value;
            var country = document.forms["caseForm"]["country"].value;
            var criminalname = document.forms["caseForm"]["criminalname"].value;
            var criminaldetails = document.forms["caseForm"]["criminaldetails"].value;
            var criminalidentity = document.forms["caseForm"]["criminalidentity"].value;

            if (name === "" || dob === "" || phone === "" || address === "" || location === "" || incident === "" || witness === "" || evidence === "" || officer === "" || addcontact === "" || priority === "" || description === "" || city === "" || state === "" || country === "" || criminalname === "" || criminaldetails === "" || criminalidentity === "") {
                toastr.error('Please fill in all the fields');
                return false;
            }

            if (!isValidName(name)) {
                toastr.error('Invalid name format');
                return false;
            }

            if (!isValidDOB(dob)) {
                toastr.error('Invalid date of birth');
                return false;
            }

            checkIfPhoneExists(phone);

            if (!isValidAddress(address)) {
                toastr.error('Invalid address format');
                return false;
            }

            if (!isValidLocation(location)) {
                toastr.error('Invalid location format');
                return false;
            }

            if (!isValidIncident(incident)) {
                toastr.error('Invalid incident format');
                return false;
            }

            if (!isValidWitness(witness)) {
                toastr.error('Invalid witness format');
                return false;
            }

            if (!isValidEvidence(evidence)) {
                toastr.error('Invalid evidence format');
                return false;
            }

            if (!isValidOfficer(officer)) {
                toastr.error('Invalid officer name format');
                return false;
            }

            if (!isValidAddContact(addcontact)) {
                toastr.error('Invalid addcontact format');
                return false;
            }

            if (!isValidPriority(priority)) {
                toastr.error('Invalid priority format');
                return false;
            }

            if (!isValidDescription(description)) {
                toastr.error('Invalid description format');
                return false;
            }

            if (!isValidCity(city)) {
                toastr.error('Invalid city format');
                return false;
            }

            if (!isValidState(state)) {
                toastr.error('Invalid state format');
                return false;
            }

            if (!isValidCountry(country)) {
                toastr.error('Invalid country format');
                return false;
            }

            if (!isValidCriminalName(criminalname)) {
                toastr.error('Invalid Criminal Name format');
                return false;
            }

            if (!isValidCriminalDetails(criminaldetails)) {
                toastr.error('Invalid Criminal Details format');
                return false;
            }

            if (!isValidCriminalIdentity(criminalidentity)) {
                toastr.error('Invalid Criminal Identity format');
                return false;
            }

            return true;
        }

        function isValidName(name) {
            return /^[A-Za-z\s]+$/.test(name);
        }

        function isValidDOB(date) {
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

        function isValidPhoneNumber(phone) {
            return /^[0-9]{10}$/.test(phone) || /^\+[0-9]{1,3}\.[0-9]{10,14}$/.test(phone);
        }

        function isValidAddress(address) {
            return address.length >= 5;
        }

        function isValidLocation(location) {
            return location.length >= 1;
        }

        function isValidIncident(incident) {
            return incident.length >= 5;
        }

        function isValidWitness(witness) {
            return witness.length >= 1;
        }

        function isValidEvidence(evidence) {
            return evidence.length >= 5;
        }

        function isValidOfficer(officer) {
            return officer.length >= 1;
        }

        function isValidAddContact(addcontact) {
            return addcontact.length >= 5;
        }

        function isValidPriority(priority) {
            return priority.length >= 1;
        }

        function isValidDescription(description) {
            return description.length >= 10;
        }

        function isValidCity(city) {
            return city.length >= 1;
        }

        function isValidState(state) {
            return state.length >= 1;
        }

        function isValidCountry(country) {
            return country.length >= 1;
        }

        function isValidCriminalName(criminalname) {
            return criminalname.length >= 1;
        }

        function isValidCriminalDetails(criminaldetails) {
            return criminaldetails.length >= 1;
        }

        function isValidCriminalIdentity(criminalidentity) {
            return criminalidentity.length >= 1;
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