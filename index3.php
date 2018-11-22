<?php
	$servername = 'localhost';
	$username = 'root';
	$password = '';
	$dbname = 'dbpldt';
	
	$conn = mysqli_connect($servername, $username, $password, $dbname);

    $sql = 'SELECT *, DATE_FORMAT(start_time, "%M %e, %Y @ %r") AS start_time2, DATE_FORMAT(date_prepared, "%M %e, %Y @ %r") AS date_prepared2, DATE_FORMAT(claimdate, "%M %e, %Y @ %r") AS claimdate2 FROM tblcoereques AS tbl1 INNER JOIN tblpreparedcert ON tblpreparedcert.emp_id = tbl1.emp_id AND tblpreparedcert.date_prepared=tbl1.start_time WHERE EXISTS (SELECT * FROM tblpreparedcert as tbl2 WHERE tbl2.emp_id = tbl1.emp_id AND tbl2.date_prepared=tbl1.start_time)';
	$result = mysqli_query($conn, $sql);
	if (!$result) {
		echo "Error:". mysqli_error($conn);
	}
		
?>
<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>COE (Finished) Requests</title>
		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
		<!-- Bootstrap -->
		<link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

		<!-- <link rel ="stylesheet" href = "https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css"/>
		<script src='https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js'></script>
		<script src='https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js'></script> -->
		<!-- Datatables -->
		<link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
		<link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
		<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
		<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
		<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
		<script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
		<script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
		<script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
		<script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
		<script src="vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
		<script src="vendors/jszip/dist/jszip.min.js"></script>
		<script src="vendors/pdfmake/build/pdfmake.min.js"></script>
		<script src="vendors/pdfmake/build/vfs_fonts.js"></script>
		
		<!-- <link rel ="stylesheet" href = "assets/css/style.css"/> -->
		
</head>
<body>
	<h1><center> COE (Finished) Requests </center></h1>
    <div class='container'>
    <center>
        
        <a href ="index.php"><button type="button" class="btn btn-primary btn-lg">COE Requests</button></a>
        <a href ="index2.php"><button type="button" class="btn btn-primary btn-lg">COE Prepared Certificates</button></a>
        <button type="button" class="btn btn-primary btn-lg">COE (Finished) Requests</button>
    </center>
    </div>
	<div class='container'>
		<div class='table-responsive'>
			<table id='mydatatable' class='table table-striped table-bordered'>
				<thead>
					<tr>
						<th>Start Time</th>
						<th>Employee ID</th>
						<th>Email</th>
						<th>Employee Name</th>
						<th>Type of COE</th>
						<th>Salary</th>
						<th>Question</th>
                        <th>Statement</th>
                        <th>Request for</th>
						<th>Request for Name</th>
						<th>Positon Title</th>
						<th>Personal</th>
						<th>MMProv</th>
						<th>Other Instruction</th>
						<th>Action</th>
					</tr>
				</thead>
				<?php
					while($row = mysqli_fetch_array($result)){
					 	echo '
					 	<tr>
                    	<td>' . $row["start_time2"] . '</td>
						<td>' . $row["emp_id"] . '</td>
						<td>' . $row["email"] . '</td>
                        <td>' . $row["emp_name"] . '</td>
						<td>' . $row["type_of_coe"] . '</td>
						<td>' . $row["_salary"] . '</td>
						<td>' . $row["question1"] . '</td>
						<td>' . $row["statement"] . '</td>
						<td>' . $row["reqt_for"] . '</td>
						<td>' . $row["reqt_for_name"] . '</td>
						<td>' . $row["position_title"] . '</td>
						<td>' . $row["persno"] . '</td>
						<td>' . $row["MMProv"] . '</td>
						<td>' . $row["other_instruction"] . '</td>
						<td>' . '<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg", 
								data-ref_no="'.$row['ref_no'].'" data-emp_id="'.$row['emp_id'].'"
								data-date_prepared="'.$row['date_prepared2'].'"
								data-name="'.$row['name'].'"
								data-purpose="'.$row['purpose'].'"
								data-accomp_code="'.$row['accomp_code'].'"
								data-cbotype="'.$row['cbotype'].'"
								data-control_id="'.$row['control_id'].'"
								data-personal="'.$row['personal'].'"
								data-req_status="'.$row['req_status'].'"
								data-claimersname="'.$row['claimersname'].'"
								data-claimdate="'.$row['claimdate2'].'"">View Certificate</button>' . '</td>
					 </tr>
                    ';
					}
				?>
			</table>
		</div>
	</div>

<!-- MODAL -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method='POST' action='index_update_record.php'>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">Certificate</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label col-sm-2" for="ref_no">Reference Number</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="ref_no" placeholder="" name="ref_no" disabled>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="emp_id">Employee ID</label>
						<div class="col-sm-10">          
							<input type="number" class="form-control" id="emp_id" placeholder="" name="emp_id" disabled>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="date_prepared">Date Prepared</label>
						<div class="col-sm-10">          
							<input type="text" class="form-control" id="date_prepared" placeholder="" name="date_prepared" disabled>
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
						<label class="control-label col-sm-2" for="control_id">Control ID</label>
						<div class="col-sm-10">          
							<input type="control_id" class="form-control" id="control_id" placeholder="" name="control_id" disabled>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="personal">Personal</label>
						<div class="col-sm-10">          
							<input type="personal" class="form-control" id="personal" placeholder="" name="personal" disabled>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="status">Status</label>
						<div class="col-sm-10">          
							<input type="status" class="form-control" id="req_status" placeholder="" name="status" disabled>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="claimersname">Claimer's Name</label>
						<div class="col-sm-10">          
							<input type="text" class="form-control" id="claimersname" placeholder="" name="claimersname" disabled>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" for="claimdate">Claim Date</label>
						<div class="col-sm-10">          
							<input type="text" class="form-control" id="claimdate" placeholder="" disabled>
							<input type="text" class="form-control" id='test1' name="claimdate" style='display: none;'>
						</div>
					</div>
							
					<div class="ln_solid"></div>
								
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- jQuery -->
<script src="vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Datatables -->
<script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="assets/momentjs/moment.min.js"></script>
</body>

</html>
<script>
	$(document).ready(function() {
		$('#mydatatable').DataTable();
	});
	$('.bs-example-modal-lg').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var ref_no = button.data('ref_no')
		var emp_id = button.data('emp_id')
		var date_prepared = button.data('date_prepared')
		var name= button.data('name')
		var purpose= button.data('purpose')
		var accomp_code= button.data('accomp_code')
		var cbotype= button.data('cbotype')
		var control_id= button.data('control_id')
		var personal= button.data('personal')
		var req_status= button.data('req_status')
		var claimersname= button.data('claimersname')
		var claimdate= button.data('claimdate')
	
		var modal = $(this)
		modal.find('.modal-body #ref_no').val(ref_no)
		modal.find('.modal-body #emp_id').val(emp_id)
		modal.find('.modal-body #date_prepared').val(date_prepared) 
		modal.find('.modal-body #name').val(name)
		modal.find('.modal-body #purpose').val(purpose)
		modal.find('.modal-body #accomp_code').val(accomp_code)
		modal.find('.modal-body #cbotype').val(cbotype)
		modal.find('.modal-body #control_id').val(control_id)
		modal.find('.modal-body #personal').val(personal)
		modal.find('.modal-body #req_status').val(req_status)
		modal.find('.modal-body #claimersname').val(claimersname)
		modal.find('.modal-body #claimdate').val(claimdate)
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