<?php
    session_start();

    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'dbpldt';
    
    if(!isset($_SESSION['username'])){
        header("Location:login.php");
	}
	else{
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // ----- insert record
        $ref_no = $_POST['ref_no'];
        $emp_id = $_POST['emp_id'];
        $date_prepared = $_POST['start_time'];
        $name = $_POST['name'];
        $purpose = $_POST['purpose'];
        $accomp_code= $_POST['accomp_code'];
        $cbotype = $_POST['type_of_coe'];
        $control_id = $_POST['control_id'];
        $personal = $_POST['personal'];
        $req_status= $_POST['req_status'];
        $claimersname = $_POST['claimersname'];
        $claimdate= $_POST['claimdate'];

        
        $insert_sql = "INSERT INTO prepared_certificates VALUES
                        ('$ref_no', '$emp_id', '$date_prepared', '$name', '$purpose', '$accomp_code',
                        '$cbotype', '$control_id', '$personal', '$req_status', '$claimersname',
                        '$claimdate')";
        if (!mysqli_query($conn, $insert_sql)) {
            echo "Unable to Process." . "<br>";
            echo("Error description: " . mysqli_error($conn)); 
        }
        else{
            echo "Request Processed.";
        }
        mysqli_close($conn);
        header("refresh:1; url=index.php");
    }

?>