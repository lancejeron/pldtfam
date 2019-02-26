<?php
	session_start();

	if(!isset($_SESSION['username'])){
		header("Location:login.php");
	}
	else{

		require 'template/connection.php';

		$sql = $conn->prepare('SELECT * FROM tblmpurpose');
		$sql->execute();
		$rows = $sql->fetchAll()
		
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
														<th>ID</th>
                            <th>Name</th>
                            <th>Type</th>
														<th>Salary</th>
														<th>Note</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <?php
                         	foreach($rows as $row){
                            echo '
														<tr>
														<td>' . $row["purpose_ID"] . '</td>
														<td>' . $row["purpose_name"] . '</td>
														<td>' . $row["purpose_type"] . '</td>';
														if($row["purpose_salary"]==0){
															echo "<td>User's Choice</td>";
														}
														else if($row["purpose_salary"]==1){
															echo "<td>Exposed</td>";
														}
														else{
															echo "<td>Confidential</td>";
														}
														echo '
														<td>' . $row["purpose_desc"] . '</td>
														<td>' . $row["purpose_status"] . '</td>
                          	<td>
                            <form id="deleteform'.$row["purpose_ID"].'" method="POST" action="maintenance_purpose_routes.php">
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit_purpose", 
                                        data-id="'.$row["purpose_ID"].'"
																				data-name="'.$row["purpose_name"].'"
																				data-type="'.$row["purpose_type"].'"
																				data-salary="'.$row["purpose_salary"].'"
																				data-desc="'.$row["purpose_desc"].'"
                              data-status="'.$row["purpose_status"].'"><i class="glyphicon glyphicon-edit"></i> Edit</button>
                            <input type="text" id="inp'.$row["purpose_ID"].'" class="form-control" name="purpose_ID2" value="'.$row["purpose_ID"].'" style="display:none;">
                            <button type="submit" id="btn'.$row["purpose_ID"].'" class="del btn btn-danger btn-sm" name="btn1" value="Delete"><i class="glyphicon glyphicon-trash"></i> Delete</button>
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
		<form id="addform" data-parsley-validate class="form-horizontal form-label-left" method='POST' action='maintenance_purpose_routes.php'>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">Add Purpose</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label col-sm-2" for="purpose_name">Name:*</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="name3" placeholder="" name="purpose_name" maxlength='75' required>
						</div>
					</div>
          
					<div class="form-group">
						<label class="control-label col-sm-2">Type:</label>
							<div class="col-sm-10">
								<select id="purpose_type3" name="purpose_type" class="form-control" >
									<!-- <option id="status2" label="" value=""></option> -->
                  <option id='' value="Both">Both</option>
									<option id='' value="COE">COE</option>
									<option id='' value="CEC">CEC</option>
								</select>            
							</div>
          </div>

					<div class="form-group">
						<label class="control-label col-sm-2">Salary:</label>
							<div class="col-sm-10">
								<select id="purpose_salary3" name="purpose_salary" class="form-control" >
                  <option id='' value="0">User's Choice</option>
									<option id='' value="1">Exposed</option>
									<option id='' value="2">Confidential</option>
								</select>            
							</div>
          </div>
					
					<div class="form-group">
						<label class="control-label col-sm-2">Description</label>
						<div class="col-sm-10">
							<textarea id='purpose_desc' class="form-control" placeholder="" name="purpose_desc"></textarea>
						</div>
					</div>

        </div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" id='addformbtn' class="btn btn-success" value='Add' name='btn1'>Add</button>
				</div>
			</div>
		</form>
	</div>
</div> 

<!-- EDIT PURPOSE MODAL -->
<div class="modal fade bs-example-modal-sm" id="edit_purpose" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<form id="editform" data-parsley-validate class="form-horizontal form-label-left" method='POST' action='maintenance_purpose_routes.php'>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">Edit Purpose</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label col-sm-2" for="purpose_name">Purpose Name *:</label>
						<div class="col-sm-10">
              				<input type="text" class="form-control" id="id2" placeholder="" name="purpose_id" style='display: none;'>
							<input type="text" class="form-control" id="name2" placeholder="" name="purpose_name" >
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Type:</label>
							<div class="col-sm-10">
								<select id="purpose_type2" name="purpose_type" class="form-control" >
									<option id='Both' value="Both">Both</option>
									<option id='COE' value="COE">COE</option>
									<option id='CEC' value="CEC">CEC</option>
								</select>            
							</div>
          			</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Salary:</label>
							<div class="col-sm-10">
								<select id="purpose_salary2" name="purpose_salary" class="form-control" >
                  <option id='sal0' value="0">User's Choice</option>
									<option id='sal1' value="1">Exposed</option>
									<option id='sal2' value="2">Confidential</option>
								</select>            
							</div>          
     			</div>

					<div class="form-group">
						<label class="control-label col-sm-2">Description</label>
						<div class="col-sm-10">
							<textarea id='desc2' class="form-control" placeholder="" name="purpose_desc"></textarea>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2">Status:</label>
							<div class="col-sm-10">
								<select id="status3" name="purpose_status" class="form-control" >
									<option id='opt_active' value="active">active</option>
									<option id='opt_inactive' value="inactive">inactive</option>
								</select>            
							</div>
          			</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" id='editformbtn' class="btn btn-success" value='Edit' name='btn1'>Save</button>
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

    <!-- script.php -->
    <?php require 'template/script.php' ?>
		<script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
  </body>
</html>

<script>
	$(document).ready(function() {
    var table = $('#mydatatable').DataTable( {
				"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				// "bDeferRender":  true,
				// "bProcessing": true,
        // "bServerSide": true,
				// "sAjaxSource": "template/customscripts/maintenance_purpose_svr.php"
    });
	});
	
  $('#edit_purpose').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var id = button.data('id')
		var name = button.data('name')
		var type = button.data('type')
		var status = button.data('status')
		var salary = button.data('salary')
		var desc = button.data('desc')
			
		
		var modal = $(this)
		modal.find('.modal-body #id2').val(id)
		modal.find('.modal-body #name2').val(name)
		modal.find('.modal-body #desc2').val(desc)
		$('#sal'+salary).prop('selected', true);
		// modal.find('.modal-body #status2').val(status)
		// modal.find('.modal-body #status2').text(''+status)
		if(status=='active'){
			$('#opt_active').prop('selected', true);
		}
		else{
			$('#opt_inactive').prop('selected', true);
		}
		if(type=='Both'){
			$('#'+type).prop('selected', true);
		}
		else{
			$('#'+type).prop('selected', true);
		}
	


	});
</script>
<script>
	$(document).ready(function () {
    	// delete swal
		// $("button[type=submit]").click(function(e){
		// $(".del").click(function(e){

		// 	var id = $(this).parent('form').find('input[name="purpose_ID2"]').val();
		// 	alert(id);
		// 	e.preventDefault();

		// 	console.log(id);
		// 	swal({
		// 		title: "Delete Purpose",
		// 		text: "Are you sure you want to delete this purpose?",
		// 		icon: "warning",
		// 		buttons: {
		// 			cancel: true,
		// 			ok: {
		// 				text: "Ok",
		// 				value: "willsubmit",
		// 			}
		// 		},
		// 	})
		// 	.then((willsubmit)=>{
		// 		if (willsubmit){
		// 			$.ajax({
		// 				url: 'maintenance_purpose_routes.php',
		// 				method: 'POST',
		// 				data: {
		// 					purpose_ID2: id,
		// 					btn1: 'Delete'

		// 					},
		// 				success: function(data){
		// 					console.log(data);
		// 					swal({
		// 						title: "Purpose successfully deleted.",
		// 						text:" ",
		// 						icon: "success",
		// 						buttons: false,
		// 					});
		// 					setTimeout( function () {
		// 						location.reload(); 
		// 					}, 1000);
		// 				},
		// 				error: function(data){
		// 					swal("Oops...", "Something went wrong :(", "error");
		// 				}
		// 			});
		// 		}
		// 		else{
		// 		}
		// 		e.preventDefault();
		// 	});
			
		// });

		// edit swal
		$('#editformbtn').click(function(e){
			var purpose_ID =  $('#id2').val();
			var purpose_name =  $('#name2').val();
			var purpose_type =  $('#purpose_type2').val();
			var purpose_status =  $('#status3').val();
			var purpose_salary =  $('#purpose_salary2').val();
			var purpose_desc =  $('#desc2').val();
			if(purpose_name == ''){
				swal("Please fill the required(*) fields.","","info");
				e.preventDefault();
			}
			else{
				$.ajax({
					url: 'maintenance_purpose_routes.php',
					method: 'POST',
					data: {
						purpose_id: purpose_ID,
						purpose_name: purpose_name,
						purpose_type: purpose_type,
						purpose_status: purpose_status,
						purpose_salary: purpose_salary,
						purpose_desc: purpose_desc,

						btn1: 'Edit'

					},
					success: function(data){
						console.log(data);
						swal({
							title: "Purpose Updated.",
							text: " ",
							icon: "success",
							buttons: false,
						});
						setTimeout( function () {
							location.reload(); 
						}, 1500);
					},
					error: function(data){
						swal("Oops...", "Something went wrong.", "error");
					}
				});
				e.preventDefault();
			}
		});

		// add swal
		$('#addformbtn').click(function(e){
			var purpose_name =  $('#name3').val();
			var purpose_type =  $('#purpose_type3').val();
			var purpose_salary =  $('#purpose_salary3').val();
			var purpose_desc =  $('#purpose_desc').val();
			if(purpose_name == ''){
				swal("Please fill the required(*) fields.","","info");
				e.preventDefault();
			}
			else{
				$.ajax({
					url: 'maintenance_purpose_routes.php',
					method: 'POST',
					data: {
						purpose_name: purpose_name,
						purpose_type: purpose_type,
						purpose_salary: purpose_salary,
						purpose_desc: purpose_desc,
						btn1: 'Add'

					},
					success: function(response){
						console.log(response);
						if (response == 'success'){
							swal({
							title: "Purpose Added.",
							text: " ",
							icon: "success",
							buttons: false,
							});
							setTimeout( function () {
								location.reload(); 
							}, 1500);
						}
						else if (response == 'already exists'){
							swal({
							title: "Purpose already exists.",
							text: "Purpose did not add.",
							icon: "error",
							});
						}
					},
					error: function(response){
						swal("Oops...", "Something went wrong.", "error");
					}
				});
			}
				e.preventDefault();
		})
	});
</script>

<?php
	}
?>
