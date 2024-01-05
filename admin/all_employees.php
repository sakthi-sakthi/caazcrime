<?php require_once('includes/session.php');
header("Access-Control-Allow-Origin: *");
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
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


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
                <li class="active">
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

            <div class="panel panel-default sammacmedia">
                <br />
                <button id="downloadBtn" class="btn btn-primary"
                    style="margin-left: 145rem;padding:10px 10px 10px 10px;">
                    <i class="fa fa-download"></i>&nbsp;&nbsp;&nbsp;Download PDF
                </button>
                <br />
                <br />
                <div class="panel-heading">All Criminials Record</div>
                <div class="panel-body">
                    <table class="table table-striped thead-dark table-bordered table-hover" id="myTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>No</th>
                                <th>Name</th>
                                <th>DOB</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Father Name</th>
                                <th>Mother Name</th>
                                <th>Place</th>
                                <th>Address</th>
                                <th>Gender</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <?php
                        $a = 1;
                        $query = mysqli_query($mysqli, "select *from `employees` ");
                        while ($row = mysqli_fetch_array($query)) {
                            $originalDate = $row['dateofbirth'];
                            $newDate = date("d-m-Y", strtotime($originalDate));
                            ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="record-checkbox"
                                        data-record-id="<?php echo $row['id']; ?>">
                                </td>

                                <td>
                                    <?php echo $a; ?>
                                </td>
                                <td>
                                    <?php echo $row['name']; ?>
                                </td>
                                <td>
                                    <?php echo $newDate; ?>
                                </td>
                                <td>
                                    <?php echo $row['email']; ?>
                                </td>
                                <td>
                                    <?php echo $row['phone']; ?>
                                </td>
                                <td>
                                    <?php echo $row['father']; ?>
                                </td>
                                <td>
                                    <?php echo $row['mother']; ?>
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
                                    <?php echo $row['description']; ?>
                                </td>
                                <td>
                                    <a href="#samstrover<?php echo $row['id']; ?>" data-toggle="modal"
                                        class="btn btn-warning"><span class="fa fa-eye"></span></a> || <a
                                        href="all_employees.php?edited=1&idx=<?php echo $row['id']; ?>" data-toggle="modal"
                                        class="btn btn-danger"><span class="fa fa-times"></span></a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#downloadBtn').click(function () {
                var selectedRecords = [];
                $('.record-checkbox:checked').each(function () {
                    selectedRecords.push({
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
                    toastr.error('Please select at least one record to download.');
                    return;
                }

                $('#downloadBtn').html('<i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Processing...');

                var pdf = new jsPDF({
                    orientation: 'portrait',
                    unit: 'mm',
                    format: 'a4'
                });

                var yOffset = 30;
                var recordHeight = 250; // Adjust the height as needed
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
                $('#downloadBtn').html('<i class="fa fa-check"></i>&nbsp;&nbsp;Print Success');
                toastr.success('Print success');
                setTimeout(function () {
                    $('#downloadBtn').html('<i class="fa fa-download"></i>&nbsp;&nbsp;Print Records');
                }, 3000);
            });

            function addGrid(pdf, record, yOffset) {
                var xOffsetLeft = 10;
                var xOffsetRight = 70;
                var fontSize = 15;
                var pageWidth = pdf.internal.pageSize.width;
                var headerTitleWidth = pdf.getStringUnitWidth('Criminal Record Informations') * 25 / pdf.internal.scaleFactor;
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
                    ['Name', record.name],
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