<?php
    session_start();

	if(!isset($_SESSION['username'])){
        header("Location:login.php");
	}
	else{
    
        try{
            $servername = 'LAPTOP-KKIP1VTU\SQLEXPRESS';
            $username = '';
            $password = '';
            $dbname = 'certificate';
            
            $conn = new PDO("sqlsrv:Server=$servername ; Database=$dbname", "$username", "$password");
            $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $conn->setAttribute( PDO::SQLSRV_ATTR_QUERY_TIMEOUT, 1 ); 
        
        }
        catch(Exception $e){   
            die( print_r( $e->getMessage() ) );   
        }

        function checkreturned_status(){

            $servername = 'LAPTOP-KKIP1VTU\SQLEXPRESS';
            $username = '';
            $password = '';
            $dbname = 'certificate';
            
            $conn = new PDO("sqlsrv:Server=$servername ; Database=$dbname", "$username", "$password");
            $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $conn->setAttribute( PDO::SQLSRV_ATTR_QUERY_TIMEOUT, 1 ); 


            $emp_id = $_POST['emp_id'];
            $date_prepared = $_POST['date_prepared'];
            $req_status = $_POST['req_status'];
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
                    $update_sql = $conn->prepare("UPDATE prepared_certificates SET returned_status = '$returned_status', date_returned='$date_returned2', req_status = '$req_status', claimersname='$claimersname', claimers_signature='$file_name' WHERE ref_no ='$ref_no' AND emp_id ='$emp_id' AND date_prepared='$date_prepared'");
                    return $update_sql;
                }
                else{
                    $update_sql = $conn->prepare("UPDATE prepared_certificates SET req_status = '$req_status', claimersname='$claimersname', claimdate='$claimdate2', returned_status = '$returned_status', claimers_signature='$file_name'  WHERE ref_no ='$ref_no' AND emp_id ='$emp_id' AND date_prepared='$date_prepared'");
                    return $update_sql;
                }
            }
            else{
                // meron
                if($returned_status == 'yes'){
                    $update_sql = $conn->prepare("UPDATE prepared_certificates SET returned_status = '$returned_status', date_returned='$date_returned2', req_status = '$req_status', claimersname='$claimersname' WHERE ref_no ='$ref_no' AND emp_id ='$emp_id' AND date_prepared='$date_prepared'");
                    return $update_sql;
                }
                else{
                    $update_sql = $conn->prepare("UPDATE prepared_certificates SET req_status = '$req_status', claimersname='$claimersname', claimdate='$claimdate2', returned_status = '$returned_status' WHERE ref_no ='$ref_no' AND emp_id ='$emp_id' AND date_prepared='$date_prepared'");
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