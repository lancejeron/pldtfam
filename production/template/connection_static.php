<?php
    try{
        $servername = 'LAPTOP-KKIP1VTU\SQLEXPRESS';
        $username = "";
        $password = "";
        $dbname = 'certificate';
        
        $conn = new PDO("sqlsrv:Server=$servername ; Database=$dbname", "$username", "$password");
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $conn->setAttribute( PDO::SQLSRV_ATTR_QUERY_TIMEOUT, 1 ); 
    }
    catch(Exception $e)  
    {   
    die( print_r( $e->getMessage() ) );   
    }
?>