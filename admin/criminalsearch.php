<?php
$mysqli = new mysqli('localhost', 'root', '', 'caaz');
require_once('includes/session.php');
require_once('check.php');
require_once('session_check.php');
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
$criminalIds = getCrimeIds(); // Assuming you have a function to fetch criminal IDs

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $searchById = $_POST['searchById'];
    $searchByNumber = $_POST['searchByNumber'];
    $searchByName = $_POST['searchByName'];
    $searchByDateOfBirth = $_POST['searchByDateOfBirth'];

    if (!empty($searchById)) {
        $query = "SELECT * FROM employees WHERE employee_id = ?";
        $searchInput = $searchById;
    } elseif (!empty($searchByNumber)) {
        $query = "SELECT * FROM employees WHERE phone = ?";
        $searchInput = $searchByNumber;
    } elseif (!empty($searchByName)) {
        $query = "SELECT * FROM employees WHERE name LIKE ?";
        $searchInput = '%' . $searchByName . '%';
    } elseif (!empty($searchByDateOfBirth)) {
        $searchByDateOfBirth = DateTime::createFromFormat('d-m-Y', $searchByDateOfBirth)->format('Y-m-d');
        $query = "SELECT * FROM employees WHERE dateofbirth = ?";
        $searchInput = $searchByDateOfBirth;
    } else {
        echo "Please enter at least one search criterion.";
        exit;
    }
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $searchInput);
    $stmt->execute();
    $result = $stmt->get_result();
    $results = $result->fetch_all(MYSQLI_ASSOC);
}

function getCrimeIds()
{
    global $mysqli;
    $criminalIds = array();
    $query = "SELECT DISTINCT employee_id FROM employees";
    $result = $mysqli->query($query);
    while ($row = $result->fetch_assoc()) {
        $criminalIds[] = $row['employee_id'];
    }
    return $criminalIds;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>CAAZ | SECURITY - CRIMINAL SEARCH</title>

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
                <li class="active">
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
            <div class="panel panel-default sammacmedia">
                <br />
                <button id="printBtn" class="btn btn-primary" style="margin-left: 85%;padding:10px 10px 10px 10px;">
                    <i class="fa fa-download"></i>&nbsp;&nbsp;&nbsp;Download PDF
                </button>
                <br />
                <br />
                <div class="panel-heading">CAAZ Criminals Search</div>
                <div class="panel-body">
                    <!-- Update the search form -->
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-inline" method="POST" action="" id="searchForm"
                                onsubmit="return validateSearchForm()" autocomplete="off">
                                <div class="form-group">
                                    <label for="searchById">Search by ID :&nbsp;&nbsp;&nbsp;</label>
                                    <select class="form-control" id="searchById" name="searchById"
                                        style="width: 200px;">
                                        <option value="">Select Criminal ID</option>
                                        <?php foreach ($criminalIds as $criminalId): ?>
                                            <option value="<?php echo $criminalId; ?>">
                                                <?php echo $criminalId; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="searchByNumber">Search by Mobile :&nbsp;&nbsp;&nbsp;</label>
                                    <input type="text" class="form-control" id="searchByNumber" name="searchByNumber"
                                        placeholder="Enter mobile number" maxlength="10" style="width: 200px;">
                                </div>

                                <div class="form-group">
                                    <label for="searchByName">Search by Name :&nbsp;&nbsp;&nbsp;</label>
                                    <input type="text" class="form-control" id="searchByName" name="searchByName"
                                        placeholder="Enter name" style="width: 200px;">
                                </div>

                                <div class="form-group">
                                    <label for="searchByDateOfBirth">Search by DOB :&nbsp;&nbsp;&nbsp;</label>
                                    <input type="text" class="form-control" id="searchByDateOfBirth"
                                        name="searchByDateOfBirth" data-date-format="dd-mm-yyyy" autocomplete="off"
                                        placeholder="DD-MM-YYYY" style="width: 200px;">
                                </div>

                                <button type="submit" class="btn btn-primary" id="searchButton">Search</button>
                                <button type="reset" class="btn btn-danger" id="resetButton">Reset</button>
                            </form>

                        </div>
                    </div>

                    <br />
                    <div class="row">
                        <div class="col-md-12">
                            <?php if (isset($results) && !empty($results)): ?>
                                <table class="table table-bordered" id="resultTable">
                                    <thead>
                                        <tr>
                                            <th> <input type="checkbox" id="selectAllCheckbox"> All</th>
                                            <th>Criminal ID</th>
                                            <th>Criminal Name</th>
                                            <th>Date of Birth</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Place</th>
                                            <th>Address</th>
                                            <th>Gender</th>
                                            <th>Father</th>
                                            <th>Mother</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($results as $row):
                                            $originalDate = $row['dateofbirth'];
                                            $newDate = date("d-m-Y", strtotime($originalDate)); ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="record-checkbox"
                                                        data-record-id="<?php echo $row['id']; ?>">
                                                </td>
                                                <td>
                                                    <?php echo $row['employee_id']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['name']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $newDate; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['phone']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['email']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['place']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['address']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['gender']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['father']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['mother']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['description']; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p style="color:black;text-align:center;"><b>No results found</b></p>
                            <?php endif; ?>
                        </div>
                    </div>
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
    <script src="vendors/ckeditor/sammacmedia.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script type="text/javascript">
        function logoutConfirmation() {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = "logout.php";
            }
        }
    </script>
    <script>
        $(function () {
            $("#searchByDateOfBirth").datepicker({
                autoclose: true,
                todayHighlight: true
            });
        });

    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#selectAllCheckbox').click(function () {
                $('.record-checkbox').prop('checked', $(this).prop('checked'));
            });

            // Update individual checkboxes to toggle "Select All" checkbox
            $('.record-checkbox').click(function () {
                if ($('.record-checkbox:checked').length === $('.record-checkbox').length) {
                    $('#selectAllCheckbox').prop('checked', true);
                } else {
                    $('#selectAllCheckbox').prop('checked', false);
                }
            });
            $('#printBtn').click(function () {
                var selectedRecords = [];
                $('.record-checkbox:checked').each(function () {
                    selectedRecords.push({
                        employee_id: $(this).closest('tr').find('td:eq(1)').text().trim(),
                        name: $(this).closest('tr').find('td:eq(2)').text().trim(),
                        dob: $(this).closest('tr').find('td:eq(3)').text().trim(),
                        email: $(this).closest('tr').find('td:eq(4)').text().trim(),
                        phone: $(this).closest('tr').find('td:eq(5)').text().trim(),
                        fatherName: $(this).closest('tr').find('td:eq(6)').text().trim(),
                        motherName: $(this).closest('tr').find('td:eq(7)').text().trim(),
                        place: $(this).closest('tr').find('td:eq(8)').text().trim(),
                        address: $(this).closest('tr').find('td:eq(9)').text().trim(),
                        gender: $(this).closest('tr').find('td:eq(10)').text().trim(),
                        description: $(this).closest('tr').find('td:eq(11)').text().trim()
                    });
                });

                if (selectedRecords.length === 0) {
                    toastr.error('Please select a record to download.');
                    return;
                }

                $('#printBtn').html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Processing...');

                var pdf = new jsPDF({
                    orientation: 'portrait',
                    unit: 'mm',
                    format: 'a4'
                });

                var yOffset = 30;
                var recordHeight = 250;
                var pageHeight = pdf.internal.pageSize.height * (recordHeight / 100);


                selectedRecords.forEach(function (record, index) {
                    if (index > 0) {
                        pdf.addPage();
                    }
                    addGrid(pdf, record, yOffset);
                });
                for (var i = 0; i < pdf.getNumberOfPages(); i++) {
                    pdf.setPage(i + 1);
                    pdf.setDrawColor(0);
                    pdf.setLineWidth(0.5);
                    pdf.rect(5, 5, pdf.internal.pageSize.width - 10, pdf.internal.pageSize.height - 10);
                }
                pdf.setPage(pdf.getNumberOfPages());
                pdf.setFontSize(15);
                pdf.text(15, pdf.internal.pageSize.height - 10, '© Cat Genius Security, ' + new Date().toLocaleDateString('en-GB'));
                pdf.save('Selected-Records.pdf');
                $('.record-checkbox').prop('checked', false);
                $('#selectAllCheckbox').prop('checked', false);
                $('#printBtn').html('<i class="fa fa-check"></i>&nbsp;&nbsp;Print Success');
                toastr.success('Print success');
                setTimeout(function () {
                    $('#printBtn').html('<i class="fa fa-download"></i>&nbsp;&nbsp;Print Records');
                }, 3000);
            });

            function addGrid(pdf, record, yOffset) {
                var xOffsetLeft = 10;
                var xOffsetRight = 70;
                var fontSize = 15;
                var pageWidth = pdf.internal.pageSize.width;
                var headerTitleWidth = pdf.getStringUnitWidth('Criminal Personal Record Informations') * 25 / pdf.internal.scaleFactor;
                var titleXOffset = (pageWidth - headerTitleWidth) / 2;
                var tableWidth = 180;
                var tableXCenter = pdf.internal.pageSize.width / 2 - tableWidth / 2;
                pdf.setFont("bold");
                pdf.setFontSize(25);
                pdf.setTextColor(0, 102, 204);
                pdf.text(titleXOffset, 20, 'Criminal Record Information');
                pdf.setFont("normal");
                pdf.setFontSize(fontSize);
                const headerColor = [0, 102, 204];
                const rowEvenColor = [224, 224, 224];
                const rowOddColor = [255, 255, 255];
                const tableHeaders = ['Field', 'Data'];
                pdf.setFillColor.apply(null, headerColor);
                pdf.rect(tableXCenter, yOffset, tableWidth, 10, 'F');
                pdf.setTextColor(255);
                pdf.text(tableXCenter + 5, yOffset + 7, tableHeaders[0]);
                pdf.text(tableXCenter + tableWidth / 2 + 5, yOffset + 7, tableHeaders[1]);
                pdf.setFont("normal");
                pdf.setFontSize(fontSize);
                const rowData = [
                    ['Criminal Id', record.employee_id],
                    ['Criminal Name', record.name],
                    ['DOB', record.dob],
                    ['Email', record.email],
                    ['Mobile', record.phone],
                    ['Father Name', record.fatherName],
                    ['Mother Name', record.motherName],
                    ['Address', record.address],
                    ['Place', record.place],
                    ['Gender', record.gender],
                    ['Description', record.description]
                ];

                rowData.forEach((row, index) => {
                    const yPosition = yOffset + 10 + index * 10;
                    pdf.setFillColor.apply(null, index % 2 === 0 ? rowEvenColor : rowOddColor);
                    pdf.rect(tableXCenter, yPosition, tableWidth, 10, 'F');
                    pdf.setTextColor(0);
                    pdf.text(tableXCenter + 5, yPosition + 7, row[0]);
                    pdf.text(tableXCenter + tableWidth / 2 + 5, yPosition + 7, row[1]);
                });
            }

        });
    </script>

    <script type="text/javascript">
        function validateSearchForm() {
            var searchById = document.getElementById('searchById').value;
            var searchByNumber = document.getElementById('searchByNumber').value;
            var searchByName = document.getElementById('searchByName').value;
            var searchByDateOfBirth = document.getElementById('searchByDateOfBirth').value;

            // Check if the print button triggered the form submission
            var isPrintButton = ($('#printBtn').data('clicked') === true);

            if (!isPrintButton && searchById === '' && searchByNumber === '' && searchByName === '' && searchByDateOfBirth === '') {
                toastr.error('Please enter at least one search criteria.');
                return false;
            }
            return true;
        }

    </script>
    <script>
        document.getElementById('resetButton').addEventListener('click', function (event) {
            event.preventDefault();
            document.getElementById('searchForm').reset();
            document.getElementById('resultTable').innerHTML = ' <p style="color:black;text-align:center;"><b>No results found</b></p>';
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