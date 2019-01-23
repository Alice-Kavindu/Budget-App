<?php
 require_once ("includes/connection.php");
 require_once ("includes/session.php");
 confirm_logged_in_user();

 $sessionid = $_SESSION['mybudgetapp_userID'];

 $query = "SELECT * FROM tbl_users WHERE id = $sessionid ";
 $result = mysqli_query($connection,$query) OR die (mysqli_error($connection));

 //fetch user info;
 while ($row=mysqli_fetch_array($result)) {
    $fname = $row['fname'];
    $lname = $row['lname'];
    $email = $row['email'];
    $password = $row['password'];
 }

 //budget items
 if (isset($_POST['btn_add'])) {
   $item =$_POST['item'];
   $dated = $_POST['dated'];
   $description = $_POST['description'];
   $amount = $_POST['amount'];
   $budgettype_id = $_POST['budgettype_id'];
   $user_id = $_SESSION['mybudgetapp_userID'];

   $query = "INSERT INTO tbl_budget_items (item, dated, description, amount, budgettype_id, user_id )
             VALUES ('{$item}', '{$dated}', '{$description }', '{$amount}', '{$budgettype_id}', '{$user_id}' )";
   $result = mysqli_query($connection,$query) OR die (mysqli_error($connection));

   $sessionid = $_SESSION['mybudgetapp_userID'];

   $query = "SELECT * FROM tbl_users WHERE id = $sessionid ";
   $result = mysqli_query($connection,$query) OR die (mysqli_error($connection));

 //fetch user info;
 while ($row=mysqli_fetch_array($result)) {
    $fname = $row['fname'];
    $lname = $row['lname'];
    $email = $row['email'];
    $password = $row['password'];
 }

   header("Location: index.php?success=1");

   
 }

 //delete item
 if (isset($_GET['del_id'])) {
   $delete_id = $_GET['del_id'];

   $query = "DELETE FROM tbl_budget_items WHERE budgetitem_id = $delete_id";
   $result = mysqli_query($connection,$query) OR die (mysqli_error($connection));

   header("Location: index.php");
 }
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" type="text/css" href="css/style.css">
  

</head>
<body style="background-color: #000;">

<div class="container" >
	<div class="row">
		
		<div class="col-md-4 content" >
      <div class="row">
        <!-- <div class="col-md-6">
          <a href="profile.php" class="float-left"><i class="fas fa-cogs"></i></a>
        </div> -->
        <div class="col-md-12">
          <h3 class="float-right">Welcome <?php echo $fname?> | <a href="logout.php" style="font-family: 'Roboto Condensed' ,sans-serif;font-size: 1.3rem;">Logout</a></h3>
          </div>
      </div>
      
      <?php if (!empty($errors)) { ?>
        <div class="alert alert-danger">
           <p>Please Insert the following:</p>
             <ol>
              <?php
               foreach ($errors as $key => $value) {
                 echo '<li>'.$value.'</li>';
               }
              ?>
             </ol>
        </div>
      <?php }?>

 <?php if (isset($_GET['success'])) { ?>
       <div class="alert alert-success">
             <em>Item added successfully</em>
           </div> 
      <?php } ?>
        
      
      <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">

      <label>Add item</label>
      <input type="text" name="item" class="form-control" value="<?php if(isset($_POST['additem'])){ echo $_POST['additem'];} ?>" placeholder="Enter your item" required="">

      <label>Date</label>
      <input type="date" name="dated" class="form-control" value="<?php if(isset($_POST['date'])) { echo $_POST['date'];}?>" placeholder="Enter date" required="">

      <label>Description</label>
      <input type="text" name="description" class="form-control" value="<?php if(isset($_POST['describe'])){ echo$_POST['describe'];}?>" placeholder="Enter item description" required="">

      <label>Amount</label>
      <input type="number" name="amount" class="form-control" value="<?php if(isset($_POST['amount'])){echo $_POST['amount'];}?>" placeholder="Enter amount" required="">

      <label>Budget type</label>
      <select name="budgettype_id" class="form-control" required=""> 
        <option></option>
          <?php
             $query = "SELECT * FROM tbl_budgettype";
             $result = mysqli_query($connection,$query) OR die (mysqli_error($connection));

             while ($row=mysqli_fetch_array($result)) {
                echo '<option value="'.$row['budgettype_id'].'" >'.$row['budgettype_name'].'</option>';
             }
          ?>

      </select><br>

      <div class="row">
        <div class="col-md-6">
          <button type="submit" class="btn btn-success" name="btn_add" class="form-control" style="width: 100%; margin-bottom: 20PX;">ADD ITEM</button>
        </div>
        <div class="col-md-6">
          <a href="index.php" class="btn btn-primary" name="btn_clear" class="form-control" style="width: 100%; margin-bottom: 20PX;">CLEAR</a>
        </div>
      </div>
</form>
      

    </div>

   <div class="col-md-8 items " style="background-color: #fff;margin-top: 50px; padding: 30px;">
     <h2 style="color: #ff4542;">My Budget Items</h2>
     <hr>
     <table class="table table-bordered table-hover table-sm" id="example">
       <thead>
         <tr>
           <th>#item</th>
           <th>Item</th>
           <th>dated</th>
           <th>description</th>
           <th>amount</th>
           <th>budgettype_id</th>
           <th>action</th>
         </tr>
       </thead>
       <tbody>
         <?php
             $query = "SELECT * FROM tbl_budget_items JOIN tbl_budgettype 
                      ON tbl_budgettype.budgettype_id = tbl_budget_items.budgettype_id 
                      WHERE user_id = $sessionid";
             $result = mysqli_query($connection,$query) OR die (mysqli_error($connection));
                
             $i = 1;
             while ($row=mysqli_fetch_array($result)) {
                echo '<tr>';
                echo '<td>'.$i.'</td>';
                echo '<td>'.$row['item'].'</td>';
                echo '<td>'.$row['dated'].'</td>';
                echo '<td>'.$row['description'].'</td>';
                echo '<td>'.$row['amount'].'</td>';
                echo '<td>'.$row['budgettype_name'].'</td>';

                echo '<td> 
                     <a  href="itemedit.php?id='.$row['budgetitem_id'].'" class="float-left">
                     <i class="fa fa-edit"></i>
                     </a> 
                    
                     <a href="index.php?del_id='.$row['budgetitem_id'].'" class="float-right" onclick="return confirm (\'Delete this?\')" style="color: red;">
                     <i class="fa fa-trash"></i>
                     </a> 
                     
                     </td>';
                echo '</tr>';

                $i++;
             }
          ?>
         
       </tbody>
     </table>

     <div class="total">
      <h5>Your total amount is: 
       <?php 
       $query = "SELECT SUM(amount) FROM tbl_budget_items";
       $result = mysqli_query($connection,$query) OR die (mysqli_error($connection));

       ?>
       </h5>
     </div>
   </div>
     


			
		</div>
		

		
	</div>

  <script>
    $(document).ready(function() {
    $('#example').DataTable();
} );
  </script>

</body>
</html>