<?php
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'dbpldt';
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // ----- update record
    $emp_id = $_POST['emp_id'];
    $date_prepared = $_POST['date_prepared'];
    $req_status = $_POST['req_status'];
    $ref_no = $_POST['ref_no'];
    $claimersname = $_POST['claimersname'];
    $claimdate = $_POST['claimdate'];
    
    $update_sql = "UPDATE prepared_certificates SET req_status = '$req_status', claimersname='$claimersname', claimdate='$claimdate' WHERE ref_no ='$ref_no' AND emp_id ='$emp_id' AND date_prepared='$date_prepared'";
    if (!mysqli_query($conn, $update_sql)) {
        echo "Record not updated." . "<br>";
        echo("Error description: " . mysqli_error($conn)); 
    }
    else{
        echo "Record Updated.";
    }
    header("refresh:1; url=index3.php");

?>