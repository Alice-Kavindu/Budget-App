<?php
 require_once ("includes/connection.php");
 require_once ("includes/session.php");

  if (isset($_POST['btn_login'])) {
  	$email = $_POST['email'];
  	$password = md5($_POST['password']);
  	global $result;

  	$query = "SELECT * FROM tbl_users WHERE email='$email' and password ='$password' ";
  	$result = mysqli_query($connection,$query) OR die(mysqli_error($connection));
    //$rows = mysqli_fetch_array($result);
    $rowcount = mysqli_num_rows($result);

    // if ($rows) {
    // 	header("Location: index.php");
    // }

    if ($rowcount>0) {
    	while ($row=mysqli_fetch_array($result)) {
    		$_SESSION['mybudgetapp_userID'] = $row['id'];
    		header("Location: index.php");
    	}
    }
   
    else {
    	//access denied
    	$error_login = true;
    }

   
  }


?>



<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<div class="container">
	<div class="row">

		<div class="col-md-6 logo-section">
			<h4>BUDGET APP</h4>
			<center><img src="images/budget.PNG" width="150px" height="150px"></center>
			<h4>LET'S GET YOU SET UP</h4>
			<P>IT WILL ONLY TAKE A MINUTE,SIGN UP NOW</P>

			<h5>Don't have an account?</h5>
			<center><a href="register.php" class="btn btn-primary" class="form-control" name="btn_register" target="_blank" style="width: 50%; margin-top: 10px;">REGISTER HERE</a></center>
			</div>
		
	

		<div class="col-md-6 app-section">
			<?php if (isset($error_login)) { ?>
				<div class="alert alert-danger">ACCESS DENIED PLEASE TRY AGAIN</div>
			<?php } ?>

			<h4>LOGIN FORM</h4>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">

			<label>Email</label>
			<input type="email" name="email" placeholder="Enter your email address" required="" class="form-control">

			<label>Password</label>
			<input type="password" name="password" placeholder="Enter your password" required="" class="form-control">
			<br>

			<center><button type="submit" name="btn_login" class="btn btn-danger" style="width: 50%; text-align: center;">LOGIN</button></center>

			</form>
		</div>
	</div>
</div>

</body>
</html>