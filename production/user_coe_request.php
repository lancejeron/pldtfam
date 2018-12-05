<?php

	$servername = 'localhost';
	$username = 'root';
	$password = '';
	$dbname = 'certificate';

    $conn = mysqli_connect($servername, $username, $password, $dbname);		
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Walk-in Request</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    
    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
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

                    <form class="form-horizontal form-label-left" method="POST" action='user_coe_request_insert_record.php'>
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="emp_no">Employee ID</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="emp_no" name="emp_id" class="form-control col-md-7 col-xs-12" required>
                            <input type="text" id="start_time" name='start_time' class="form-control col-md-7 col-xs-12" style='display: none;'>
                          </div>
                      </div>
        
                      <div class="form-group">
                          <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Employee Name</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="name" class="form-control col-md-7 col-xs-12" type="text" name="emp_name" required>
                          </div>
                      </div>
                      
                      <div class="col-md-8 center-margin">
                          <div class="form-group">
                              <h4>Select type of certificate:</h4>
                                  <div class="form-group">
                                      <div class="radio">
                                          <label>
                                            <input type="radio" checked="" value="option1" id="optionsRadios1" name="type_of_coe" value='Cert of Employment'>Certificate of Employment
                                          </label>
                                      </div>
                                      <div class="radio">
                                          <label>
                                            <input type="radio" value="option2" id="optionsRadios2" name="type_of_coe" value='Cert of Compensation'>Certificate of Employment and Compensation
                                          </label>
                                      </div>
                                  </div>
                          </div>  
                          
                        <div class="form-group">
                            <h4>Select purpose:</h4>
                            <input type="text" id="purpose" class='addpurpose' name='purpose' style='display: none;'>
                            <!-- <textarea id='purpose' class='addpurpose' name='purpose'> 
                            </textarea> -->
                            <div class="row">
                                <div class='col-sm-4'>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox2" id='smp1' value="Car Loan">Car Loan
                                        </label>
                                    </div>
        
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox2" value="Loan Application">Loan Application 
                                        </label>
                                    </div>
        
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox2" value="Housing Loan (Bank/HDMF0) ">Housing Loan (Bank/HDMF0) 
                                        </label>
                                    </div>
        
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox2" value="Credit Card">Credit Card
                                        </label>
                                    </div>
                                    
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox2" value="Cellphone Application">Cellphone Application
                                        </label>
                                    </div>
        
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox2" value="Firearms License">Firearms License
                                        </label>
                                    </div>
        
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox2" value="School">School
                                        </label>
                                    </div>
                                </div>    
                            
                                <div class='col-sm-4'>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox2" value="Visa/Travel Abroad">Visa/Travel Abroad
                                        </label>
                                    </div>
                                    
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox2" value="Migration">Migration
                                        </label>
                                    </div>
                                        
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox2" value="Employment (local/abroad)">Employment (local/abroad)
                                        </label>
                                    </div>
        
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox2" value="HDMF (Loan/Maturity)">HDMF (Loan/Maturity)
                                        </label>
                                    </div>
        
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox2" value="SSS Claim/Pension">SSS Claim/Pension
                                        </label>
                                    </div>
                                    
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox2" value="PhilHealth">PhilHealth
                                        </label>
                                    </div>
                                        
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox2" value="Reference/Others">Reference/Others
                                        </label>
                                    </div>
                                </div>    
                            </div>                                       
                        </div>
                      </div>
                    
                    <div class="ln_solid"></div>
                    
                    <div class="form-group">
                        <!-- <div class="pull-right"> -->
                          <center><button type="submit" class="btn btn-success" onclick='getdatetime();'>Submit</button></center>
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
        var removeval= $('#purpose').val().replace(''+newval+' ', '');
        $('#purpose').val(removeval);
        // alert(removeval);
    }
    else{
        $('#purpose').val(currval + ''+ $(this).val() + ' ');
    }
});
</script>