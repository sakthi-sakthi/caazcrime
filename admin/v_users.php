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
    <link rel="stylesheet" href="vendors/datatables/datatables.min.css">
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
                    <li class="active">
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

            <div class="panel panel-default sammacmedia">
                <div class="panel-heading">CAAZ SMS All Users</div>
                <div class="panel-body">
                    <table class="table table-striped thead-dark table-bordered table-hover" id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Surname</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Access Level</th>
                                <th>Action</th>



                            </tr>
                        </thead>
                        <?php
                        $a = 1;
                        $query = mysqli_query($mysqli, "select *from `users` ");
                        while ($row = mysqli_fetch_array($query)) {

                            ?>
                            <tr>
                                <td>
                                    <?php echo $a; ?>
                                </td>
                                <td>
                                    <?php echo $row['name']; ?>
                                </td>
                                <td>
                                    <?php echo $row['surname']; ?>
                                </td>
                                <td>
                                    <?php echo $row['username']; ?>
                                </td>
                                <td>
                                    <?php echo $row['email']; ?>
                                </td>
                                <td>
                                    <?php echo $row['phone']; ?>
                                </td>
                                <td>
                                    <?php echo $row['permission']; ?>
                                </td>
                                <td>
                                    <a href="v_users.php?edited=1&idx=<?php echo $row['id']; ?>" data-toggle="modal"
                                        class="btn btn-danger"><span class="fa fa-times"></span> Remove</a>
                                </td>
                            </tr>
                            <?php

                            $a++;
                        }



                        if (isset($_GET['idx']) && is_numeric($_GET['idx'])) {
                            $id = $_GET['idx'];
                            if ($stmt = $mysqli->prepare("DELETE FROM users WHERE id = ? LIMIT 1")) {
                                $stmt->bind_param("i", $id);
                                $stmt->execute();
                                $stmt->close();
                                ?>
                                <div class="alert alert-success strover" id="sams1">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                    <strong> Successfully! </strong>
                                    <?php echo 'Record Successfully deleted please refresh this page'; ?>
                                </div>

                                <?php
                            } else {
                                ?>
                                <div class="alert alert-danger samuel" id="sams1">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                    <strong> Danger! </strong>
                                    <?php echo 'OOPS please try again something went wrong'; ?>
                                </div>
                                <?php
                            }
                            $mysqli->close();

                        } else {

                        }
                        ?>


                    </table>
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





    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="vendors/datatables/datatables.min.js"></script>
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
    <script type="text/javascript">

        $(document).ready(function () {

            window.setTimeout(function () {
                $("#sams1").fadeTo(1000, 0).slideUp(1000, function () {
                    $(this).remove();
                });
            }, 5000);

        });
    </script>
    <script type="text/javascript">

        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
</body>

</html>