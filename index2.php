<?php
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'dbpldt';
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $sql = 'SELECT * FROM tblpreparedcert';
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "Error:". mysqli_error($conn);
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>COE Request</title>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- <link rel ="stylesheet" href = "https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css"/>
    <script src='https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js'></script>
    <script src='https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js'></script> -->
    <!-- Datatables -->
    <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="vendors/jszip/dist/jszip.min.js"></script>
    <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="vendors/pdfmake/build/vfs_fonts.js"></script>
    
    <!-- <link rel ="stylesheet" href = "assets/css/style.css"/> -->
    
</head>
<body>
    <h1><center> COE Request </center></h1>
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Large modal</button> -->
    <div class='container'>
        <div class='table-responsive'>
            <table id='mydatatable' class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th>Reference No.</th>
                        <th>Employee ID </th>
                        <th>Date Prepared</th>
                        <th>Name</th>
                        <th>Purpose</th>
                        <th>Accomp Code</th>
                        <th>CBO Type</th>
                        <th>Control ID</th>
                        <th>Personal</th>
                        <th>Status</th>
                        <th>Claimers Name</th>
                        <th>Claim Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php
                    while($row = mysqli_fetch_array($result)){
                        echo '
                        <tr>
                            <td>' . $row["ref_no"] . '</td>
                            <td>' . $row["emp_id"] . '</td>
                            <td>' . $row["date_prepared"] . '</td>
                            <td>' . $row["name"] . '</td>
                            <td>' . $row["purpose"] . '</td>
                            <td>' . $row["accomp_code"] . '</td>
                            <td>' . $row["cbotype"] . '</td>
                            <td>' . $row["control_id"] . '</td>
                            <td>' . $row["personal"] . '</td>
                            <td>' . $row["req_status"] . '</td>
                            <td>' . $row["claimersname"] . '</td>
                            <td>' . $row["claimdate"] .'</td>
                            <td>' . '<button type="button" class="btn btn-warning" data-toggle="modal" data-target=".bs-example-modal-lg" , data-id="'.$row['emp_id'].'">Edit</button>' . '</td>
                        </tr>
                        ';
                    }
                ?>
            </table>
        </div>
    </div>

<!-- MODAL -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Process Request</h4>
      </div>
      <div class="modal-body">
        <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="_id" required="required" class="form-control col-md-7 col-xs-12">
            </div>
            </div>
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="last-name" name="last-name" required="required" class="form-control col-md-7 col-xs-12">
            </div>
            </div>
            <div class="form-group">
            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Middle Name / Initial</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" name="middle-name">
            </div>
            </div>
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div id="gender" class="btn-group" data-toggle="buttons">
                <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                    <input type="radio" name="gender" value="male"> &nbsp; Male &nbsp;
                </label>
                <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                    <input type="radio" name="gender" value="female"> Female
                </label>
                </div>
            </div>
            </div>
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Of Birth <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="birthday" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
            </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button class="btn btn-primary" type="button">Cancel</button>
                <button class="btn btn-primary" type="reset">Reset</button>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
            </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>

    </div>
  </div>
</div>

<!-- jQuery -->
<script src="vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Datatables -->
<script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
</body>

</html>
<script>
    $(document).ready(function() {
        $('#mydatatable').DataTable();
    });
    $('.bs-example-modal-lg').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('name')
        var day = button.data('day')
        var leavefileday = button.data('leavefileday')

        var modal = $(this)
        modal.find('.modal-body #_id').val(id)
        modal.find('.modal-body #_name').val(name)
        modal.find('.modal-body #_day').val(day)
        modal.find('.modal-body #_leavefileday').val(leavefileday)
    });
</script>