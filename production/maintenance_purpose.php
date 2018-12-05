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

		$sql = 'SELECT * FROM tblmpurpose';
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
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
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
                  <li><a><i class="fa fa-edit"></i> Certificate of Employment <span class="fa fa-chevron-down"></span></a>
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
                <h3>Maintenance</h3>
              </div>

            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Purpose</h2>
                    <button type='button' class='btn btn-success pull-right btn-md' data-toggle='modal' data-target='#add_purpose'><i class="glyphicon glyphicon-plus-sign"></i></i> Add Purpose</button>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class='table-responsive'>
                      <table id='mydatatable' class='table table-striped table-bordered'>
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <?php
                          while($row = mysqli_fetch_array($result)){
                            echo '
                            <tr>
                            <td>' . $row["purpose_name"] . '</td>
                            <td>' . $row["purpose_status"] . '</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit_purpose", 
                                        data-id="'.$row["purpose_ID"].'"
                                        data-name="'.$row["purpose_name"].'"
										data-status="'.$row["purpose_status"].'"><i class="glyphicon glyphicon-edit"></i> Edit
								<form method="POST" action="maintenance_purpose_routes.php">
									<input type="text" class="form-control" name="purpose_ID" value="'.$row["purpose_ID"].'" style="display:none;">
									<button type="submit" class="btn btn-danger btn-sm" name="btn1" value="Delete"><i class="glyphicon glyphicon-trash"></i> Delete
								</form>
                            </td>                        
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

<!-- ADD PURPSOE MODAL -->
<div class="modal fade bs-example-modal-sm" id="add_purpose" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method='POST' action='maintenance_purpose_routes.php'>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">Add Purpose</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label col-sm-2" for="purpose_name">Purpose Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="purpose_name" placeholder="" name="purpose_name" maxlength='75' required>
						</div>
					</div>
        </div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<input type="submit" class="btn btn-success" value='Add' name='btn1'>
				</div>
			</div>
		</form>
	</div>
</div> 

<!-- EDIT PURPOSE MODAL -->
<div class="modal fade bs-example-modal-sm" id="edit_purpose" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method='POST' action='maintenance_purpose_routes.php'>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">Edit Purpose</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label col-sm-2" for="purpose_name">Purpose Name:</label>
						<div class="col-sm-10">
              				<input type="text" class="form-control" id="id" placeholder="" name="purpose_id" style='display: none;'>
							<input type="text" class="form-control" id="name" placeholder="" name="purpose_name" >
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Status:</label>
							<div class="col-sm-10">
								<select name="purpose_status" class="form-control" >
									<option id="status" label="" value=""></option>
									<option value="active">active</option>
									<option value="inactive">inactive</option>
								</select>            
							</div>
						</div>
					</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<input type="submit" class="btn btn-success" value='Edit' name='btn1'>
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
    } );
	});
  $('#edit_purpose').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var id = button.data('id')
    var name = button.data('name')
    var status = button.data('status')
		
	
	var modal = $(this)
	modal.find('.modal-body #id').val(id)
	modal.find('.modal-body #name').val(name)
    modal.find('.modal-body #status').val(status)
    modal.find('.modal-body #status').text(''+status)
	});
</script>
<?php
	}
?>
