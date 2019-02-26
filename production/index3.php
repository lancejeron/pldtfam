<?php
	session_start();

	if(!isset($_SESSION['username'])){
        header("Location:login.php");
	}
	else{
		// $date=date("Y-m-d H:i:s", strtotime($_date));

		require 'template/connection.php';
		$ddate = $_GET["date"];
		$ddate2 = $_GET["date2"];
		set_time_limit(120);

		
		$sql = $conn->prepare("SELECT prepared_certificates.*, CONVERT(VARCHAR(23), claimdate, 126) AS claimdate3, CONVERT(VARCHAR(19), claimdate, 120) AS claimdate2, CONVERT(VARCHAR(23), date_returned, 126) AS date_returned3, CONVERT(VARCHAR(19), date_prepared, 120) AS date_prepared2, CONVERT(VARCHAR(19), req_date, 120) AS req_date2 FROM prepared_certificates INNER JOIN view_coe_request ON emp_id = persno
								WHERE (date_prepared BETWEEN '$ddate ' AND '$ddate2 23:59:59') AND (req_date=start_time OR prepared_certificates.purpose=view_coe_request.purpose) ");		
		$sql ->execute();
		$result=$sql->fetchAll();

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
			/* body{
				font-family:monospace;
				text-align:center;
			} */
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
				/* margin: 50px auto; */
			}
			/* .sign-container {
				width: 60%;
				margin: auto;
			} */
			/* .sign-preview {
				width: 150px;
				height: 50px;
				border: solid 1px #CFCFCF;
				margin: 10px 5px;
			} */
			/* .tag-ingo {
				font-family: cursive;
				font-size: 12px;
				text-align: left;
				font-style: oblique;
			} */
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
                <!-- <h3>Certification</h3> -->
              </div>

            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Certificates</h2>
					<!-- <center><button type="button" data-toggle="modal" data-target="#searchmodal" class="btn btn-primary"><i class="fa fa-search"></i> Search</button></center> -->
                    <center>
                      <form class="form-inline" method='GET' action='index3.php'>
                      <?php
                        echo'
                            <div class="form-group">
                              <label>Date Prepared From:</label>
                              <input type="date" class="form-control" name="date" value="'.$ddate.'">
                            </div>
                            <div class="form-group">
                              <label>To:</label>
                              <input type="date" class="form-control" name="date2" value="'.$ddate2.'">
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
                                    <th><u>Date Prepared</u></th>
                                    <th>Employee ID</th>
                                    <th>Reference Number</th>
									<th>Date Requested</th>
                                    <th>Employee Name</th>
									<th>Purpose</th>
                                    <th>Accomp Code</th>
                                    <th>CBO Type</th>
                                    <th>Control ID</th>
                                    <th>Personal</th>
                                    <th>Certificate Status</th>
                                    <th>Claimdate</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <!-- <?php
                                foreach($result as $row){
                                    echo '
									<tr>
									<td>' . $row["date_prepared2"] . '</td>
                                    <td>' . $row["emp_id"] . '</td>
                                    <td>' . $row["ref_no"] . '</td>
									<td>' . $row["req_date2"] . '</td>
                                    <td>' . $row["name"] . '</td>
									<td>' . $row["purpose"] . '</td>
                                    <td>' . $row["accomp_code"] . '</td>
									<td>' . $row["cbotype"] . '</td>
                                    <td>' . $row["control_id"] . '</td>
									<td>' . $row["personal"] . '</td>
									<td>' . $row["cert_status"] . '</td>
                                    <td>' . $row["claimdate2"] . '</td>
									<td>' . 
										'
										<button type="button" class="btn btn-info" data-toggle="modal" data-target="#view_certificate",
											data-ref_no="'.$row['ref_no'].'"><i class="fa fa-eye"></i> View</button>
										
											<button type="button" class="btn btn-warning" data-toggle="modal" data-target=".bs-example-modal-lg", 
                                            data-ref_no="'.$row['ref_no'].'" data-emp_id="'.$row['emp_id'].'"
                                            data-date_prepared2="'.$row['date_prepared2'].'"
											data-date_prepared="'.$row['date_prepared'].'"
											data-req_date="'.$row['req_date'].'"
                                            data-name="'.$row['name'].'"
                                            data-purpose="'.$row['purpose'].'"
                                            data-accomp_code="'.$row['accomp_code'].'"
                                            data-cbotype="'.$row['cbotype'].'"
                                            data-control_id="'.$row['control_id'].'"
                                            data-personal="'.$row['personal'].'"
                                            data-cert_status="'.$row['cert_status'].'"
                                            data-claimersname="'.$row['claimersname'].'"
                                            data-returned_status="'.$row['returned_status'].'"
											data-date_returned="'.$row['date_returned3'].'"
											data-claimers_signature="'.$row['claimers_signature'].'"
                                            data-claimdate="'.$row['claimdate3'].'""><i class="glyphicon glyphicon-edit"></i> Edit</button>' . '</td>
                                </tr>
                                ';
                                }
                            ?> -->
                        </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
<!-- MODAL -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
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
						<input type="text" class="form-control" id="emp_id" placeholder="" disabled>
						<input type="text" class="form-control" id="emp_id" placeholder="" name="emp_id" style='display:none;'>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-sm-2" for="date_prepared">Date Prepared</label>
					<div class="col-sm-10">          
						<input type="text" class="form-control" id="date_prepared2" placeholder=""disabled>
						<input type="text" class="form-control" id="date_prepared" placeholder="" name="date_prepared" style='display: none;'>
						<input type="text" class="form-control" id="req_date" placeholder="" name="req_date" style='display: none;'>

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
					<label class="control-label col-sm-2" for="cert_status">Status</label>
					<div class="col-sm-10">          
							<select name="cert_status" class="form-control" >
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
						<input type="datetime-local" id='date_returned' class="form-control" placeholder="" name='date_returned' disabled required >
						
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
<!-- VIEW CERTIFICATE MODAL -->
<div class="modal fade" id="view_certificate" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body">
				<object id='certpdf' width='860', height='500', data="", type="application/pdf"></object>
			</div>
			<div class="modal-footer">		
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

		var table = $('#mydatatable').DataTable({
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
      		"bDeferRender":  true,
			"bProcessing": true,
        	"bServerSide": true,
        	"sAjaxSource": "template/customscripts/index3_svr.php?ddate=<?php echo $ddate; ?>&ddate2=<?php echo $ddate2; ?>",
        	"bFilter": true,
			// "fixedHeader":true,
			order: [0, 'desc'],
    	});
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
  
	$('.bs-example-modal-lg').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var ref_no = button.data('ref_no')
		var emp_id = button.data('emp_id')
		var date_prepared = button.data('date_prepared')
		var date_prepared2 = button.data('date_prepared2')
		var req_date = button.data('req_date')
		var name= button.data('name')
		var purpose= button.data('purpose')
		var accomp_code= button.data('accomp_code')
		var cbotype= button.data('cbotype')
		var control_id= button.data('control_id')
		var personal= button.data('personal')
		var cert_status= button.data('cert_status')
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
		modal.find('.modal-body #req_date').val(req_date)
		modal.find('.modal-body #name').val(name)
		modal.find('.modal-body #purpose').val(purpose)
		modal.find('.modal-body #accomp_code').val(accomp_code)
		modal.find('.modal-body #cbotype').val(cbotype)
		modal.find('.modal-body #control_id').val(control_id)
		modal.find('.modal-body #personal').val(personal)
		modal.find('.modal-body #cert_status').val(cert_status)
		modal.find('.modal-body #cert_status').text(''+cert_status)
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

		if(cert_status == 'Processed'){
			$('#Processed').prop('selected', true);

		}
		else{
			$('#'+cert_status).prop('selected', true);
		}

		if(claimers_signature==''){
			$("#signArea").replaceWith('<div id="signArea" ><div class="sig sigWrapper current" style="height:auto; display:block;"><div class="typed" style="display: none;"></div><canvas class="sign-pad" id="sign-pad" width="300" height="100"></div><br><center><button type="button" class="btn btn-default btn-sm" id="btnclear" onclick="clearsign();">Clear</button></center></div>');
			$('#signArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90});
		}
		else{
			$("#signArea").replaceWith('<div id="signArea"><img src="./doc_signs/'+claimers_signature+'" class="sign-preview" /></div>');

			
		} 


	});
	$('#view_certificate').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var ref_no = button.data('ref_no')

		var modal = $(this)
		modal.find('.modal-body #certpdf').attr("data", "doc_certs/"+ref_no+".pdf");

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
