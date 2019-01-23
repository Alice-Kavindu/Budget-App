<?php
 require_once ("includes/connection.php");
 require_once ("includes/session.php");
 confirm_logged_in_user();

 $session = $_SESSION['mybudgetapp_userID'];

 $sessionid =  $_SESSION['mybudgetapp_userID'];

   //delete account
   if(isset($_GET['deleteid'])){//
    
    $deleteid = $_GET['deleteid'];
    //delete
    $query ="DELETE FROM tbl_users WHERE id = $deleteid";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

    header("Location: logout.php");

   }//

   //update password 
   if(isset($_POST['btn_password'])){//
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    //error array
    $errors = array();

     if(empty($password)){
    $errors[] = "Please enter your password";
    }

    if(empty($cpassword)){
    $errors[] = "Please confirm your password";
    }

    if(($password!=$cpassword) && (!empty($password)) && (!empty($cpassword))) {
      $errors[]="PASSWORDS DO NOT MATCH";
    }

     if(empty($errors)){
      //update data into the database
    
      $query = "UPDATE tbl_users SET password= md5('$password') WHERE id = $sessionid";
      $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

      header("Location: index.php?success=1");
        
      
     }


   }//

   // update info 
   if(isset($_POST['btn_update'])){//

     //form data
   	$fname = $_POST['fname'];
   	$lname = $_POST['lname'];
    $email = $_POST['email'];
    //error array
    $errors = array();
   
    if(empty($fname)){
    $errors[] = "Please enter your fname";
    }

    if(empty($lname)){
    $errors[] = "Please enter your lastname";
    }

     if(empty($email)){
    $errors[] = "Please enter your email";
    }
   
    

    if(empty($errors)){
      //update data into the database

      $query = "UPDATE tbl_users SET fname='{$fname}', lname='{$lname}',  email= '{$email}' 
                WHERE id = $sessionid";
      $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

      header("Location: index.php?success=1");
        
      
    }


  }//

?>






<!DOCTYPE html>
<html lang="en">
<head>
  <title>Profile form</title>
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

		<div class="col-md-6 app-section">
			<h4 style="font-size: 1.5rem">UPDATE YOUR PROFILE</h4>
			<form>
				<label>First Name</label>
				<input type="text" name="fname" placeholder="enter your first name" value="" class="form-control">

				<label>Last Name</label>
				<input type="text" name="lname" placeholder="enter your last name" value="" class="form-control">

				<label>Email</label>
				<input type="email" name="email" placeholder="enter your email address" value="" class="form-control">
				<br>

				<center><button type="submit" name="btn_update" class="btn btn-primary" style="width: 50%; text-align: center;">UPDATE PROFILE</button></center>
			</form>
		</div>

		<div class="col-md-6 logo-section">
			<h4>CHANGE PASSWORD</h4>
			<form>
			<label>Password</label>
			<input type="password" name="password" placeholder="enter your password" value="" class="form-control">

			<label>Confirm Password</label>
			<input type="password" name="cpassword" placeholder="confirm your password" value="" class="form-control"><br>
           
            <center><button type="submit" name="btn_password" class="btn btn-success" style="width: 50%; text-align: center;">UPDATE PASSWORD</button></center><br>

           <center> <a class="btn btn-danger" onclick="return confirm('Delete Account?');" style="width:50%;color: #fff;" href="?deleteid=<?php echo $sessionid; ?>">DELETE ACCOUNT</a>
           </center>
            </form>
        
		</div>
	</div>
</div>

</body>
</html>