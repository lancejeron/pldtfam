<?php
    session_start();

	$servername = 'localhost';
	$username = 'root';
	$password = '';
	$dbname = 'certificate';

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

        $result = array();
        $imagedata = base64_decode($_POST['claimersign']);
        $filename = md5(date("dmYhisA"));
        //Location to where you want to created sign image
        $file_name = $filename.'.png';
        $result['status'] = 1;
        $result['file_name'] = $file_name;

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
            // 
            $result = array();
            $imagedata = base64_decode($_POST['claimersign']);
            $filename = md5(date("dmYhisA"));
            //Location to where you want to created sign image
            $file_name = $filename.'.png';
            $result['status'] = 1;
            $result['file_name'] = $file_name;

            // echo($imagedata);
            // 
            if($returned_status == 'yes'){
                $update_sql = "UPDATE prepared_certificates SET returned_status = '$returned_status', date_returned='$date_returned', req_status = '$req_status', claimersname='$claimersname', claimers_signature='$file_name' WHERE ref_no ='$ref_no' AND emp_id ='$emp_id' AND date_prepared='$date_prepared'";
                return $update_sql;
                // echo($imagedata);
            }
            else{
                $update_sql = "UPDATE prepared_certificates SET req_status = '$req_status', claimersname='$claimersname', claimdate='$claimdate', returned_status = '$returned_status', claimers_signature='$file_name'  WHERE ref_no ='$ref_no' AND emp_id ='$emp_id' AND date_prepared='$date_prepared'";
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
            echo($file_name);
        }
        // header("refresh:10000; url=index3.php");
    }
?>