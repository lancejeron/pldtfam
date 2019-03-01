<?php
    require '../connection_static.php';

    $request = $_POST["query"];
    $request2 = $_POST["query2"];

    if($request != NULL ){
        $query = $conn2->prepare("SELECT TOP 1 IDNo FROM vw_coe_employee WHERE Name LIKE '$request'");
        $query -> execute();
        $result = $query -> fetchAll();
        
        $data = array();
        
        foreach($result as $row){
            $data[] = $row["IDNo"];
        }
        echo json_encode($data);
    }
    else{
        echo json_encode('');
    }
?>