<?php
  session_start();

  $servername = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'dbpldt';
  
  $conn = mysqli_connect($servername, $username, $password, $dbname);

  if(isSet($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn,"SELECT * FROM tblaccounts WHERE username='$username' AND password='$password'");
    $res = mysqli_num_rows($query);

    if ($res == 1) {
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['userobj'] = mysqli_fetch_assoc($query);

        header('Location: http://localhost/pldt/pldtfam/production/index.php');
        exit;
    } else {
        echo 'Data does not match <br /> RE-Enter Username and Password';
        header("refresh:2; url=login.php");
    }
} else {


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log in</title>
    
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

    <link href="../build/css/custom.min.css" rel="stylesheet">
</head>
<body class="login">
    <div>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form method='POST' action='login.php'>
              <h1>Log in</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" name='username' required/>
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" name='password' required/>
              </div>
              <div>
                <button type="submit" class="btn btn-submit btn-md" name="login" id="login" value="login">Log in</button>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
<?php
    }
?>