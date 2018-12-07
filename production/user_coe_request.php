<?php

	$servername = 'localhost';
	$username = 'root';
	$password = '';
	$dbname = 'certificate';

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $purpose_query = "SELECT * FROM tblmpurpose WHERE purpose_status IN ('active')";
    $purpose_result_coe = mysqli_query($conn, $purpose_query);
		if (!$purpose_result_coe) {
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

    <title>PLDT-HRIS </title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    
    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">

    <link href="../production/images/icons/favicon.ico" rel="icon"/>

  </head>

  <body class="nav-sm">
    <div class="container body">
      <div class="main_container">
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Request for Certificate</h3>
              </div>


            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Request for Certificate</h2>
                    
             
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <form id='req_coe' class="form-horizontal form-label-left" method="POST" action='user_coe_request_insert_record.php'>
                      <div class="form-group is_req">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Employee ID *:</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="emp_id" name="emp_id" class="form-control col-md-7 col-xs-12" autocomplete="off">
                            <input type="text" id="start_time" name='start_time' class="form-control col-md-7 col-xs-12" style='display: none;'>
                          </div>
                      </div>
        
                      <div class="form-group is_req">
                          <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Employee Name *:</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="emp_name" class="form-control col-md-7 col-xs-12" type="text" name="emp_name" autocomplete="off">
                          </div>
                      </div>
                      
                      <div class="col-md-8 center-margin">
                          <div class="form-group">
                              <h4>Select type of certificate:</h4>
                                  <div class="form-group">
                                    <input type="text" id='typeofcoe' name='type_of_coe' style='display: none;'>
                                      <div class="checkbox">
                                          <label>
                                            <input type="checkbox" class='typeofcoe' value='Cert of Employment'>Certificate of Employment
                                          </label>
                                      </div>
                                      <div class="checkbox">
                                          <label>
                                            <input type="checkbox" class='typeofcec' value='Cert of Compensation'>Certificate of Employment and Compensation
                                          </label>
                                      </div>
                                  </div>
                          </div>  
                          
                        <div id='coe_purpose' class="form-group" style='height: 200px; width: auto; overflow-y: scroll;' hidden>
                        <h4>Select purpose (COE) *:</h4>
                            <input type="text" id="purpose" class='addpurpose' name='purpose'  style='display: none;'>
                            <!-- <div class="row"> -->
                                <div class='col-sm-8'>
                                    <?php
                                        while($row = mysqli_fetch_array($purpose_result_coe)){
                                            echo '
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="checkbox2" value="'. $row["purpose_name"] .'" >'. $row["purpose_name"] . '
                                                    </label>
                                                </div>
                                            ';

                                        }
                                    ?>
                                </div>    
                            <!-- </div> -->
                        </div>
                        <div id='cec_purpose' class="form-group" style='height: 200px; width: auto; overflow-y: scroll;' hidden>
                        <h4>Select purpose (CEC) *:</h4>
                            <input type="text" id="purpose" class='addpurpose' name='purpose'  style='display: none;'>
                            <!-- <div class="row"> -->
                                <div class='col-sm-8'>
                                    <?php
                                        while($row = mysqli_fetch_array($purpose_result_coe)){
                                            echo '
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="checkbox2" value="'. $row["purpose_name"] .'" >'. $row["purpose_name"] . '
                                                    </label>
                                                </div>
                                            ';

                                        }
                                    ?>
                                </div>    
                            <!-- </div> -->
                        </div>
                      </div>
                    
                    <div class="ln_solid"></div>
                    
                    <div class="form-group">
                        <!-- <div class="pull-right"> -->
                          <center><button id='req_coebt' type="submit" class="btn btn-success btn-lg" onclick='getdatetime();'><i class="glyphicon glyphicon-send"></i> Submit</button></center>
                        </div>
                    </form>
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

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- validator -->
    <script src="../vendors/validator/validator.js"></script>
    <!-- sweetalert -->
    <script src="../vendors/sweetalert/dist/sweetalert.min.js"></script>   


    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>


	
  </body>
</html>
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

		document.getElementById("start_time").value=today;
	}
</script>
<script>
    $(".checkbox2").change(function() {
        var newval = $(this).val();
        var currval = $('#purpose').val();
        if(!this.checked){
            var removeval= $('#purpose').val().replace(''+newval+'; ', '');
            $('#purpose').val(removeval);
        }
        else{
            $('#purpose').val(currval + ''+ $(this).val() + '; ');
        }
    });
    $(".typeofcoe").change(function() {
        var newval = $(this).val();
        var currval = $('#typeofcoe').val();
        if(!this.checked){
            var removeval= $('#typeofcoe').val().replace(''+newval+'; ', '');
            $('#typeofcoe').val(removeval);
            $("#coe_purpose").attr('hidden', true);
        }
        else{
            $('#typeofcoe').val(currval + ''+ $(this).val() + '; ');
            $("#coe_purpose").attr('hidden', false);
        }
    });
    $(".typeofcec").change(function() {
        var newval = $(this).val();
        var currval = $('#typeofcoe').val();
        if(!this.checked){
            var removeval= $('#typeofcoe').val().replace(''+newval+'; ', '');
            $('#typeofcoe').val(removeval);
            $("#cec_purpose").attr('hidden', true);
        }
        else{
            $('#typeofcoe').val(currval + ''+ $(this).val() + '; ');
            $("#cec_purpose").attr('hidden', false);
        }
    });

</script>
<script>
    $(document).ready(function () {
        $('#req_coebt').click(function(e) {
            checked = $(".checkbox2:checkbox:checked").length;
            checked2 = $(".typeofcoe:checkbox:checked").length;
            if(!checked) {
                swal("Please pick at least one purpose.","","info");
                return false;
            }
            else{
                if(!checked2) {
                    swal("Please pick at least one type of certificate.","","info");
                    return false;
                }
                else{
                    var emp_id = $('#emp_id').val();
                    var emp_name = $('#emp_name').val();
                    if(emp_id=='' || emp_name==''){
                        swal("Please fill the required(*) fields.","","info");
                        e.preventDefault();
                    }
                    else{
                        var form = $('#req_coe');   
                        swal({
                            title: "Are you sure you want to submit your request?",
                            text: "Clicking ok will certify that you fully reviewed your request.",
                            icon: "warning",
                            buttons: {
                                cancel: true,
                                ok: {
                                    text: "Ok",
                                    value: "willsubmit",
                                }
                            },
                        })
                        .then((willsubmit)=>{
                            if (willsubmit){
                                $.ajax({
                                    url: 'user_coe_request_insert_record.php',
                                    method: 'POST',
                                    data: $('#req_coe').serialize(),
                                    success: function(data){
                                        console.log(data);
                                        swal({
                                            title: "Request submitted!",
                                            text: "Please inform us that you already submitted your request. Thank you.",
                                            icon: "success",
                                            // showConfirmButton: true,
                                            buttons: false,
                                        });
                                        setTimeout( function () {
                                            location.reload(); 
                                        }, 6000);
                                    },
                                    error: function(data){
                                        swal("Oops...", "Something went wrong.", "error");
                                    }
                                });
                            }
                            else{
                            }
                        });
                        e.preventDefault();
                    }
                }
            }
        });
    });
</script>