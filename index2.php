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
                            <td>' . '<button type="button" class="btn btn-warning" data-toggle="modal" data-target=".bs-example-modal-lg">Edit</button>' . '</td>
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
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <h4>Text in a modal</h4>
        <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
        <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
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
</script>