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
        
        $persno= $_GET['emp_id'];
        $start_time= $_GET['start_time'];

        $request_query = "SELECT * FROM view_coe_request WHERE persno = '$persno' AND start_time = '$start_time'";
        $request_query_res = mysqli_query($conn, $request_query);
		if (!$request_query_res) {
			echo "Error:". mysqli_error($conn);
        }
		$request_query_res2 = mysqli_query($conn, $request_query);
		$request_query3 = "SELECT * FROM view_coe_request WHERE persno = '$persno' AND start_time = '$start_time'";
		$request_query_res3 = mysqli_query($conn, $request_query3);
		
		$certificate_que = "SELECT * FROM prepared_certificates WHERE date_prepared = '$start_time' AND emp_id='$persno' ORDER BY claimdate DESC";
		$certificate_que_res = mysqli_query($conn, $certificate_que);
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
				<a href="index.php"><button type='button' class='btn btn-secondary pull-right btn-md'><i class="fa fa-chevron-left"></i> Back</button></a>

            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <!-- <h2>Request > </h2> -->
                    <?php
                        while($row = mysqli_fetch_array($request_query_res2)){
							echo '<h2>Request > '.$row["start_time"].'</h2>';
							if($row["req_status"]==0){
								echo '
								<form method="POST" action="request_finished.php">
									<input type="" id="persno" value="'.$row["persno"].'"name="persno" style="display: none;">
									<input type="" id="start_time" value="'.$row["start_time"].'"name="start_time" style="display: none;">
									<button type="submit" class="btn btn-success pull-right btn-sm" name="btn1" value="finish"><i class="fa fa-check"></i> Mark as Finished</button>
								</form>
								';
							}
							else{
								echo '
								<form method="POST" action="request_finished.php">
									<input type="" id="persno" value="'.$row["persno"].'"name="persno" style="display: none;">
									<input type="" id="start_time" value="'.$row["start_time"].'"name="start_time" style="display: none;">
									<button type="submit" class="btn btn-danger pull-right btn-sm" name="btn1" value="unfinish"><i class="fa fa-warning"></i> Mark as Unfinished</button>
								</form>
								';

							}
							
                        }
                    ?>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class='table-responsive'>
					<?php
						while($row = mysqli_fetch_array($request_query_res3)){
							echo '<center><button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#create_certificate" data-persno="'.$row["persno"].'" data-start_time="'.$row["start_time"].'"><i class="fa fa-plus"></i> Create Certificate</button></center>';
						}
					?>
                    
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
                          </tr>
                        </thead>
                        <?php
                          while($row = mysqli_fetch_array($request_query_res)){
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
            <div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
						  	<h2>Certificates</h2>
						<div class="clearfix"></div>
						</div>
						
						<div class="x_content">
							<div class='table-responsive'>
								<table id='mydatatable2' class='table table-striped table-bordered'>
									<thead>
										<tr>
											<th>Reference Number</th>
											<th>Purpose</th>
											<th>Status</th>
											<th>Claim Date</th>
											<th>Action</th>
										</tr>
									</thead>
									<?php
										while($row = mysqli_fetch_array($certificate_que_res)){
											echo '
												<tr>
													<td>'.$row["ref_no"].'</td>
													<td>'.$row["purpose"].'</td>
													<td>'.$row["req_status"].'</td>
													<td>'.$row["date_prepared"].'</td>
													<td> <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit_certificate">Edit</button></td>
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

<!-- CREATE CERTIFICATE MODAL -->
<div class="modal fade bs-example-modal-sm" id="create_certificate" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<form id="" data-parsley-validate class="form-horizontal form-label-left" method='POST' action='request_create_certificate.php'>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">Create Certificate</h4>
				</div>
				<div class="modal-body">
					<input type="" id="persno" name="persno" style="display: none;">
					<input type="" id="start_time" name="start_time" style="display: none;">

					<div class="form-group">
						<label class="control-label col-sm-2" for="purpose_name">Purpose:*</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="name3" placeholder="" name="purpose" maxlength='75' required>
						</div>
            <!-- pdf display -->

					</div>
          
					<div class="form-group">
						<label class="control-label col-sm-2">Type:</label>
							<div class="col-sm-10">
								<select id="type_of_cert" name="type_of_cert" class="form-control" >
									<!-- <option id="status2" label="" value=""></option> -->
									<option id='' value="COE">COE</option>
									<option id='' value="CEC">CEC</option>
									<option id='' value="CECwN">CEC with Notary</option>
								</select>            
							</div>
          </div>

           <!-- <center><button type='button' class='btn btn-info btn-md' data-toggle='modal' data-target='#preview_certificate'> Generate</button></center> -->
        </div>
        <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" id='' class="btn btn-success" value='' name='btn1'>Generate</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- EDIT CERTIFICATE MODAL -->
<div class="modal fade bs-example-modal-lg" id="edit_certificate" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	<form id="editform" data-parsley-validate class="form-horizontal form-label-left" method='POST' action='index3_update_record.php'>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">Process Request</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label col-sm-2" for="ref_no">Reference Number</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="ref_no" placeholder="" disabled>
							<input type="text" class="form-control" id="ref_no" placeholder="" name="ref_no" style="display:none;">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="emp_id">Employee ID</label>
						<div class="col-sm-10">          
							<input type="number" class="form-control" id="emp_id" placeholder="" disabled>
							<input type="number" class="form-control" id="emp_id" placeholder="" name="emp_id" style='display:none;'>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="date_prepared">Date Prepared</label>
						<div class="col-sm-10">          
							<input type="text" class="form-control" id="date_prepared2" placeholder=""disabled>
							<input type="text" class="form-control" id="date_prepared" placeholder="" name="date_prepared" style='display: none;'>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="name">Name</label>
						<div class="col-sm-10">          
							<input type="text" class="form-control" id="name" placeholder="" name="name" disabled>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="purpose">Purpose</label>
						<div class="col-sm-10">          
							<input type="text" class="form-control" id="purpose" placeholder="" name="purpose" disabled>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="accomp_code">Accomp Code</label>
						<div class="col-sm-10">          
							<input type="text" class="form-control" id="accomp_code" placeholder="" name="accomp_code" disabled>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="cbotype">CBO Type</label>
						<div class="col-sm-10">          
							<input type="text" class="form-control" id="cbotype" placeholder="" name="cbotype" disabled>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="personal">Personal</label>
						<div class="col-sm-10">          
							<input type="personal" class="form-control" id="personal" placeholder="" name="personal" disabled>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="req_status">Status</label>
						<div class="col-sm-10">          
								<select name="req_status" class="form-control" >
									<option id="Processed" value="Processed">Processed</option>
									<option id="Claimed" value="Claimed">Claimed</option>
									<option id="Mailed" value="Mailed">Mailed</option>

								</select>                
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="claimersname">Claimer's Name</label>
						<div class="col-sm-10">          
							<input type="text" class="form-control" id="claimersname" placeholder="" name="claimersname" maxlength='75'>
						</div>
					</div>

					<div class="form-group">
							<label for="signature" class="control-label col-sm-2">Claimer's Signature</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" class="form-control" id="claimersign" name="claimersign" placeholder="" style='display: none;' >
							<input type="text" class="form-control" id="claimers_signature" name="claimers_signature" placeholder="" style='display: none;'>
								<div id="signArea" >
									<div class="sig sigWrapper" style="height:auto;">
										<div class="typed"></div>
										<canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
									</div>
									<br>
									<center><button type="button" class="btn btn-default btn-sm" id='btnclear'>Clear</button></center>
								</div>
							</div>
						</div>

					<div class="form-group">
						<label class="control-label col-sm-2" for="claimdate">Claim Date*</label>
						<div class="col-sm-10">          
							<!-- <input type="text" class="form-control" id="claimdate" placeholder="" disabled> -->
							<input type="datetime-local" class="form-control" id="claimdate" name="claimdate">
						</div>
					</div>

          <div class="form-group">
						<label class="control-label col-sm-2">Returned</label>
						<div class="col-sm-10">
							<input type="checkbox" id='returncb' name='returned_status' value='yes'>
              				<input type="checkbox" id='returncb2' class="form-control" name='returned_status' value='no' checked style='display:none;'>
						</div>
					</div>

          <div class="form-group">
						<label class="control-label col-sm-2">Date Returned*</label>
						<div class="col-sm-10">          
              				<!-- <input type="text" id='date_returned' class="form-control" placeholder="" disabled> -->
							<input type="datetime-local" id='date_returned' class="form-control" placeholder="" name='date_returned' disabled required >
              				<!-- <input type="text" id='date_returned3' class="form-control" placeholder="" name='date_returned'> -->
							<!-- <input type="text" id='date_returned4' class="form-control" placeholder=""> -->
							<!-- <input type="datetime-local" id='date_returned4' class="form-control" placeholder="" value="2017-06-01T08:30:01">   -->
						</div>
					</div>

					<div class="ln_solid"></div>
								
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" id="editformbtn" class="btn btn-success" value='Edit' onclick='getdatetime();'>Save</button>
				</div>
			</div>
		</form>
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
		$('#mydatatable').DataTable( {
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			order: [0, 'desc']
		} );
		$('#mydatatable2').DataTable( {
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			order: [0, 'desc']
		} );
	});
	$('#create_certificate').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var persno = button.data('persno')
		var start_time = button.data('start_time')
		
		var modal = $(this)
		modal.find('.modal-body #persno').val(persno)
		modal.find('.modal-body #start_time').val(start_time)	
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
