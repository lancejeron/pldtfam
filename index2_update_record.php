<?php
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'dbpldt';
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // ----- update record
    $req_status = $_POST['req_status'];
    $ref_no = $_POST['ref_no'];
    $claimersname = $_POST['claimersname'];
    $claimdate = $_POST['claimdate'];
    
    $update_sql = "UPDATE tblpreparedcert SET req_status = '$req_status', claimersname='$claimersname', claimdate='$claimdate' WHERE ref_no ='$ref_no'";
    $update_sql_result = mysqli_query($conn, $update_sql);
    if (!mysqli_query($conn, $update_sql)) {
        echo "Record not updated." . "<br>";
        echo "error:". $php_errormsg;
    }
    else{
        echo "Processed Request Updated.";
    }
    header("refresh:1; url=index2.php");

?>