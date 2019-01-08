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