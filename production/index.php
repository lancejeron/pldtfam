<?php
	session_start();

	if(!isset($_SESSION['username'])){
		header("Location:login.php");
	}
	else{

    require 'template/connection.php';
    $ddate = $_GET["date"];
    $ddate2 = $_GET["date2"];
    set_time_limit(120);
    


    $stmt = $conn->prepare("SELECT *
    FROM
      (SELECT view_coe_request.*, CONVERT(VARCHAR(19), start_time, 120) AS start_time2 FROM view_coe_request INNER JOIN (SELECT req_date, emp_id FROM prepared_certificates WHERE req_status IN (0) group by req_date, emp_id) as tbl2 ON tbl2.req_date = start_time AND tbl2.emp_id=persno WHERE start_time BETWEEN '$ddate' AND '$ddate2 23:59:59') as v1
      UNION
      (SELECT *, CONVERT(VARCHAR(19), start_time, 120) AS start_time2 FROM view_coe_request as tbl1 WHERE  not exists (SELECT 1 FROM view_coe_request INNER JOIN (SELECT req_date, emp_id FROM prepared_certificates WHERE req_status IN (0,1) group by req_date, emp_id) as tbl2 ON tbl2.req_date = tbl1.start_time AND tbl2.emp_id=tbl1.persno)AND (start_time BETWEEN '$ddate' AND '$ddate2 23:59:59'))");
    // $stmt = $conn->prepare("SELECT view_coe_request.*, CONVERT(VARCHAR(19), start_time, 120) AS start_time2 FROM view_coe_request");

    $stmt->execute();
    $rows = $stmt->fetchAll()
    
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- head.php -->
    <?php require 'template/head.php'; ?>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <!-- navbar.php -->
        <?php require 'template/navbar.php'; ?>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <!-- <h3>Certification</h3> -->
              </div>

            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Requests</h2>
                    <center>
                      <form class="form-inline" method='GET' action='index.php'>
                      <?php
                        echo'
                            <div class="form-group">
                              <label>Start Time From:</label>
                              <input type="date" id="d1" class="form-control" name="date" value="'.$ddate.'">
                            </div>
                            <div class="form-group">
                              <label>To:</label>
                              <input type="date" id="d2" class="form-control" name="date2" value="'.$ddate2.'">
                            </div>
                            <button type="submit" class="btn btn-primary">Go</button>
                        ';
                      ?>
                      </form>
                    </center>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class='table-responsive'>
                      <table id='mydatatable' class='table table-striped table-bordered'>
                        <thead>
                          <tr>
                            <th><u>Start Time</u></th>
                            <th>Employee ID</th>
                            <th>Email</th>
                            <th>Employee Name</th>
                            <th>Type of COE</th>
                            <th>Purpose</th>
                            <th>Salary</th>
                            <th>Question</th>
                            <th>Statement</th>
                            <th>Request for</th>
                            <th>Request for Name</th>
                            <th>Positon Title</th>
                            <th>MMProv</th>
                            <th>Other Instruction</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            PLDT-HRIS
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- script.php -->
    <?php require 'template/script.php' ?>
  </body>
</html>
<script>
	$(document).ready(function() {
    $('#mydatatable thead tr'). clone(true).appendTo('#mydatatable thead');
    $('#mydatatable thead tr:eq(0) th').each(function(i){
      var title = $(this).text();
      $(this).html('<div class="col-md-1 col-sm-12 col-xs-12 form-group"><input type="text" size ="5" class="form-control" placeholder='+title+' ></div>');
      
      $('input', this).on('keyup change', function(){
        if(table.column(i).search()!==this.value){
          table
            .column(i)
            .search(this.value)
            .draw();
        }
      });
    });

    var table = $('#mydatatable').DataTable( {
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "bDeferRender":  true,
				"bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "template/customscripts/index_svr.php?ddate=<?php echo $ddate; ?>&ddate2=<?php echo $ddate2; ?>",
        "bFilter": true,
        // "fixedHeader":true,
        order: [0, 'desc'],
    } );
  });

</script>

<?php
	}
?>
