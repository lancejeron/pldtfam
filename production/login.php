<?php
  session_start();

	// require 'template/connection.php';

  if(isSet($_POST['login'])) {
	  	
    try{
		$servername = 'LAPTOP-KKIP1VTU\SQLEXPRESS';
		$username = $_POST['username'];
		$password = $_POST['password'];
		$dbname = 'eHRISysUsers';
		
		$conn = new PDO("sqlsrv:Server=$servername ; Database=$dbname", "$username", "$password");
		$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$conn->setAttribute( PDO::SQLSRV_ATTR_QUERY_TIMEOUT, 1 ); 

		$query ="SELECT * FROM webusers WHERE username='$username' AND coe IN(1)";

		$stmt=$conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();

		$res = $stmt->rowCount();

		if ($res == 1) {
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
			$_SESSION['userobj'] = $stmt->fetch(PDO::FETCH_ASSOC);

			header('Location: http://localhost/pldt/pldtfam/production/index.php');
			exit;
		} else {
			echo 'Account have no rights to enter the application.';
			header("Location: http://localhost/pldt/pldtfam/production/err_403.php");
		}
    }
    catch(Exception $e)  
    {   
		echo 'Invalid Account.'; 
		header("Location: http://localhost/pldt/pldtfam/production/err_403.php");
    }

} else {


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>PLDT-HRIS</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendors/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendors/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendors/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendors/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendors/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
				<form id='loginform' class="login100-form validate-form" method='POST' action='login.php'>
					<span class="login100-form-title p-b-33">
						Log in to your account.
					</span>

					<div class="wrap-input100 validate-input" data-validate = "You have entered an invalid username or password">
						<div>
							<input type="text" class="input100" placeholder="Username" name='username' autocomplete="off" required/>
							<span class="focus-input100-1"></span>
							<span class="focus-input100-2"></span>
						  </div>
					</div>

					<div class="wrap-input100 rs1 validate-input" data-validate="You have entered an invalid username or password">
						<input type="password" class="input100" placeholder="Password" name='password' required/>
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="container-login100-form-btn m-t-20">
						<button type="submit" id="loginformbtn" class="login100-form-btn" name="login" value="login">Log in</button>
				    </div>
				</form>
			</div>
		</div>
	</div>
	
	
	

	
<!--===============================================================================================-->
	<script src="vendors/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendors/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendors/bootstrap/js/popper.js"></script>
	<script src="vendors/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendors/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendors/daterangepicker/moment.min.js"></script>
	<script src="vendors/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendors/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
	<!-- sweetalert -->
	<script src="../vendors/sweetalert/dist/sweetalert.min.js"></script>

</body>
</html>
<script>
	$(document).ready(function () {
        $('#loginformbtn').click(function(e) {
			$.ajax({
				url: 'login.php',
				method: 'POST',
				data: $('#loginform').serialize(),
				success: function(response){
					console.log(response);
					if (response=='not valid'){
						swal({
							title: "Error.",
							text: "Username and password is invalid.",
							icon: "error",
							showConfirmButton: true,
						});
						e.preventDefault();
					}
					else{

					}
				},
				error: function(response){
					swal("Oops...", "Something went wrong.", "error");
				}
			});
        });
    });

</script>
<?php
    }
?>