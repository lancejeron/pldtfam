<?php
    session_start();
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "date_prepared2";
    $ddate = $_GET["ddate"];
    $ddate2 = $_GET["ddate2"];

    /* DB table to use */
    $sTable = "(SELECT prepared_certificates.*, CONVERT(VARCHAR(23), claimdate, 126) AS claimdate3, CONVERT(VARCHAR(19), claimdate, 120) AS claimdate2, CONVERT(VARCHAR(23), date_returned, 126) AS date_returned3, CONVERT(VARCHAR(19), date_prepared, 120) AS date_prepared2, CONVERT(VARCHAR(19), req_date, 120) AS req_date2 FROM prepared_certificates INNER JOIN view_coe_request ON start_time = req_date
    WHERE (date_prepared BETWEEN '$ddate' AND '$ddate2 23:59:59') AND (req_date=start_time OR prepared_certificates.purpose=view_coe_request.purpose) ) AS v1";

    /* Database connection information */
    require '../connection_gasql.php';

    /*
    * Columns
    * If you don't want all of the columns displayed you need to hardcode $aColumns array with your elements.
    * If not this will grab all the columns associated with $sTable
    */
    $aColumns = array("date_prepared2", "emp_id", "ref_no", "req_date2", "name", "purpose", "accomp_code", "cbotype","control_id", "personal", "cert_status", "claimdate2");

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

    $sQuery2 = "SELECT * FROM (SELECT prepared_certificates.*, CONVERT(VARCHAR(23), claimdate, 126) AS claimdate3, CONVERT(VARCHAR(19), claimdate, 120) AS claimdate2, CONVERT(VARCHAR(23), date_returned, 126) AS date_returned3, CONVERT(VARCHAR(19), date_prepared, 120) AS date_prepared2, CONVERT(VARCHAR(19), req_date, 120) AS req_date2 FROM prepared_certificates INNER JOIN view_coe_request ON start_time = req_date
                WHERE (date_prepared BETWEEN '$ddate' AND '$ddate2 23:59:59') AND (req_date=start_time OR prepared_certificates.purpose=view_coe_request.purpose) ) AS v1 ORDER BY date_prepared DESC";
    $rResult2 = sqlsrv_query($gaSql['link'],$sQuery2) or die("$sQuery2: " . sqlsrv_errors());
    $aColumns2 = array("date_prepared", "claimersname","req_date", "returned_status", "date_returned3", "claimers_signature", "claimdate3");
    
    $act = 'Action';
    $aColumns[]=$act;

    while ( ($aRow = sqlsrv_fetch_array( $rResult ))  && ($aRow2 = sqlsrv_fetch_array($rResult2))) {
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
            if($aColumns[$i] == 'Action'){
                $v = '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#view_certificate",
                data-ref_no="'.$aRow[$aColumns[2]].'"><i class="fa fa-eye"></i> View</button>
            
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target=".bs-example-modal-lg", 
                data-ref_no="'.$aRow[$aColumns[2]].'" data-emp_id="'.$aRow[$aColumns[1]].'"
                data-date_prepared2="'.$aRow[$aColumns[0]].'"
                data-date_prepared="'.$aRow2[$aColumns2[0]].'"
                data-req_date="'.$aRow2[$aColumns2[2]].'"
                data-name="'.$aRow[$aColumns[4]].'"
                data-purpose="'.$aRow[$aColumns[5]].'"
                data-accomp_code="'.$aRow[$aColumns[6]].'"
                data-cbotype="'.$aRow[$aColumns[7]].'"
                data-control_id="'.$aRow[$aColumns[8]].'"
                data-personal="'.$aRow[$aColumns[9]].'"
                data-cert_status="'.$aRow[$aColumns[10]].'"
                data-claimersname="'.$aRow2[$aColumns2[1]].'"
                data-returned_status="'.$aRow2[$aColumns2[3]].'"
                data-date_returned="'.$aRow2[$aColumns2[4]].'"
                data-claimers_signature="'.$aRow2[$aColumns2[5]].'"
                data-claimdate="'.$aRow2[$aColumns2[6]].'"
                "><i class="glyphicon glyphicon-edit"></i> Edit</button>';
                $row[]=$v;
            }
            else{
                $v = $aRow[ $aColumns[$i] ];
                $v = mb_check_encoding($v, 'UTF-8') ? $v : utf8_encode($v);
                $row[]=$v;
            }
        }
        If (!empty($row)) { $output['aaData'][] = $row; }
    }   
    echo json_encode( $output );
?>