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

        // echo $returned_status;
        $btn1 = $_POST["btn1"];
        $start_time = $_POST["start_time"];
        $persno = $_POST["persno"];

        if($btn1 == 'finish'){
            $update_query = "UPDATE view_coe_request SET req_status=1 WHERE start_time='$start_time' AND persno='$persno'";
            if (!mysqli_query($conn, $update_query)) {
                echo "Record not updated." . "<br>";
                echo("Error description: " . mysqli_error($conn)); 
            }
            else{
                // echo "Record Updated.";
                // echo($file_name);
            }
        }
        else{
            $update_query = "UPDATE view_coe_request SET req_status=0 WHERE start_time='$start_time' AND persno='$persno'";
            if (!mysqli_query($conn, $update_query)) {
                echo "Record not updated." . "<br>";
                echo("Error description: " . mysqli_error($conn)); 
            }
            else{
                // echo "Record Updated.";
                // echo($file_name);
            }

        }
    }
?>