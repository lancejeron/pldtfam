<?php


	$servername = 'localhost';
	$username = 'root';
	$password = '';
	$dbname = 'certificate';

    
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // ----- insert record
    $emp_id = $_POST['emp_id'];
    $emp_name = $_POST['emp_name'];
    $start_time = $_POST['start_time'];
    $type_of_coe = $_POST['type_of_coe'];
    $purpose = $_POST['purpose'];

    $insert_sql="INSERT INTO view_coe_request VALUES ('$start_time', '', '$emp_name', '$type_of_coe', '$purpose', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$emp_id')";
    if (!mysqli_query($conn, $insert_sql)) {

        // echo("Error description: " . mysqli_error($conn));
        // echo("invalid");
        // $response_array['status'] = 'invalid';
        // header("refresh:5; url=user_coe_request.php");
    }
    else{
        // echo "Request Submitted! Please inform the staff that you had successfully submitted your request." . "<br>";
        // echo("success");
        // $response_array['status'] = 'success'; 
        // header("refresh:5; url=user_coe_request.php");
    }
    // header("refresh:5; url=user_coe_request.php");

?>