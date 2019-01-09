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
            $update_query = $conn->prepare("UPDATE view_coe_request SET req_status=1 WHERE start_time='$start_time' AND persno='$persno'");
            if (!$update_query->execute()) {
                echo "Record not updated." . "<br>";

            }
            else{
                // echo "Record Updated.";
                // echo($file_name);
            }
        }
        else{
            $update_query = $conn->prepare("UPDATE view_coe_request SET req_status=0 WHERE start_time='$start_time' AND persno='$persno'");
            if (!$update_query->execute()) {
                echo "Record not updated." . "<br>";
            }
            else{
                // echo "Record Updated.";
                // echo($file_name);
            }

        }
    }
?>