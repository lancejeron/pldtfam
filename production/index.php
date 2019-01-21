<?php
	session_start();

	if(!isset($_SESSION['username'])){
		header("Location:login.php");
	}
	else{

		require 'template/connection.php';
    
    $stmt = $conn->prepare('SELECT *, CONVERT(VARCHAR(20), start_time, 100) AS start_time2 FROM view_coe_request AS tbl1 WHERE req_status IN(0, NULL)');
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
                <h3>Certificate</h3>
              </div>

            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Requests</h2>
                    <!-- <button type='button' class='btn btn-success pull-right btn-md' data-toggle='modal' data-target='#walkin'><i class="fa fa-plus"></i> Create Request</button> -->
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class='table-responsive'>
                      <table id='mydatatable' class='table table-striped table-bordered'>
                        <thead>
                          <tr>
                            <th>Start Time</th>
                            <th>Method</th>
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
                        <?php
                          foreach($rows as $row){
                            $persno = $row["persno"];
                            $start_time = $row["start_time"];
                            echo '
                            <tr>
                            <td>' . $row["start_time2"] . '</td>
                            <td>' . $row["req_type"] . '</td>
                            <td>' . $row["persno"] . '</td>
                            <td>' . $row["email"] . '</td>
                            <td>' . $row["emp_name"] . '</td>
                            <td>' . $row["type_of_coe"] . '</td>
                            <td>' . $row["purpose"] . '</td>
                            <td>' . $row["_salary"] . '</td>
                            <td>' . $row["question1"] . '</td>
                            <td>' . $row["statement"] . '</td>
                            <td>' . $row["reqt_for"] . '</td>
                            <td>' . $row["reqt_for_name"] . '</td>
                            <td>' . $row["position_title"] . '</td>
                            <td>' . $row["MMProv"] . '</td>
                            <td>' . $row["other_instructions"] . '</td>
                            <td><a href="request.php?emp_id='.$persno.'&start_time='.$start_time.'"><button type="button" class="btn btn-info">View</button></a></td>

                            
                          </tr>
                          ';
                          }
                        ?>
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
    // $('#mydatatable').DataTable();
    $('#mydatatable').DataTable( {
        // dom: 'Bfrtip',
        // buttons: [
        //     'copy', 'csv', 'print'
        // ],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        order: [0, 'desc']
    } );
	});

</script>
<script>
	function getdatetime(){
		var today = new Date();         
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();
		var hh = today.getHours();
		var min = today.getMinutes();
		var sec = today.getSeconds();
		// var parsetoday = new Date(today)
		
		if(dd<10) {
			dd = '0'+dd
		} 

		if(mm<10) {
			mm = '0'+mm
		}

		today = yyyy + '-' + mm + '-' + dd + ' '+ hh + ':' + min +':' +sec;

		document.getElementById("test1").value=today;
	}
</script>
<?php
	}
?>
