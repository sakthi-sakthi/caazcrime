<?php
require_once('includes/session.php');
require_once('includes/conn.php');
require_once('check.php');
require_once('session_check.php');

$queryEmployees = "SELECT COUNT(*) as count FROM employees";
$resultEmployees = mysqli_query($mysqli, $queryEmployees);
$countEmployees = mysqli_fetch_assoc($resultEmployees)['count'];

$queryUsers = "SELECT COUNT(*) as count FROM users";
$resultUsers = mysqli_query($mysqli, $queryUsers);
$countUsers = mysqli_fetch_assoc($resultUsers)['count'];

$queryCases = "SELECT COUNT(*) as count FROM cases";
$resultCases = mysqli_query($mysqli, $queryCases);
$countCases = mysqli_fetch_assoc($resultCases)['count'];

$queryClosedCases = "SELECT COUNT(*) as count FROM cases WHERE status = 'close'";
$resultClosedCases = mysqli_query($mysqli, $queryClosedCases);
$countClosedCases = mysqli_fetch_assoc($resultClosedCases)['count'];

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
                <li class="active">
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
                <li>
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

            <div class="line"></div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    <div class="panel panel sammac sammacmedia">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-group fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                        <?php echo $countEmployees; ?>
                                    </div>
                                    <div>Total Number Of Criminals</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="panel panel strover sammacmedia">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-book fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                        <?php echo $countCases; ?>
                                    </div>
                                    <div>Total Number Of Cases</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="panel panel sammac sammacmedia">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                        <?php echo $countUsers; ?>
                                    </div>
                                    <div>Total Number Of Users</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="panel panel strover sammacmedia">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-check fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                        <?php echo $countClosedCases; ?>
                                    </div>
                                    <div>Total Number Of Closed Cases</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-6">
                        <canvas id="barChart"></canvas>
                    </div>
                    <div class="col-lg-6">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div </div>
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
        <!-- Chart.js CDN -->
        <!-- Chart.js CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Chart.js Datalabels CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

        <script type="text/javascript">
            function logoutConfirmation() {
                if (confirm("Are you sure you want to logout?")) {
                    window.location.href = "logout.php";
                }
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
</body>

</html>