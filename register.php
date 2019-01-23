<?php
   require_once ("includes/connection.php");

//form data
 if (isset($_POST['btn_register'])) {
   $fname = $_POST['fname'];
   $lname = $_POST['lname'];
   $email = $_POST['email'];
   $password = $_POST['password'];
   $cpassword = $_POST['cpassword'];


    $errors = array();
    if (empty($fname)) {
      $errors[] = "Please enter your first name";
    }
 
    if (empty($lname)) {
    	$errors[] = "Please enter your last name";
    }

    if (empty($email)) {
    	$errors[] = "Please enter your email";
    }

    if (empty($password)) {
    	$errors[] = "Please enter your password";
    }

    if (empty($cpassword)) {
    	$errors[] = "Please confirm your password";
    }

    if ($password!=$cpassword) {
    	$errors[] = "Psswords do not match";
    }
    
    if (empty($errors)) {
    	//insert into db
       $query = "INSERT INTO tbl_users (fname, lname, email, password) 
                 VALUES ('{$fname}', '{$lname}', '{$email}', md5('$password') )";

       $result = mysqli_query($connection,$query) OR die(mysqli_connect($connection));

       header("Location: register.php?success=1");


    }



 }

?>




<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registration form</title>
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
			<h4 style="margin-top: 50px;">BUDGET APP</h4>
			<center><img src="images/budget.PNG" width="150px" height="150px"></center>
			<P>IT WILL ONLY TAKE A MINUTE,SIGN UP NOW</P>

			<h5>You already signed up?Proceed to login</h5>
			<center><a href="login.php" class="btn btn-danger" class="form-control" name="btn_login" target="_blank" style="width: 50%; margin-top: 10px;">LOGIN</a></center>
			</div>
		
	

		<div class="col-md-6 app-section">
			<h4>SIGN UP FORM</h4>
			<?php if (!empty($errors)) { ?>
			   <div class="alert alert-danger">
				 <p>Please correct the following errors</p>
				  <ol>
					<?php 
                         foreach ($errors as $key => $value) {
                         	echo '<li>'.$value.'</li>';
                         }
					?>
				  </ol>
			    </div>
			<?php } ?>

			<?php if(isset($_GET['success'])){ ?>
				<div class="alert alert-success">
					Registered successfully,proceed to <a href="login.php">Login</a>
				</div>
		    <?php } ?>

			<form method="post" action="<?php echo  htmlspecialchars($_SERVER['PHP_SELF']);?>">
				<label>First Name</label>
				<input type="text" name="fname" placeholder="Enter your first name" class="form-control" value="<?php if(isset($_POST['fname'])){ echo $_POST['fname'];} ?>">

				<label>Last Name</label>
				<input type="text" name="lname" placeholder="Enter your last name" class="form-control" value="<?php if(isset($_POST['lname'])){ echo($_POST['lname']); } ?>">

				<label>Email</label>
				<input type="email" name="email" placeholder="Enter your email address" value="<?php if(isset($_POST['email'])){ echo($_POST['email']);} ?>" class="form-control">

				<label>Password</label>
				<input type="password" name="password" placeholder="Enter your password" class="form-control" value="<?php if(isset($_POST['password'])){ echo $_POST['password'];} ?>">

				<label>Confirm Password</label>
				<input type="password" name="cpassword" placeholder="Confirm your password" class="form-control" value="<?php if(isset($_POST['cpassword'])){ echo $_POST['cpassword'];} ?>"><br>

				<center><button type="submit" name="btn_register" class="btn btn-primary" style="width: 50%; text-align: center;">REGISTER</button></center>
			</form>
		</div>
	</div>
</div>

</body>
</html>