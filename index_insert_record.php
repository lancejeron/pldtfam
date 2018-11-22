<?php
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'dbpldt';
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // ----- insert record
    $req_status = $_POST['req_status'];
    $ref_no = $_POST['ref_no'];
    $claimersname = $_POST['claimersname'];
    $claimdate = $_POST['claimdate'];
    
    $insert_sql = "";
    $insert_sql_result = mysqli_query($conn, $insert_sql);
    if (!mysqli_query($conn, $insert_sql)) {
        echo "Record not updated." . "<br>";
        echo "error:". $php_errormsg;
    }
    else{
        echo "Record Updated.";
    }
    header("refresh:1; url=index2.php");

?>