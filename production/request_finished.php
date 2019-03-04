<?php
    session_start();

	if(!isset($_SESSION['username'])){
        header("Location:login.php");
	}
	else{
    
        require 'template/connection.php';

        $btn1 = $_POST["btn1"];
        $start_time = $_POST["start_time"];
        $persno = $_POST["persno"];

        if($btn1 == 'finish'){
            $update_query = $conn->prepare("UPDATE prepared_certificates SET req_status=1 WHERE req_date='$start_time'");
            if (!$update_query->execute()) {
                echo "Record not updated." . "<br>";

            }
            else{
                // echo "Record Updated.";
            }
        }
        else{
            $update_query = $conn->prepare("UPDATE prepared_certificates SET req_status=0 WHERE req_date='$start_time'");
            if (!$update_query->execute()) {
                echo "Record not updated." . "<br>";
            }
            else{
                // echo "Record Updated.";
            }

        }
    }
?>