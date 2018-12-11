<?php

	$servername = 'localhost';
	$username = 'root';
	$password = '';
	$dbname = 'certificate';

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $purpose_query_coe = "SELECT * FROM tblmpurpose WHERE purpose_status IN ('active') AND purpose_type IN ('Both', 'COE')";
    $purpose_result_coe = mysqli_query($conn, $purpose_query_coe);
		if (!$purpose_result_coe) {
			echo "Error:". mysqli_error($conn);
        }
    $purpose_query_cec = "SELECT * FROM tblmpurpose WHERE purpose_status IN ('active') AND purpose_type IN ('Both', 'CEC')";
    $purpose_result_cec = mysqli_query($conn, $purpose_query_cec);
		if (!$purpose_result_cec) {
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
                        <div class="alert alert-success" role="alert">
                            <strong>Warning!</strong> Requesting Certificate of Employment and Compensation would require your salary to be exposed.
                        </div>
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
                                            <input type="checkbox" class='typeofcoe' value='Cert of Employment'>Certificate of Employment (COE)
                                          </label>
                                      </div>
                                      <div class="checkbox">
                                          <label>
                                            <input type="checkbox" class='typeofcec' value='Cert of Compensation'>Certificate of Employment and Compensation (CEC)
                                          </label>
                                      </div>
                                  </div>
                          </div>  

                        <div class="row">  
                        <input type="text" id="purpose" class='addpurpose' name='purpose' style='display: none;'>
                        <input type="text" id="purpose_coe" class='addpurpose' style='display: none;'> 
                        <input type="text" id="purpose_cec" class='addpurpose' style='display: none;'>
                        <input type="text" id="purpose_salary_coe" class='' name='' style='display: none;'>
                        <!-- <input type="text" id="purpose_salary_cec" class='' name='' style='display: none;' > -->
                        <input type="text" id="purpose_salary" class='' name='salary' style='display: none;' >
                            <div class="col-sm-6">
                                <div id='coe_purpose' class="form-group" style='height: 200px; width: auto; overflow-y: ' hidden>
                                    <h4>Select purpose (COE) *:</h4>
                                     <div class='col-sm-8'>
                                        <?php
                                            while($row = mysqli_fetch_array($purpose_result_coe)){
                                                echo '
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" class="checkbox2" value="'.'['. $row["purpose_ID"].']" name="'. $row["purpose_name"] .'">'. $row["purpose_name"] . '
                                                                
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" value="'.'['. $row["purpose_ID"].'](1);" class="purpose_salary" name="'. $row["purpose_name"] .'">Exposed 
                                                                    </label>
                                                      
                                                                    <label>
                                                                        <input type="radio" value="'.'['. $row["purpose_ID"].'](0);" class="purpose_salary" name="'. $row["purpose_name"] .'">Confidential
                                                                        </label>
                                                                </div>
                                                        </label>
                                                    </div>
                                                ';

                                            }
                                        ?>
                                    </div>    
                                </div>
                            </div>

                            <div class="col-sm-6">    
                                <div id='cec_purpose' class="form-group" style='height: 200px; width: auto; overflow-y: ' hidden>
                                    <h4>Select purpose (CEC) *:</h4>
                                    <div class='col-sm-8'>
                                        <?php
                                            while($row = mysqli_fetch_array($purpose_result_cec)){
                                                echo '
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" class="checkbox3" value="'. $row["purpose_name"] .'" >'. $row["purpose_name"] . '
                                                        </label>
                                                    </div>
                                                ';

                                            }
                                        ?>
                                    </div> 
                                </div>       
                            </div>
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

        // var x=document.getElementById("purpose").value;
        // var y=document.getElementById("purpose_cec").value;
        // var xy = x+' '+y;
        // document.getElementById("purpose").value=xy;
        // alert(xy);
	}
</script>
<script>
    $(".checkbox2").change(function() {
        var newval = $(this).val();
        var x = $(this).attr('name');
        var currval = $('#purpose_coe').val();
        var currval_salary = $('#purpose_salary_coe').val();
        var a = newval+'(1); ';
        if(!this.checked){
            var removeval= $('#purpose_coe').val().replace(''+newval+x+'(COE); ', '');
            
            
            $('#purpose_coe').val(removeval);
            // $('#purpose_salary_coe').val(removeval_salary_coe1);
            var n = $('#purpose_salary_coe').val().search("(0)");
            if(n>=0){
                var removeval_salary_coe1= $('#purpose_salary_coe').val().replace(''+newval+'(0); ', '');
                $('#purpose_salary_coe').val(removeval_salary_coe1);
            }
            else{
                var r= $('#purpose_salary_coe').val().replace(''+newval+'(1); ', '');
                $('#purpose_salary_coe').val(r);
            }
            $("[value='"+newval+"(1);']").prop('checked', false)
            $("[value='"+newval+"(0);']").prop('checked', false)
            
        }
        else{
            
            $('#purpose_coe').val(currval + ''+ $(this).val() + x +'(COE); ');
            $('#purpose_salary_coe').val(currval_salary+ newval + '(1); ');
            $("[value='"+newval+"(1);']").prop('checked', true)
        }
    });
    $(".checkbox3").change(function() {
        var newval = $(this).val();
        var currval = $('#purpose_cec').val();
        // var currval_salary = $('#purpose_salary_cec').val();
        if(!this.checked){
            var removeval= $('#purpose_cec').val().replace(''+newval+'(CEC); ', '');
            $('#purpose_cec').val(removeval);
            // var removeval_salary_cec1= $('#purpose_salary_cec').val().replace(''+newval+'(Exposed); ', '');
            // $('#purpose_salary_cec').val(removeval_salary_cec1);
        }
        else{
            $('#purpose_cec').val(currval + ''+ $(this).val() + '(CEC); ');
            // $('#purpose_salary_cec').val(currval_salary+ newval + '(Exposed); ');
        }
    });
    $(".typeofcoe").change(function() {
        var newval = $(this).val();
        var currval = $('#typeofcoe').val();
        if(!this.checked){
            var removeval= $('#typeofcoe').val().replace(''+newval+'; ', '');
            $('#typeofcoe').val(removeval);
            $("#coe_purpose").attr('hidden', true);
            $('#purpose_coe').val('');
            $('.checkbox2').prop('checked', false);
            $('#purpose_salary_coe').val('');
            $(".purpose_salary").prop("checked", false);

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
            $('#purpose_cec').val('');
            $('.checkbox3').prop('checked', false);
            $('#purpose_salary_cec').val('');
        }
        else{
            $('#typeofcoe').val(currval + ''+ $(this).val() + '; ');
            $("#cec_purpose").attr('hidden', false);
        }
    });
    // purpose salary
    $(".purpose_salary").change(function() {
        var newval = $(this).val();
        var currval = $('#purpose_salary_coe').val();
        var n = newval.search('(1)');
        var x = newval.replace('(1)', '(0)');
        var y = newval.replace('(0)', '(1)');
        var a = y;
        var b = x;

        // alert('newval=='+ newval+'y=='+y);
        // alert(a);
        // alert(x);
        // var mm = newval.replace('Exposed', 'Confidential');
        if(newval == y){
            // alert('clinick ay exp');
            // var y = newval.replace('Confidential', 'Exposed');
            var makeitexposed=$('#purpose_salary_coe').val().replace(''+b, ''+a);
            $('#purpose_salary_coe').val(makeitexposed);
        }
        else{
            // alert('clinick ay Conf');
            // var x = newval.replace('Exposed', 'Confidential');
            var makeitconf = $('#purpose_salary_coe').val().replace(''+a, ''+b);
            $('#purpose_salary_coe').val(makeitconf);
            
        }

    });

</script>
<script>
    $(document).ready(function () {
        $('#req_coebt').click(function(e) {
            checked = $(".checkbox2:checkbox:checked").length;
            checked_ = $(".checkbox3:checkbox:checked").length;
            checked2 = $(".typeofcoe:checkbox:checked").length;
            checked3 = $(".typeofcec:checkbox:checked").length;
            if(!checked2  && !checked3 ) {
                swal("Please pick at least one type of certificate.","","info");
                return false;
            }
            else{
                if((checked==0) && (checked_==0) ) {
                    swal("Please pick at least one purpose.","","info");
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
                            var purpose_coe = $('#purpose_coe').val();
                            var purpose_cec = $('#purpose_cec').val();
                            $('#purpose').val(purpose_coe+' '+purpose_cec);

                            var purpose_salary_coe = $('#purpose_salary_coe').val();
                            // var purpose_salary_cec = $('#purpose_salary_cec').val();
                            $('#purpose_salary').val(purpose_salary_coe);

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