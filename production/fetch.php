<?php
    //fetch.php
    require 'template/connection_static.php';
    $emp_name= $_POST["emp_name"];
    $req = $conn2->prepare("SELECT * FROM vw_coe_employee WHERE Name LIKE '%".$emp_name."%'");
    $req ->execute();
    $req_res = $req->fetchAll();


    $data = array();

    if(mssql_num_rows($req)>0){
        foreach($req_res as $row){
            $data[]=$row["Name"];
        }
        echo json_encode($data);
    }

?>