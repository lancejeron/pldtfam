<?php
	session_start();

	$servername = 'localhost';
	$username = 'root';
	$password = '';
	$dbname = 'certificate';

	if(!isset($_SESSION['username'])){
		header("Location:login.php");
	}
	else{

		$conn = mysqli_connect($servername, $username, $password, $dbname);

		// $sql = 'SELECT *, DATE_FORMAT(start_time, "%M %e, %Y @ %r") AS start_time2 FROM view_coe_request AS tbl1';
    $sql = 'SELECT *, DATE_FORMAT(start_time, "%M %e, %Y @ %r") AS start_time2 FROM view_coe_request AS tbl1
    WHERE NOT EXISTS
      (SELECT * FROM prepared_certificates as tbl2
      WHERE tbl2.emp_id = tbl1.persno AND tbl2.date_prepared=tbl1.start_time)';
		$result = mysqli_query($conn, $sql);
		if (!$result) {
			echo "Error:". mysqli_error($conn);
		}
		
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PLDT-HRIS</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">

    <link href="../production/images/icons/favicon.ico" rel="icon"/>

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title">
              <a class="site_title"><i class="fa fa-user"></i> <span>PLDT-HRIS </span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <!-- <img src="images/img.jpg" alt="..." class="img-circle profile_img"> -->
              </div>
              <div class="profile_info">
                <span>Welcome <?php echo $_SESSION['username'];?>!</</span>
                <!-- <h2>John Doe</h2> -->
              </div>
              <div class="clearfix"></div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Menu</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-edit"></i> Certificate<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="index.php">Requests</a></li>
                      <li><a href="index3.php">Finished</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-wrench"></i> Maintenance <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="maintenance_purpose.php">Purpose</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="logout.php">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

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
                            <!-- <th>Action</th> -->
                          </tr>
                        </thead>
                        <?php
                          while($row = mysqli_fetch_array($result)){
                            echo '
                            <tr>
                            <td>' . $row["start_time"] . '</td>
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
                            <td>' . $row["other_instruction"] . '</td>

                            
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
<!-- MODAL -->
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

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

    <!-- Datatables -->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>
    <!-- Momentjs -->
    <script src="../vendors/momentjs/moment.min.js"></script>
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
	// $('.bs-example-modal-lg').on('show.bs.modal', function (event) {
	// 	var button = $(event.relatedTarget)
	// 	var ref_no = button.data('ref_no')
	// 	var persno = button.data('persno')
	// 	var start_time = button.data('start_time')
	// 	var start_time2 = button.data('start_time2')
	// 	var name= button.data('name')
	// 	var purpose= button.data('purpose')
	// 	var accomp_code= button.data('accomp_code')
	// 	var type_of_coe= button.data('type_of_coe')
	// 	var control_id= button.data('control_id')
	// 	var req_status= button.data('req_status')
	// 	var claimersname= button.data('claimersname')
	// 	var claimdate= button.data('claimdate')
	
	// 	var modal = $(this)
	// 	modal.find('.modal-body #ref_no').val(ref_no)
	// 	modal.find('.modal-body #persno').val(persno)
	// 	modal.find('.modal-body #start_time').val(start_time)
	// 	modal.find('.modal-body #start_time2').val(start_time2) 
	// 	modal.find('.modal-body #name').val(name)
	// 	modal.find('.modal-body #purpose').val(purpose)
	// 	modal.find('.modal-body #accomp_code').val(accomp_code)
	// 	modal.find('.modal-body #type_of_coe').val(type_of_coe)
	// 	modal.find('.modal-body #control_id').val(control_id)
	// 	modal.find('.modal-body #req_status').val(req_status)
	// 	modal.find('.modal-body #req_status').text(''+req_status)
	// 	modal.find('.modal-body #claimersname').val(claimersname)
	// 	modal.find('.modal-body #claimdate').val(claimdate)
	// });
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
