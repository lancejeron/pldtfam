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

        // create record
        $persno= $_POST["persno"];
        $start_time= $_POST["start_time"];
        $purpose = $_POST["purpose"];
        $type_of_cert = $_POST["type_of_cert"];

        $create_cert_que = "INSERT INTO prepared_certificates (date_prepared, emp_id, purpose) VALUES ('$start_time', '$persno','$purpose')";
        if (!mysqli_query($conn, $create_cert_que)) {
            echo 'error';
        }
        else{

            header("Location: index.php");
        }
    }
?>