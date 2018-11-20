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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel ="stylesheet" href = "https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css"/>
    <script src='https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js'></script>
    <script src='https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js'></script>

    <link rel ="stylesheet" href = "assets/css/style.css"/>

</head>
<body>
    <h1 > COE Request </h1>
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
                            <td>' . '<input class="favorite styled" id="btn1" type="button" value="Edit" data-toggle="modal" data-target="#modal1">' . '</td>
                        </tr>
                        ';
                    }
                ?>
            </table>
        </div>
    </div>

    <!-- MODAL -->
    <div id="modal1" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Some text in the Modal..</p>
        </div>

    </div>
</body>

</html>
<script>
    $(document).ready(function() {
        $('#mydatatable').DataTable();
    });
</script>
<script>
// Get the modal
var modal = document.getElementById('modal1');

// Get the button that opens the modal
var btn = document.getElementById("btn1");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>