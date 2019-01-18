<?php
	session_start();

	if(!isset($_SESSION['username'])){
		header("Location:login.php");
	}
	else{

		require 'template/connection.php';
		
		$persno= $_GET['emp_id'];
		$start_time= $_GET['start_time'];

		$request_query = $conn->prepare("SELECT *, CONVERT(VARCHAR(20), start_time, 100) AS start_time FROM view_coe_request WHERE persno = '$persno' AND start_time = '$start_time'");
		$request_query->execute();
		$request_query_res = $request_query->fetchAll();
		$request_query2 = $conn->prepare("SELECT * FROM view_coe_request WHERE persno = '$persno' AND start_time = '$start_time'");
		$request_query2->execute();
		$request_query_res2 = $request_query2->fetchAll();

		$request_query3 = $conn->prepare("SELECT * FROM view_coe_request WHERE persno = '$persno' AND start_time = '$start_time'");
		$request_query3->execute();
		$request_query_res3 = $request_query3->fetchAll();
		
		$certificate_que = $conn->prepare("SELECT *, CONVERT(VARCHAR(20), date_prepared, 100) AS date_prepared2, CONVERT(VARCHAR(23), claimdate, 126) AS claimdate, CONVERT(VARCHAR(20), claimdate, 100) AS claimdate2, CONVERT(VARCHAR(23), date_returned, 126) AS date_returned FROM prepared_certificates WHERE date_prepared = '$start_time' AND emp_id='$persno' ORDER BY prepared_certificates.claimdate DESC");
		$certificate_que->execute();
		$certificate_que_res = $certificate_que->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- head.php -->
    <?php require 'template/head.php'; ?>
		<!-- signature -->
    <link href="css/signature/jquery.signaturepad.css" rel="stylesheet">
    <script src="js/signature/jquery.min.js"></script>
    <script src="js/signature/numeric-1.2.6.min.js"></script> 
    <script src="js/signature/bezier.js"></script>
    <script src="js/signature/jquery.signaturepad.js"></script> 
    
    <script src="js/signature/html2canvas.js"></script>
    <script src="js/signature/json2.min.js"></script>
    
    <style type="text/css">
			#btnSaveSign {
				color: #fff;
				background: #f99a0b;
				padding: 5px;
				border: none;
				border-radius: 5px;
				font-size: 20px;
				margin-top: 10px;
			}
			#signArea{
				width:304px;
			}
    </style>

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
				<a href="index.php"><button type='button' class='btn btn-secondary pull-right btn-md'><i class="fa fa-chevron-left"></i> Back</button></a>

            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <!-- <h2>Request > </h2> -->
                    <?php
                        foreach($request_query_res2 as $row){
													echo '<h2>Request > '.$row["start_time"].'</h2>';
													if($row["req_status"]==0){
														echo '
														<form id="finishform" method="POST" action="request_finished.php">
															<input type="" id="persno" value="'.$row["persno"].'"name="persno" style="display: none;">
															<input type="" id="start_time" value="'.$row["start_time"].'"name="start_time" style="display: none;">
															<button type="submit" id="finishbtn" class="btn btn-success pull-right btn-sm" name="btn1" value="finish"><i class="fa fa-check"></i> Mark as Finished</button>
														</form>
														';
													}
													else{
														echo '
														<form id="finishform" method="POST" action="request_finished.php">
															<input type="" id="persno" value="'.$row["persno"].'"name="persno" style="display: none;">
															<input type="" id="start_time" value="'.$row["start_time"].'"name="start_time" style="display: none;">
															<button type="submit" id="finishbtn" class="btn btn-danger pull-right btn-sm" name="btn1" value="unfinish"><i class="fa fa-warning"></i> Mark as Unfinished</button>
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
						foreach($request_query_res3 as $row){
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
                          foreach($request_query_res as $row){
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
										foreach($certificate_que_res as $row){
											echo '
												<tr>
													<td>'.$row["ref_no"].'</td>
													<td>'.$row["purpose"].'</td>
													<td>'.$row["req_status"].'</td>
													<td>'.$row["claimdate2"].'</td>
													<td>' . '<button type="button" class="btn btn-warning" data-toggle="modal" data-target=".bs-example-modal-lg", 
                                            data-ref_no="'.$row['ref_no'].'" data-emp_id="'.$row['emp_id'].'"
                                            data-date_prepared2="'.$row['date_prepared2'].'"
                                            data-date_prepared="'.$row['date_prepared'].'"
                                            data-name="'.$row['name'].'"
                                            data-purpose="'.$row['purpose'].'"
                                            data-accomp_code="'.$row['accomp_code'].'"
                                            data-cbotype="'.$row['cbotype'].'"
                                            data-control_id="'.$row['control_id'].'"
                                            data-personal="'.$row['personal'].'"
                                            data-req_status="'.$row['req_status'].'"
                                            data-claimersname="'.$row['claimersname'].'"
                                            data-returned_status="'.$row['returned_status'].'"
											data-date_returned="'.$row['date_returned'].'"
											data-claimers_signature="'.$row['claimers_signature'].'"
                                            data-claimdate="'.$row['claimdate'].'""><i class="glyphicon glyphicon-edit"></i> Edit</button>' . '</td>
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
						<label class="control-label col-sm-2">Reference Number*</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="" placeholder="" name="ref_no" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" for="purpose_name">Purpose:*</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="name3" placeholder="" name="purpose" maxlength='75' required>
						</div>
					</div>

            <!-- pdf display -->          
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

					<div class="form-group">
						<label class="control-label col-sm-2">Signature:</label>
						<div class="col-sm-10">
							<input type="checkbox" id='' name='withsignature' value='yes'>
						</div>
					</div>

					
					<div class="form-group">
						<label class="control-label col-sm-2">Header and Footer:</label>
						<div class="col-sm-10">
							<input type="checkbox" id='' name='headerandfooter' value='yes'>
						</div>
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
									<center><button type="button" class="btn btn-default btn-sm" id='btnclear' onclick="clearsign();">Clear</button></center>
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
					<button type="submit" id="editformbtn" class="btn btn-success" value='Edit' >Save</button>
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
	$('#edit_certificate').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var ref_no = button.data('ref_no')
		var emp_id = button.data('emp_id')
		var date_prepared = button.data('date_prepared')
		var date_prepared2 = button.data('date_prepared2')
		var name= button.data('name')
		var purpose= button.data('purpose')
		var accomp_code= button.data('accomp_code')
		var cbotype= button.data('cbotype')
		var control_id= button.data('control_id')
		var personal= button.data('personal')
		var req_status= button.data('req_status')
		var claimersname= button.data('claimersname')
		var claimdate= button.data('claimdate')
		var returned_status= button.data('returned_status')
		var date_returned= button.data('date_returned')
		// var date_returned4= button.data('date_returned')
		var claimers_signature= button.data('claimers_signature')
		
		var modal = $(this)
		modal.find('.modal-body #ref_no').val(ref_no)
		modal.find('.modal-body #emp_id').val(emp_id)
		modal.find('.modal-body #date_prepared').val(date_prepared)
		modal.find('.modal-body #date_prepared2').val(date_prepared2) 
		modal.find('.modal-body #name').val(name)
		modal.find('.modal-body #purpose').val(purpose)
		modal.find('.modal-body #accomp_code').val(accomp_code)
		modal.find('.modal-body #cbotype').val(cbotype)
		modal.find('.modal-body #control_id').val(control_id)
		modal.find('.modal-body #personal').val(personal)
		modal.find('.modal-body #req_status').val(req_status)
		modal.find('.modal-body #req_status').text(''+req_status)
		modal.find('.modal-body #claimersname').val(claimersname)
		modal.find('.modal-body #claimdate').val(claimdate)
		modal.find('.modal-body #date_returned').val(date_returned)
		// modal.find('.modal-body #date_returned4').val(date_returned4)
		modal.find('.modal-body #claimers_signature').val(claimers_signature)


		if (returned_status == 'yes'){
			modal.find('.modal-body #returncb').prop('checked', true);
			modal.find('.modal-body #returncb2').prop('checked', false);
			modal.find('.modal-body #date_returned').prop('disabled', false);

		}
		else{
			modal.find('.modal-body #returncb').prop('checked', false);
			modal.find('.modal-body #returncb2').prop('checked', true);
			modal.find('.modal-body #date_returned').prop('disabled', true);
		}

		if(req_status == 'Processed'){
			$('#Processed').prop('selected', true);

		}
		else{
			$('#'+req_status).prop('selected', true);
		}

		if(claimers_signature==''){
			$("#signArea").replaceWith('<div id="signArea" ><div class="sig sigWrapper current" style="height:auto; display:block;"><div class="typed" style="display: none;"></div><canvas class="sign-pad" id="sign-pad" width="300" height="100"></div><br><center><button type="button" class="btn btn-default btn-sm" id="btnclear" onclick="clearsign();">Clear</button></center></div>');
			$('#signArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90});
		}
		else{
			$("#signArea").replaceWith('<div id="signArea"><img src="./doc_signs/'+claimers_signature+'" class="sign-preview" /></div>');

			
		} 


	});
	$("#returncb").change(function() {
    if(this.checked) {
      $("#returncb2").prop('checked', false);
      $('#date_returned').prop('disabled', false);
      
    }
    else if(!this.checked){
      $("#returncb2").prop('checked', true);
      $('#date_returned').prop('disabled', true);
    }
  });
</script>
<script>
	$(document).ready(function(){
		$('#editformbtn').click(function(e){
			if($("#claimdate").val() == ''){
				swal("Please fill the required(*) fields.","","info");
				e.preventDefault();
			}
			else{
				swal({
				title: "Record will be updated.",
				text: "Are you sure you want to update this record?",
				icon: "warning",
				buttons: {
					cancel: true,
					ok: {
						text: "Update",
						value: "willsubmit",
					}
				},
			})
			.then((willsubmit)=>{
				if (willsubmit){
					if($("#claimers_signature").val()!=''){
						
						$.ajax({
								url: 'index3_update_record.php',
								method: 'POST',
								data: $('#editform').serialize(),
									
								success: function(data){
									console.log(data);
									swal({
										title: "Record updated.",
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
					}
					else{

						html2canvas([document.getElementById('sign-pad')], {
							onrendered: function (canvas) {
								var canvas_img_data = canvas.toDataURL('image/png');
								var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
								$("#claimersign").val(''+img_data);

								var ajax1 = $.ajax({ 
									url: 'save_sign.php',
										data: { img_data:img_data },
										type: 'post',
										dataType: 'json',
										success: function (response) {
												// window.location.reload();
										}             
								});
								
								
								var ajax2 = $.ajax({
									url: 'index3_update_record.php',
									method: 'POST',
									data: $('#editform').serialize(),
										
									success: function(data){
										console.log(data);
										swal({
											title: "Record updated.",
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

								$.when( ajax1 , ajax2  ).done(function( a1, a2 ) {
									var data = a1[0] + a2[0]; // a1[0] = "Got", a2[0] = " Success"
									if ( /Got Success/.test( data ) ) {
										alert( "All AJAX calls successfully gave responses" );
									}
								}); 
							}
						});
					}
				}
				else{
				}
			});
			e.preventDefault();

			}
		});
		$('#finishbtn').click(function(e){
			if($('#finishbtn').val()=='finish'){
				// alert('finish');
				var btn1=$('#finishbtn').val();
				var persno=$('#persno').val();
				var start_time=$('#start_time').val();
				$.ajax({
					url: 'request_finished.php',
					method: 'POST',
					data: {
							btn1:btn1,
							persno:persno,
							start_time:start_time},
						
					success: function(data){
						console.log(data);
						swal({
							title: "Request Finished!",
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
			}
			else{
				// alert('unfinish');
				var btn1=$('#finishbtn').val();
				var persno=$('#persno').val();
				var start_time=$('#start_time').val();
				$.ajax({
					url: 'request_finished.php',
					method: 'POST',
					data: {
							btn1:btn1,
							persno:persno,
							start_time:start_time},
						
					success: function(data){
						console.log(data);
						swal({
							title: "Request Unfinished.",
							text: " ",
							icon: "warning",
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
			}
			e.preventDefault()
		})
  });
</script>
<script>
	function clearsign(){
		$('#signArea').signaturePad().clearCanvas();
	}
</script> 
<?php
	}
?>
