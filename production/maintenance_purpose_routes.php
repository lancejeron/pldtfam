<?php
    require 'template/connection.php';

    $btn1 = $_POST['btn1'];
    if($btn1 == 'Add'){
        $purpose_name = $_POST['purpose_name'];
        $purpose_type = $_POST['purpose_type'];
        $purpose_salary = $_POST['purpose_salary'];

        $check_purpose = $conn->prepare("SELECT COUNT(*) AS x FROM tblmpurpose WHERE purpose_name IN ('$purpose_name') OR purpose_name LIKE '%$purpose_name%'");
        $check_purpose -> execute();

        $rows = $check_purpose->fetchAll();
        foreach($rows as $row){
            if($row['x']>0){
                // echo 'record already exists';
                echo 'already exists';
            }
            else{
                $add_purpose = $conn->prepare("INSERT INTO tblmpurpose (purpose_name, purpose_status, purpose_type, purpose_salary) VALUES ('$purpose_name','active', '$purpose_type', '$purpose_salary')");
                $add_purpose -> execute();
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

        $edit_purpose= $conn->prepare("UPDATE tblmpurpose SET purpose_name='$purpose_name', purpose_status='$purpose_status', purpose_type='$purpose_type', purpose_salary='$purpose_salary' WHERE purpose_id = '$purpose_id'");
        // $edit_purpose->execute();
        if (!$edit_purpose->execute()) {
            echo 'error';
        }
        else{
            echo 'success';
        }
    }
    else if($btn1 == 'Delete') {
        $purpose_id = $_POST['purpose_ID2'];

        $delete_purpose = $conn->prepare("DELETE FROM tblmpurpose WHERE purpose_id='$purpose_id'");
        if (!$delete_purpose->execute()) {        
            echo 'error';
        }
        else{
            echo 'success';
        }
    }
?>