<?php
	$servername = 'localhost';
	$username = 'root';
	$password = '';
	$dbname = 'certificate';

    
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $btn1 = $_POST['btn1'];
    if($btn1 == 'Add'){
        $purpose_name = $_POST['purpose_name'];
        $purpose_type = $_POST['purpose_type'];
        $purpose_salary = $_POST['purpose_salary'];

        $add_purpose =  "INSERT INTO tblmpurpose (purpose_name, purpose_status, purpose_type, purpose_salary) VALUES ('$purpose_name','active', '$purpose_type', '$purpose_salary')";
        $check_purpose = "SELECT COUNT(*) AS x FROM tblmpurpose WHERE purpose_name IN ('$purpose_name') OR purpose_name LIKE '%$purpose_name%'";
        
        $result = mysqli_query($conn,$check_purpose);
        $row = mysqli_fetch_assoc($result);
        if($row['x']>0){
            // echo 'record already exists';
            echo 'already exists';
        }
        else{
            if (!mysqli_query($conn, $add_purpose)) {
                // echo("Error description: " . mysqli_error($conn));
                // header("refresh:1.5; url=maintenance_purpose.php");
            }
            else{
                echo 'success';
            }
        }
        
    }
    else if ($btn1 == 'Edit') {
        $purpose_id = $_POST['purpose_id'];
        $purpose_name = $_POST['purpose_name'];
        $purpose_status = $_POST['purpose_status'];
        $purpose_type = $_POST['purpose_type'];
        $purpose_salary = $_POST['purpose_salary'];

        $edit_purpose= "UPDATE tblmpurpose SET purpose_name='$purpose_name', purpose_status='$purpose_status', purpose_type='$purpose_type', purpose_salary='$purpose_salary' WHERE purpose_id = '$purpose_id'";
        if (!mysqli_query($conn, $edit_purpose)) {
            // echo("Error description: " . mysqli_error($conn));
            // header("refresh:1.5; url=maintenance_purpose.php");
        }
        else{
            // echo "Record updated.";
            // header("refresh:0; url=maintenance_purpose.php");
        }
    }
    else if($btn1 == 'Delete') {
        $purpose_id = $_POST['purpose_ID2'];

        $delete_purpose = "DELETE FROM tblmpurpose WHERE purpose_id='$purpose_id'";
        if (!mysqli_query($conn, $delete_purpose)) {
            // echo("Error description: " . mysqli_error($conn));
            // header("refresh:1.5; url=maintenance_purpose.php");
        }
        else{
            // echo "Record deleted.";
            // header("url=maintenance_purpose.php");
        }
    }
    // header("refresh:0; url=maintenance_purpose.php");
?>