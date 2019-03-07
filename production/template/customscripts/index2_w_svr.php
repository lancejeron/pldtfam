<?php
    session_start();
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "start_time2";
    $ddate = $_GET["ddate"];
    $ddate2 = $_GET["ddate2"];

    /* DB table to use */
    $sTable = "(SELECT *, CONVERT(VARCHAR(19), start_time, 120) AS start_time2 FROM view_coe_request_walkin INNER JOIN (SELECT req_date FROM prepared_certificates WHERE req_status IN (1) group by req_date) as tbl2 ON tbl2.req_date = start_time  WHERE start_time BETWEEN '$ddate' AND '$ddate2  23:59:59') as v1";

    /* Database connection information */
    require '../connection_gasql.php';

    /*
    * Columns
    * If you don't want all of the columns displayed you need to hardcode $aColumns array with your elements.
    * If not this will grab all the columns associated with $sTable
    */
    $aColumns = array("start_time2", "persno", "email", "emp_name", "type_of_coe", "purpose", "_salary", "question1", "statement", "reqt_for", "reqt_for_name", "position_title", "MMprov", "other_instructions");


    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * If you just want to use the basic configuration for DataTables with PHP server-side, there is
     * no need to edit below this line
     */

    /*
     * ODBC connection
     */
    $connectionInfo = array("UID" => $gaSql['user'], "PWD" => $gaSql['password'], "Database"=>$gaSql['db'],"ReturnDatesAsStrings"=>true);
    $gaSql['link'] = sqlsrv_connect( $gaSql['server'], $connectionInfo);
    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );


    /* Ordering */
    $sOrder = "";
    if ( isset( $_GET['iSortCol_0'] ) ) {
        $sOrder = "ORDER BY  ";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) {
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) {
                $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                    ".addslashes( $_GET['sSortDir_'.$i] ) .", ";
            }
        }
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" ) {
            $sOrder = "";
        }
    }

    /* Filtering */
    $sWhere = "";
    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
        $sWhere = "WHERE (";
        for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
            $sWhere .= $aColumns[$i]." LIKE '%".addslashes( $_GET['sSearch'] )."%' OR ";
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
    }
    /* Individual column filtering */
    for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
        if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )  {
            if ( $sWhere == "" ) {
                $sWhere = "WHERE ";
            } else {
                $sWhere .= " AND ";
            }
            $sWhere .= $aColumns[$i]." LIKE '%".addslashes($_GET['sSearch_'.$i])."%' ";
        }
    }

    /* Paging */
    $top = (isset($_GET['iDisplayStart']))?((int)$_GET['iDisplayStart']):0 ;
    $limit = (isset($_GET['iDisplayLength']))?((int)$_GET['iDisplayLength'] ):10;
    $sQuery = "SELECT TOP $limit ".implode(",",$aColumns)."
        FROM $sTable
        $sWhere ".(($sWhere=="")?" WHERE ":" AND ")." $sIndexColumn NOT IN
        (
            SELECT $sIndexColumn FROM
            (
                SELECT TOP $top ".implode(",",$aColumns)."
                FROM $sTable
                $sWhere
                $sOrder
            )
            as [virtTable]
        )
        $sOrder";

    $rResult = sqlsrv_query($gaSql['link'],$sQuery) or die("$sQuery: " . sqlsrv_errors());

    $sQueryCnt = "SELECT * FROM $sTable $sWhere";
    $rResultCnt = sqlsrv_query( $gaSql['link'], $sQueryCnt ,$params, $options) or die (" $sQueryCnt: " . sqlsrv_errors());
    $iFilteredTotal = sqlsrv_num_rows( $rResultCnt );

    $sQuery = " SELECT * FROM $sTable ";
    $rResultTotal = sqlsrv_query( $gaSql['link'], $sQuery ,$params, $options) or die(sqlsrv_errors());
    $iTotal = sqlsrv_num_rows( $rResultTotal );

    $output = array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" => array()
    );

    $act = 'Action';
    $aColumns[]=$act;
    while ( $aRow = sqlsrv_fetch_array( $rResult ) ) {
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
            if($aColumns[$i] == 'Action'){
                $v = "<a href='request_w.php?emp_id=".$aRow[$aColumns[1]]."&start_time=".$aRow[$aColumns[0]]."'><button type='button' class='btn btn-info'>View</button></a>";
                $row[]=$v;
            }
            else{
                $v = $aRow[ $aColumns[$i] ];
                $v = mb_check_encoding($v, 'UTF-8') ? $v : utf8_encode($v);
                $row[]=$v;
            }
        }
        If (!empty($row)) {
             $output['aaData'][] = $row; 
            }
    }   
    echo json_encode( $output );
?>