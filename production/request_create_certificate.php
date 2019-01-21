<?php
    session_start();

	if(!isset($_SESSION['username'])){
        header("Location:login.php");
	}
	else{
        require 'template/connection.php';

        // create record
        $persno= $_POST["persno"];
        date_default_timezone_set('Asia/Manila');
        $date_prepared= date('Y-m-d H:i:s', time());
        $start_time= $_POST["start_time"];
        $purpose = $_POST["purpose"];
        $type_of_cert = $_POST["type_of_cert"];
        $ref_no = $_POST["ref_no"];


        $create_cert_que = $conn->prepare("INSERT INTO prepared_certificates (ref_no, date_prepared, emp_id, purpose, req_date, req_status) VALUES ('$ref_no', '$date_prepared', '$persno','$purpose', '$start_time', 0)");
        if (!$create_cert_que->execute()) {
            echo 'error';
        }
        else{

            header('Location: request.php?emp_id='.$persno.'&start_time='.$start_time.'');
        }
    }
?>