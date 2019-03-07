<?php

    session_start();
    require 'template/connection.php';

    if(!isset($_SESSION['username'])){
        header("Location:login.php");
    }
    else{
        // ----- insert record
        $persno = $_POST['persno'];
        $emp_name = $_POST['emp_name'];
        $start_time = $_POST['start_time'];
        $type_of_coe = $_POST['type_of_coe'];
        $purpose = $_POST['purpose'];
        $salary = $_POST['salary'];
    
        $start_time2=date("Y-m-d H:i:s", strtotime($start_time));
    
    
        $insert_sql=$conn->prepare("INSERT INTO view_coe_request_walkin VALUES ('$start_time2', '', '$emp_name', '$type_of_coe', '$purpose', '$salary', NULL, NULL, 'Myself', NULL, NULL, '$persno', NULL, NULL)");
        // $insert_sql->execute();
        if (!$insert_sql->execute()) {
            echo("invalid");
        }
        else{
            echo("success");
        }
        header("refresh:0; url=user_coe_request.php");
    }


?>