<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<div class="modal fade" id="samstrover<?php echo $row['id']; ?>" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center>
                    <h4 class="modal-title" id="myModalLabel">Criminal Information</h4>
                </center>
                <?php
                if ($_SESSION['permission'] == 1) {
                    ?>
                    <button type="button" class="btn btn-primary edit-btn"
                        data-target="#samstrover<?php echo $row['id']; ?>">
                        Edit
                    </button>
                <?php } ?>
            </div>

            <?php
            $pro = mysqli_query($mysqli, "select * from employees where id='" . $row['id'] . "'");
            $prow = mysqli_fetch_array($pro);
            $tmp = $prow['tmp'];
            ?>
            <div class="row">
                <p class="text-center" style="color:black;font-weight:bold;">Criminal Id:
                    <?php echo $prow['employee_id']; ?>
                </p>
                <div class="col-md-4">
                </div>
                <div class="col-md-4 text-center">
                    <a class="img-thumbnail">
                        <?php require('propic.php'); ?>
                    </a>
                </div>
                <div class="col-md-4"></div>
            </div>
            <form id="criminalForm">
                <input type="hidden" name="id" value="<?php echo $prow['id']; ?>">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <label>Name</label>
                            <input name="name" type="text" class="form-control" value="<?php echo $prow['name']; ?>"
                                readonly>
                        </div>
                        <div class="col-md-6">
                            <label>DOB</label>
                            <input name="dateofbirth" type="date" class="form-control"
                                value="<?php echo $prow['dateofbirth']; ?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Email</label>
                            <input name="email" type="text" class="form-control" value="<?php echo $prow['email']; ?>"
                                readonly>
                        </div>
                        <div class="col-md-6">
                            <label>Phone</label>
                            <input name="phone" type="text" class="form-control" value="<?php echo $prow['phone']; ?>"
                                readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Father Name</label>
                            <input name="father" type="text" class="form-control" value="<?php echo $prow['father']; ?>"
                                readonly>
                        </div>
                        <div class="col-md-6">
                            <label>Mother Name</label>
                            <input name="mother" type="text" class="form-control" value="<?php echo $prow['mother']; ?>"
                                readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Gender</label>
                            <input name="gender" type="text" class="form-control" value="<?php echo $prow['gender']; ?>"
                                readonly>
                        </div>
                        <div class="col-md-6">
                            <label>Place</label>
                            <input name="place" type="text" class="form-control" value="<?php echo $prow['place']; ?>"
                                readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Address</label>
                            <input name="address" type="text" class="form-control"
                                value="<?php echo $prow['address']; ?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Description</label>
                            <input name="description" type="textarea" class="form-control"
                                value="<?php echo $prow['description']; ?>" readonly>
                        </div>
                    </div>
                    <div class="line"></div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="updateButton"
                            style="display: none;">Update</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
    $(document).ready(function () {
        var modalId;

        $(".edit-btn").off("click").on("click", function () {
            modalId = $(this).attr("data-target");
            $(modalId + " input[readonly]").prop("readonly", false);
            $(modalId + " #updateButton").show();
        });

        $("#criminalForm").off("submit").on("submit", function (event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "criminalupdatecode.php",
                data: formData,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    $(modalId).modal("hide");

                    if (response.status === 'success') {
                        toastr.success('Record updated successfully');
                    } else {
                        toastr.error('Failed to update record');
                    }
                },
                error: function (error) {
                    console.error(error);
                    toastr.error('Failed to update record');
                },
                complete: function () {
                    setTimeout(function () {
                        window.location.reload(true);
                    }, 1000);
                }
            });
        });
    });
</script>