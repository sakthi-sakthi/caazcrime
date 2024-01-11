<?php
$mysqli = new mysqli('localhost', 'root', '', 'caaz');
require_once('includes/session.php');
require_once('check.php');
require_once('session_check.php');
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$caseIds = getCaseIds(); // Assuming you have a function to fetch case IDs

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $searchById = isset($_POST['case_id']) ? $_POST['case_id'] : null;
    $searchByIncident = isset($_POST['incident']) ? $_POST['incident'] : null;
    $searchBystatus = isset($_POST['status']) ? $_POST['status'] : null;
    $searchByCriminalname = isset($_POST['criminalname']) ? $_POST['criminalname'] : null;

    if (!empty($searchById)) {
        $query = "SELECT * FROM cases WHERE case_id = ?";
        $searchInput = $searchById;
    } elseif (!empty($searchByIncident)) {
        $query = "SELECT * FROM cases WHERE incident = ?";
        $searchInput = $searchByIncident;
    } elseif (!empty($searchBystatus)) {
        $query = "SELECT * FROM cases WHERE status = ?";
        $searchInput = $searchBystatus;
    } elseif (!empty($searchByCriminalname)) {
        $query = "SELECT * FROM cases WHERE criminalname = ?";
        $searchInput = $searchByCriminalname;
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

function getCaseIds()
{
    global $mysqli; // Make $mysqli accessible inside the function

    $caseIds = array(); // Initialize an array to store case IDs

    $query = "SELECT DISTINCT case_id FROM cases";
    $result = $mysqli->query($query);

    while ($row = $result->fetch_assoc()) {
        $caseIds[] = $row['case_id'];
    }

    return $caseIds;
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
                <li class="active">
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
                <div class="panel-heading">CAAZ Crime Records Search</div>
                <div class="panel-body">
                    <!-- Update the search form -->
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-inline" method="POST" action="" id="searchForm"
                                onsubmit="return validateSearchForm()" autocomplete="off">
                                <div class="form-group">
                                    <label for="searchById">Search by Case ID :&nbsp;&nbsp;&nbsp;</label>
                                    <select class="form-control" id="searchById" name="case_id" style="width: 200px;">
                                        <option value="">Select Case ID</option>
                                        <?php foreach ($caseIds as $caseId): ?>
                                            <option value="<?php echo $caseId; ?>">
                                                <?php echo $caseId; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="searchByIncident">&nbsp;&nbsp;Search by Incident
                                        :&nbsp;&nbsp;&nbsp;</label>
                                    <select id="searchByIncident" name="incident" class="form-control"
                                        style="width: 200px;">
                                        <option value="" disabled selected>Select an Incident</option>
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

                                <div class="form-group">
                                    <label for="searchBystatus">&nbsp;&nbsp;Search by Status
                                        :&nbsp;&nbsp;&nbsp;</label>
                                    <select class="form-control" name="status" id="searchBystatus"
                                        style="width: 200px;">
                                        <option value="" disabled selected>Select a Status</option>
                                        <option value="open">Open</option>
                                        <option value="close">Close</option>
                                        <option value="underinvestigation">Under Investigation</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="searchByCriminalname">&nbsp;&nbsp;Search by Criminal
                                        :&nbsp;&nbsp;&nbsp;</label>
                                    <input type="text" class="form-control" id="searchByCriminalname"
                                        name="criminalname" placeholder="Enter Criminal Name" style="width: 200px;">
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
                                            <th><input type="checkbox" id="selectAllCheckbox"> All</th>
                                            <th>Case ID</th>
                                            <th>Complainant Name</th>
                                            <th>Complainant Phone</th>
                                            <th>Complainant Address</th>
                                            <th>Incident Location</th>
                                            <th>Incident Type</th>
                                            <th>Witness Information</th>
                                            <th>Evidence</th>
                                            <th>Reporting Officer</th>
                                            <th>Case Status</th>
                                            <th>Criminal Name</th>
                                            <th>Criminal Details</th>
                                            <th>Criminal Identity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($results as $row): ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="record-checkbox"
                                                        data-record-id="<?php echo $row['id']; ?>">
                                                </td>
                                                <td>
                                                    <?php echo $row['case_id']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['name']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['phone']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['address']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['location']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['incident']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['witness']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['evidence']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['officer']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['status']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['criminalname']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['criminaldetails']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['criminalidentity']; ?>
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

    <script type="text/javascript">
        $(document).ready(function () {
            $('#selectAllCheckbox').click(function () {
                $('.record-checkbox').prop('checked', $(this).prop('checked'));
            });

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
                        case_id: $(this).closest('tr').find('td:eq(1)').text().trim(),
                        name: $(this).closest('tr').find('td:eq(2)').text().trim(),
                        phone: $(this).closest('tr').find('td:eq(3)').text().trim(),
                        address: $(this).closest('tr').find('td:eq(4)').text().trim(),
                        location: $(this).closest('tr').find('td:eq(5)').text().trim(),
                        incident: $(this).closest('tr').find('td:eq(6)').text().trim(),
                        witness: $(this).closest('tr').find('td:eq(7)').text().trim(),
                        evidence: $(this).closest('tr').find('td:eq(8)').text().trim(),
                        officer: $(this).closest('tr').find('td:eq(9)').text().trim(),
                        status: $(this).closest('tr').find('td:eq(10)').text().trim(),
                        criminalname: $(this).closest('tr').find('td:eq(11)').text().trim(),
                        criminaldetails: $(this).closest('tr').find('td:eq(12)').text().trim(),
                        criminalidentity: $(this).closest('tr').find('td:eq(13)').text().trim()
                    });
                });

                if (selectedRecords.length === 0) {
                    toastr.error('Please select a record to download.');
                    return;
                }

                $('#printBtn').html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Processing...');

                var pdf = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: 'a3'
                });

                var yOffset = 30;
                var recordHeight = 400;
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
                var textWidth = pdf.getStringUnitWidth('© Cat Genius Security, ' + new Date().toLocaleDateString('en-GB')) * 15 / pdf.internal.scaleFactor;
                var centerPosition = (pdf.internal.pageSize.width - textWidth) / 2;
                pdf.text(centerPosition, pdf.internal.pageSize.height - 10, '© Cat Genius Security, ' + new Date().toLocaleDateString('en-GB'));
                var currentDate = new Date();
                var formattedDate = currentDate.toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric' });
                var formattedTime = currentDate.toLocaleTimeString();
                var reportingOfficerName = getReportingOfficerName();
                var signatureImage = captureSignature(reportingOfficerName);
                var issueDetails = `Issued on: ${formattedDate} at ${formattedTime}\nPlace: Crime Data Office`;
                pdf.text(30, pdf.internal.pageSize.height - 30, issueDetails);
                pdf.text(30, pdf.internal.pageSize.height - 20, '\nDigital Signature: ' + reportingOfficerName);
                pdf.save('Selected-Cases.pdf');
                $('.record-checkbox').prop('checked', false);
                $('#selectAllCheckbox').prop('checked', false);
                $('#printBtn').html('<i class="fa fa-check"></i>&nbsp;&nbsp;Print Success');
                toastr.success('Print success');
                setTimeout(function () {
                    $('#printBtn').html('<i class="fa fa-download"></i>&nbsp;&nbsp;Print Records');
                }, 3000);
                function getReportingOfficerName() {
                    return $('.record-checkbox:checked').first().closest('tr').find('td:eq(9)').text().trim();
                }

                function captureSignature(officerName) {
                    var canvas = document.createElement('canvas');
                    var context = canvas.getContext('2d');
                    context.font = '12px Arial';
                    context.fillText(officerName, 0, 10);

                    var dataUrl = canvas.toDataURL('image/jpeg');
                    return dataUrl;
                }

            });

            function addGrid(pdf, record, yOffset) {
                var xOffsetLeft = 30;
                var xOffsetRight = 90;
                var fontSize = 16;
                var pageWidth = pdf.internal.pageSize.width;
                var headerTitleWidth = pdf.getStringUnitWidth('Guardians Ledger - Personal Case Record Informations') * 25 / pdf.internal.scaleFactor;
                var titleXOffset = (pageWidth - headerTitleWidth) / 2;
                var tableWidth = 380;
                var tableXCenter = pdf.internal.pageSize.width / 2 - tableWidth / 2;
                pdf.setFont("bold");
                pdf.setFontSize(27);
                pdf.setTextColor(0, 102, 204);
                pdf.text(titleXOffset, 20, 'Guardians Ledger - Personal Case Record Informations');
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
                    ['Case ID', record.case_id],
                    ['Complainant Name', record.name],
                    ['Complainant Mobile', record.phone],
                    ['Complainant Address', record.address],
                    ['Incident Location', record.location],
                    ['Incident Type', record.incident],
                    ['Witness Information', record.witness],
                    ['Evidence', record.evidence],
                    ['Reporting Officer', record.officer],
                    ['Case Status', record.status],
                    ['Criminal Name', record.criminalname],
                    ['Criminal Details', record.criminaldetails],
                    ['Criminal Identity', record.criminalidentity]
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