<?php
    $m = date('m');
    $d = date('d');
    $y = date('Y');
    $yy = date('Y') - 1;

    $today = $y . '-' . $m . '-' . $d;
    $last = $y . '-01-01';
    try{
        $servername = 'LAPTOP-KKIP1VTU\SQLEXPRESS';
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];

        $dbname = 'certification';
        $dbname2 = 'HRISData';

        
        $conn = new PDO("sqlsrv:Server=$servername ; Database=$dbname", "$username", "$password");
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $conn->setAttribute( PDO::SQLSRV_ATTR_QUERY_TIMEOUT, 1 ); 

        $conn2 = new PDO("sqlsrv:Server=$servername ; Database=$dbname2", "$username", "$password");
        $conn2->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $conn2->setAttribute( PDO::SQLSRV_ATTR_QUERY_TIMEOUT, 1 ); 
    }
    catch(Exception $e)  
    {   
    die( print_r( $e->getMessage() ) );   
    }


    
?>