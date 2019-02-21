
<?php
    session_start();
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "purpose_id";

    /* DB table to use */
    $sTable = "tblmpurpose";

    /* Database connection information */
    require '../connection_gasql.php';
    


    /*
    * Columns
    * If you don't want all of the columns displayed you need to hardcode $aColumns array with your elements.
    * If not this will grab all the columns associated with $sTable
    */
    $aColumns = array('purpose_id', 'purpose_name', 'purpose_type',  'purpose_salary', 'purpose_desc', 'purpose_status');


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
            if($aColumns[$i] == 'purpose_salary'){
                if($aRow[$aColumns[$i]] == 0){
                    $v = "User's Choice";
                    $row[]=$v;
                }
                else if($aRow[$aColumns[$i]] == 1){
                    $v = "Exposed";
                    $row[]=$v;
                }
                else{
                    $v = "Confidential";
                    $row[]=$v;
                }
            }
            else if($aColumns[$i] == 'Action' ) {
                $v = '<form id="deleteform'.$aRow[$aColumns[0]].'" method="POST" action="maintenance_purpose_routes.php">
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit_purpose", 
                            data-id="'.$aRow[$aColumns[0]].'"
                            data-name="'.$aRow[$aColumns[1]].'"
                            data-type="'.$aRow[$aColumns[2]].'"
                            data-salary="'.$aRow[$aColumns[3]].'"
                            data-desc="'.$aRow[$aColumns[4]].'"
                            data-status="'.$aRow[$aColumns[5]].'"><i class="glyphicon glyphicon-edit"></i> Edit</button>
                        <input type="text" id="inp'.$aRow[$aColumns[0]].'" class="form-control" name="purpose_ID2" value="'.$aRow[$aColumns[0]].'" style="display:none;">
                        <button type="submit" id="btn'.$aRow[$aColumns[0]].'" class="del btn btn-danger btn-sm" name="btn1" value="Delete"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                         </form>';
                $row[]=$v;
            }
            else{
                $v = $aRow[ $aColumns[$i] ];
                $v = mb_check_encoding($v, 'UTF-8') ? $v : utf8_encode($v);
                $row[]=$v;
            }
        }
        If (!empty($row)) {
             $output["aaData"][] = $row; 
            }
    }   
    echo json_encode( $output );
?>