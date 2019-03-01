<?php
require '../connection_static.php';

$request = $_POST["query"];
$request2 = $_POST["query2"];
if($request!=NULL && $request2==NULL){
    $query = $conn2->prepare("SELECT Name FROM vw_coe_employee WHERE name LIKE '$request%'");
    $query -> execute();
    $result = $query -> fetchAll();
    
    $data = array();
    
    foreach($result as $row){
        $data[] = $row["Name"];
    }
     echo json_encode($data);
}
else{
    $query = $conn2->prepare("SELECT IDNo FROM vw_coe_employee WHERE IDNo LIKE '$request2%'");
    $query -> execute();
    $result = $query -> fetchAll();
    
    $data = array();
    
    foreach($result as $row){
        $data[] = $row["IDNo"];
    }
     echo json_encode($data);
}



?>