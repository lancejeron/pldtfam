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

        // ----- update record
        $emp_id = $_POST['emp_id'];
        $date_prepared = $_POST['date_prepared'];
        $req_status = $_POST['req_status'];
        $ref_no = $_POST['ref_no'];
        $claimersname = $_POST['claimersname'];
        $claimdate = $_POST['claimdate'];
        $returned_status =$_POST['returned_status'];
        $date_returned = $_POST['date_returned'];

        // echo $returned_status;

        function checkreturned_status(){
            $emp_id = $_POST['emp_id'];
        $date_prepared = $_POST['date_prepared'];
        $req_status = $_POST['req_status'];
        $ref_no = $_POST['ref_no'];
        $claimersname = $_POST['claimersname'];
        $claimdate = $_POST['claimdate'];
        $returned_status =$_POST['returned_status'];
        $date_returned = $_POST['date_returned'];
            if($returned_status == 'yes'){
                $update_sql = "UPDATE prepared_certificates SET returned_status = '$returned_status', date_returned='$date_returned' WHERE ref_no ='$ref_no' AND emp_id ='$emp_id' AND date_prepared='$date_prepared'";
                return $update_sql;
            }
            else{
                $update_sql = "UPDATE prepared_certificates SET req_status = '$req_status', claimersname='$claimersname', claimdate='$claimdate', returned_status = '$returned_status' WHERE ref_no ='$ref_no' AND emp_id ='$emp_id' AND date_prepared='$date_prepared'";
                return $update_sql;
            }
        }
        $update_sql2=checkreturned_status();
        if (!mysqli_query($conn, $update_sql2)) {
            echo "Record not updated." . "<br>";
            echo("Error description: " . mysqli_error($conn)); 
        }
        else{
            echo "Record Updated.";
        }
        header("refresh:30; url=index3.php");
    }

?>