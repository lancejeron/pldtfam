<?php


    require 'template/connection_static.php';

    // ----- insert record
    $persno = $_POST['persno'];
    $emp_name = $_POST['emp_name'];
    $start_time = $_POST['start_time'];
    $type_of_coe = $_POST['type_of_coe'];
    $purpose = $_POST['purpose'];
    $salary = $_POST['salary'];

    $start_time2=date("Y-m-d H:i:s", strtotime($start_time));


    $insert_sql=$conn->prepare("INSERT INTO view_coe_request VALUES ('$start_time2', '', '$emp_name', '$type_of_coe', '$purpose', '$salary', NULL, NULL, NULL, NULL, NULL, '$persno', NULL, NULL, 'Walk-in', 0)");
    // $insert_sql->execute();
    if (!$insert_sql->execute()) {
        echo("invalid");
    }
    else{
        echo("success");
    }
    header("refresh:0; url=user_coe_request.php");

?>