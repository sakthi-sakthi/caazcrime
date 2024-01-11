<?php
require_once('includes/session.php');
require_once('includes/conn.php');

function getCrimeCountByDate($groupBy)
{
    global $mysqli;

    $sql = "SELECT DATE_FORMAT(STR_TO_DATE(joined, '%d %b %Y'), '$groupBy') as period, COUNT(*) as count FROM cases GROUP BY period";
    $result = mysqli_query($mysqli, $sql);

    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[$row['period']] = $row['count'];
    }

    return $data;
}

// Fetch data for year-wise, month-wise, and date-wise
$yearlyCrimeData = getCrimeCountByDate('%Y');
$monthlyCrimeData = getCrimeCountByDate('%Y-%m');
$datewiseCrimeData = getCrimeCountByDate('%Y-%m-%d');

$yearlyPeriodNames = array_keys($yearlyCrimeData);
$monthlyPeriodNames = array_keys($monthlyCrimeData);
$datewisePeriodNames = array_keys($datewiseCrimeData);
?>



<!-- rest of your HTML and JavaScript code -->

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
                <li class="active">
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

            <h1 class="text-center">Case Report Statistics</h1>
            <!-- Your existing HTML code -->

            <!-- Chart Row -->
            <div class="row">
                <!-- Pie Chart Column -->
                <div class="col-md-4">
                    <canvas id="monthlyChart" width="200" height="100"></canvas>
                </div>

                <!-- Bar Chart Column -->
                <div class="col-md-4">
                    <canvas id="yearlyChart" width="200" height="100"></canvas>
                </div>

                <div class="col-md-4">
                    <canvas id="datewiseChart" width="200" height="100"></canvas>
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
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Your existing jQuery and Bootstrap code -->

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script type="text/javascript">
        function logoutConfirmation() {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = "logout.php";
            }
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            var yearlyData = {
                labels: <?php echo json_encode($yearlyPeriodNames); ?>,
                datasets: [{
                    label: "Yearly Crime Count",
                    backgroundColor: ["#3498db", "#2ecc71", "#e74c3c", "#f39c12"],
                    data: <?php echo json_encode(array_values($yearlyCrimeData)); ?>,
                    fill: true,
                }],
            };

            var monthlyData = {
                labels: <?php echo json_encode($monthlyPeriodNames); ?>,
                datasets: [{
                    label: "Monthly Crime Count",
                    borderColor: ["#3498db", "#2ecc71", "#e74c3c", "#f39c12"],
                    data: <?php echo json_encode(array_values($monthlyCrimeData)); ?>,
                    fill: true,
                }],
            };

            var datewiseData = {
                labels: <?php echo json_encode($datewisePeriodNames); ?>,
                datasets: [{
                    label: "Date-wise Crime Count",
                    borderColor: ["#3498db", "#2ecc71", "#e74c3c", "#f39c12"],
                    data: <?php echo json_encode(array_values($datewiseCrimeData)); ?>,
                    fill: true,
                }],
            };

            var yearlyCtx = document.getElementById("yearlyChart").getContext("2d");
            var monthlyCtx = document.getElementById("monthlyChart").getContext("2d");
            var datewiseCtx = document.getElementById("datewiseChart").getContext("2d");

            var yearlyChart = new Chart(yearlyCtx, {
                type: 'bar',
                data: yearlyData,
            });

            var monthlyChart = new Chart(monthlyCtx, {
                type: 'line',
                data: monthlyData,
            });

            var datewiseChart = new Chart(datewiseCtx, {
                type: 'line',
                data: datewiseData,
            });
        });
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
                $("#sams1").fadeTo(1000, 0).slideUp(1000, function () {
                    $(this).remove();
                });
            }, 5000);

        });
    </script>
</body>

</html>