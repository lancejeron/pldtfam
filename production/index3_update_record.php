<?php
    session_start();

	if(!isset($_SESSION['username'])){
        header("Location:login.php");
	}
	else{

        function checkreturned_status(){

            require 'template/connection.php';

            $emp_id = $_POST['emp_id'];
            $req_date = $_POST['req_date'];
            $cert_status = $_POST['cert_status'];
            $ref_no = $_POST['ref_no'];
            $claimersname = $_POST['claimersname'];
            $claimdate = $_POST['claimdate'];
            $returned_status =$_POST['returned_status'];
            $date_returned = $_POST['date_returned'];
            $claimersign = $_POST['claimersign'];

            // 
            $result = array();
            $imagedata = base64_decode($_POST['claimers_signature']);
            $filename = md5(date("dmYhisA"));
            //Location to where you want to created sign image
            $file_name = $filename.'.png';
            $result['status'] = 1;
            $result['file_name'] = $file_name;

            $claimdate2=date("Y-m-d H:i:s", strtotime($claimdate));
            $date_returned2=date("Y-m-d H:i:s", strtotime($date_returned));

            // echo($imagedata);
            // 
            if($_POST['claimers_signature']==''){
                // wala pangpirma
                if($returned_status == 'yes'){
                    $update_sql = $conn->prepare("UPDATE prepared_certificates SET returned_status = '$returned_status', date_returned='$date_returned2', cert_status = '$cert_status', claimersname='$claimersname', claimers_signature='$file_name' WHERE ref_no ='$ref_no'");
                    return $update_sql;
                }
                else{
                    $update_sql = $conn->prepare("UPDATE prepared_certificates SET cert_status = '$cert_status', claimersname='$claimersname', claimdate='$claimdate2', returned_status = '$returned_status', claimers_signature='$file_name'  WHERE ref_no ='$ref_no'");
                    return $update_sql;
                }
            }
            else{
                // meron
                if($returned_status == 'yes'){
                    $update_sql = $conn->prepare("UPDATE prepared_certificates SET returned_status = '$returned_status', date_returned='$date_returned2', cert_status = '$cert_status', claimersname='$claimersname' WHERE ref_no ='$ref_no'");
                    return $update_sql;
                }
                else{
                    $update_sql = $conn->prepare("UPDATE prepared_certificates SET cert_status = '$cert_status', claimersname='$claimersname', claimdate='$claimdate2', returned_status = '$returned_status' WHERE ref_no ='$ref_no'");
                    return $update_sql;
                }

            }
        }
        $update_sql2=checkreturned_status();
        if (!$update_sql2->execute()) {
            echo "Record not updated." . "<br>";
        }
        else{
            echo "Record Updated.";
        }
    }
?>