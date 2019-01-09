<?php
    session_start();

	if(!isset($_SESSION['username'])){
        header("Location:login.php");
	}
	else{
        require 'template/connection.php';

        // create record
        $persno= $_POST["persno"];
        $start_time= $_POST["start_time"];
        $purpose = $_POST["purpose"];
        $type_of_cert = $_POST["type_of_cert"];
        $ref_no = $_POST["ref_no"];

        $create_cert_que = $conn->prepare("INSERT INTO prepared_certificates (ref_no, date_prepared, emp_id, purpose) VALUES ('$ref_no', '$start_time', '$persno','$purpose')");
        if (!$create_cert_que->execute()) {
            echo 'error';
        }
        else{

            header('Location: request.php?emp_id='.$persno.'&start_time='.$start_time.'');
        }
    }
?>