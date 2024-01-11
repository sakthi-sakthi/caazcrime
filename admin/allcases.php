<?php
require_once('includes/session.php');
header("Access-Control-Allow-Origin: *");
require_once('includes/conn.php');
if (isset($_GET['idx']) && is_numeric($_GET['idx']) && isset($_GET['status'])) {
    $id = $_GET['idx'];
    $status = $_GET['status'];

    if ($stmt = $mysqli->prepare("UPDATE cases SET status = ? WHERE id = ?")) {
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
        $stmt->close();
        $_SESSION['update_success'] = 'Case status updated successfully';
        header("Location: allcases.php");
        exit();
    } else {
        $_SESSION['update_error'] = 'Failed to update case status';
        header("Location: allcases.php");
        exit();
    }
}

if (isset($_GET['idx']) && is_numeric($_GET['idx'])) {
    $id = $_GET['idx'];
    if ($stmt = $mysqli->prepare("DELETE FROM cases WHERE id = ? LIMIT 1")) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        $_SESSION['delete_success'] = 'Record successfully deleted';
        header("Location: allcases.php");
        exit();
    } else {
        $_SESSION['delete_error'] = 'Failed to delete record';
        header("Location: allcases.php");
        exit();
    }
}
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
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

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
                <li class="active">
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

            <div class="panel panel-default sammacmedia">
                <br />
                <button id="downloadBtn" class="btn btn-primary" style="margin-left: 85%;padding:10px 10px 10px 10px;">
                    <i class="fa fa-download"></i>&nbsp;&nbsp;&nbsp;Download PDF
                </button>
                <br />
                <br />
                <div class="panel-heading">All Cases Record</div>
                <div class="panel-body">
                    <table class="table table-striped thead-dark table-bordered table-hover" id="myTable">
                        <thead>
                            <tr>
                                <th> <input type="checkbox" id="selectAllCheckbox"> All</th>
                                <th>Case ID</th>
                                <th>Complainant Name</th>
                                <th style="display: none;" class="hidden">DOB</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th style="display: none;" class="hidden">Location</th>
                                <th style="display: none;" class="hidden">Incident</th>
                                <th style="display: none;" class="hidden">Witness</th>
                                <th style="display: none;" class="hidden">Evidence</th>
                                <th style="display: none;" class="hidden">Reporting Officer</th>
                                <th style="display: none;" class="hidden">Case Status</th>
                                <th style="display: none;" class="hidden">Additional Contacts</th>
                                <th style="display: none;" class="hidden">Case Priority</th>
                                <th style="display: none;" class="hidden">Description</th>
                                <th style="display: none;" class="hidden">City</th>
                                <th style="display: none;" class="hidden">State</th>
                                <th style="display: none;" class="hidden">Country</th>
                                <th>Criminal Name</th>
                                <th>Criminal Details</th>
                                <th>Criminal Identity</th>
                                <th>Case Status</th>
                                <th>Actions</th>
                            </tr>

                        </thead>

                        <?php
                        $a = 1;
                        $query = mysqli_query($mysqli, "select *from `cases` ");
                        while ($row = mysqli_fetch_array($query)) {
                            $originalDate = $row['dob'];
                            $newDate = date("d-m-Y", strtotime($originalDate));
                            ?>
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
                                <td style="display: none;" class="hidden">
                                    <?php echo $newDate; ?>
                                </td>
                                <td>
                                    <?php echo $row['phone']; ?>
                                </td>
                                <td>
                                    <?php echo $row['address']; ?>
                                </td>
                                <td style="display: none;" class="hidden">
                                    <?php echo $row['location']; ?>
                                </td>
                                <td style="display: none;" class="hidden">
                                    <?php echo $row['incident']; ?>
                                </td>
                                <td style="display: none;" class="hidden">
                                    <?php echo $row['witness']; ?>
                                </td>
                                <td style="display: none;" class="hidden">
                                    <?php echo $row['evidence']; ?>
                                </td>
                                <td style="display: none;" class="hidden">
                                    <?php echo $row['officer']; ?>
                                </td>
                                <td style="display: none;" class="hidden">
                                    <?php echo $row['status']; ?>
                                </td>
                                <td style="display: none;" class="hidden">
                                    <?php echo $row['addcontact']; ?>
                                </td>
                                <td style="display: none;" class="hidden">
                                    <?php echo $row['priority']; ?>
                                </td>
                                <td style="display: none;" class="hidden">
                                    <?php echo $row['description']; ?>
                                </td>
                                <td style="display: none;" class="hidden">
                                    <?php echo $row['city']; ?>
                                </td>
                                <td style="display: none;" class="hidden">
                                    <?php echo $row['state']; ?>
                                </td>
                                <td style="display: none;" class="hidden">
                                    <?php echo $row['country']; ?>
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
                                <td>
                                    <?php echo $row['status']; ?>
                                </td>
                                <td>
                                    <?php
                                    $caseId = $row['id'];
                                    $caseStatus = $row['status'];
                                    if ($caseStatus == 'open') {
                                        echo '<button onclick="updateCaseStatus(' . $caseId . ', \'close\')" class="btn btn-warning">Close Case</button>';
                                    } elseif ($caseStatus == 'close') {
                                        echo '<button onclick="updateCaseStatus(' . $caseId . ', \'open\')" class="btn btn-success">Reopen Case</button>';
                                    }
                                    if ($_SESSION['permission'] == 1) {
                                        echo '&nbsp;&nbsp;&nbsp;<a href="#" onclick="confirmDelete(' . $caseId . ')" class="btn btn-danger">
                                                    <span class="fa fa-times"></span>
                                                </a>';
                                    }
                                    ?>
                                </td>
                            </tr>

                            <?php
                            require('userInfo.php');
                            $a++;
                        }



                        if (isset($_GET['idx']) && is_numeric($_GET['idx'])) {
                            $id = $_GET['idx'];
                            if ($stmt = $mysqli->prepare("DELETE FROM employees WHERE id = ? LIMIT 1")) {
                                $stmt->bind_param("i", $id);
                                $stmt->execute();
                                $stmt->close();
                                ?>
                                <?php
                                if (isset($_SESSION['delete_success'])) {
                                    echo '<div class="alert alert-success" id="sams1">
                                                <a href="#" class="close" data-dismiss="alert">&times;</a>
                                                <strong>Success! </strong>' . $_SESSION['delete_success'] . '
                                            </div>';
                                    unset($_SESSION['delete_success']); // Clear the session variable
                                }
                                ?>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function updateCaseStatus(caseId, status) {
            var confirmUpdate = confirm("Are you sure you want to " + status + " this case?");

            if (confirmUpdate) {
                $.ajax({
                    url: 'allcases.php',
                    type: 'GET',
                    data: { idx: caseId, status: status },
                    success: function (response) {
                        if (status === 'open') {
                            toastr.success('Case is open');
                        } else if (status === 'close') {
                            toastr.warning('Case is closed');
                        } else if (status === 'reopen') {
                            toastr.success('Case is reopened');
                        }
                        setTimeout(function () {
                            location.reload();
                        }, 800);
                    },
                    error: function (error) {
                    }
                });
            }
        }


    </script>

    <script type="text/javascript">
        function logoutConfirmation() {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = "logout.php";
            }
        }
    </script>
    <script>
        function confirmDelete(id) {
            var confirmDelete = confirm("Are you sure you want to delete this record?");

            if (confirmDelete) {
                window.location.href = 'allcases.php?idx=' + id;
            }
        }

        <?php if (isset($_SESSION['delete_success'])): ?>
            toastr.success('<?php echo $_SESSION['delete_success']; ?>');
            <?php unset($_SESSION['delete_success']); ?>
        <?php endif; ?>
    </script>
    <script src="https://unpkg.com/pdfkit"></script>
    <script src="https://unpkg.com/jspdf-signature-pad"></script>
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
            $('#downloadBtn').click(function () {
                var selectedRecords = [];
                $('.record-checkbox:checked').each(function () {
                    selectedRecords.push({
                        case_id: $(this).closest('tr').find('td:eq(1)').text().trim(),
                        name: $(this).closest('tr').find('td:eq(2)').text().trim(),
                        dob: $(this).closest('tr').find('td:eq(3)').text().trim(),
                        phone: $(this).closest('tr').find('td:eq(4)').text().trim(),
                        address: $(this).closest('tr').find('td:eq(5)').text().trim(),
                        location: $(this).closest('tr').find('td:eq(6)').text().trim(),
                        incident: $(this).closest('tr').find('td:eq(7)').text().trim(),
                        witness: $(this).closest('tr').find('td:eq(8)').text().trim(),
                        evidence: $(this).closest('tr').find('td:eq(9)').text().trim(),
                        officer: $(this).closest('tr').find('td:eq(10)').text().trim(),
                        status: $(this).closest('tr').find('td:eq(11)').text().trim(),
                        addcontact: $(this).closest('tr').find('td:eq(12)').text().trim(),
                        priority: $(this).closest('tr').find('td:eq(13)').text().trim(),
                        description: $(this).closest('tr').find('td:eq(14)').text().trim(),
                        city: $(this).closest('tr').find('td:eq(15)').text().trim(),
                        state: $(this).closest('tr').find('td:eq(16)').text().trim(),
                        country: $(this).closest('tr').find('td:eq(17)').text().trim(),
                        criminalname: $(this).closest('tr').find('td:eq(18)').text().trim(),
                        criminaldetails: $(this).closest('tr').find('td:eq(19)').text().trim(),
                        criminalidentity: $(this).closest('tr').find('td:eq(20)').text().trim()
                    });
                });

                if (selectedRecords.length === 0) {
                    toastr.error('Please select at least one record to download.');
                    return;
                }

                $('#downloadBtn').html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Processing...');

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
                pdf.save('Case-Records.pdf');
                $('.record-checkbox').prop('checked', false);
                $('#selectAllCheckbox').prop('checked', false);
                $('#downloadBtn').html('<i class="fa fa-check"></i>&nbsp;&nbsp;Print Success');
                toastr.success('Print success');
                setTimeout(function () {
                    $('#downloadBtn').html('<i class="fa fa-download"></i>&nbsp;&nbsp;Print Records');
                }, 3000);
                function getReportingOfficerName() {
                    return $('.record-checkbox:checked').first().closest('tr').find('td:eq(10)').text().trim();
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
                var headerTitleWidth = pdf.getStringUnitWidth('Guardians Ledger - Case Record Informations') * 25 / pdf.internal.scaleFactor;
                var titleXOffset = (pageWidth - headerTitleWidth) / 2;
                var tableWidth = 380;
                var tableXCenter = pdf.internal.pageSize.width / 2 - tableWidth / 2;
                pdf.setFont("bold");
                pdf.setFontSize(27);
                pdf.setTextColor(0, 102, 204);
                pdf.text(titleXOffset, 20, 'Guardians Ledger - Case Record Informations');
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
                    ['Date of Birth', record.dob],
                    ['Mobile', record.phone],
                    ['Address', record.address],
                    ['Incident Location', record.location],
                    ['Type of Incident', record.incident],
                    ['Witness Information', record.witness],
                    ['Evidence', record.evidence],
                    ['Reporting Officer', record.officer],
                    ['Case Status', record.status],
                    ['Additional Contacts', record.addcontact],
                    ['Priority Level', record.priority],
                    ['Description', record.description],
                    ['Incident City', record.city],
                    ['Incident State', record.state],
                    ['Country', record.country],
                    ['Criminal Name', record.criminalname],
                    ['Criminal Details', record.criminaldetails],
                    ['Criminal Identity', record.criminalidentity],
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
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });

        $('sams').on('click', function () {
            $('makota').addClass('animated tada');
        });

        $(document).ready(function () {
            window.setTimeout(function () {
                $("#sams1").fadeTo(1000, 0).slideUp(1000, function () {
                    $(this).remove();
                });
            }, 5000);
        });

        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
</body>

</html>