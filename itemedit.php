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
 if (isset($_POST['btn_edit'])) {
  $budgetitem_id = $_POST['id'];
   $item =$_POST['item'];
   $dated = $_POST['dated'];
   $description = $_POST['description'];
   $amount = $_POST['amount'];
   $budgettype_id = $_POST['budgettype_id'];
   $user_id = $_SESSION['mybudgetapp_userID'];

   //update item
   $query = "UPDATE tbl_budget_items SET item = '{$item}', dated = '{$dated}', description = '{$description }',  amount = '{$amount}', budgettype_id = '{$budgettype_id}', user_id = '{$user_id}'
             WHERE budgetitem_id = $budgetitem_id";
   $result = mysqli_query($connection,$query) OR die (mysqli_error($connection));

   $sessionid = $_SESSION['mybudgetapp_userID'];

   $query = "SELECT * FROM tbl_users WHERE id = $sessionid ";
   $result = mysqli_query($connection,$query) OR die (mysqli_error($connection));

   header("Location: itemedit.php?success=1&id=$budgetitem_id");

 //fetch user info;
 while ($row=mysqli_fetch_array($result)) {
    $fname = $row['fname'];
    $lname = $row['lname'];
    $email = $row['email'];
    $password = $row['password'];
 }

   header("Location: index.php?success=1");

   
 }

 //edit item
 if (isset($_GET['id'])) {
   $selectedid = $_GET['id'];
 
}
 else {
  header("Location: index.php");
 }

 //fetch data
 $query = "SELECT * FROM tbl_budget_items JOIN tbl_budgettype 
          ON tbl_budgettype.budgettype_id = tbl_budget_items.budgettype_id 
          and  budgetitem_id = $selectedid";
 $result = mysqli_query($connection,$query) OR die (mysqli_error($connection));
 
 while ($row = mysqli_fetch_array($result)) {
   $fetch_item = $row['item'];
   $fetch_dated= $row['dated'];
   $fetch_description = $row['description'];
   $fetch_amount = $row['amount'];
   $fetch_budgettype_id = $row['budgettype_id'];
   $fetch_budgettype_name = $row['budgettype_name'];
   
   # code...
 }

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body style="background-color: #000;">

<div class="container" >
	<div class="row">
		
		<div class="col-md-4 content" >
      <div class="row">
        <div class="col-md-12">
          <h3 class="float-right">Welcome <?php echo $fname?> | <a href="logout.php" style="font-family: 'Roboto Condensed' ,sans-serif;font-size: 1.3rem;">Logout</a></h3>
          </div>
      </div>
      
   

 <?php if (isset($_GET['success'])) { ?>
       <div class="alert alert-success">
             <em>Item edited successfully</em>
           </div> 
      <?php } ?>
                <h5 style="text-align: center;">MY BUDGET ITEMS</h5>

      
      <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">

        <input type="hidden" name="id" value="<?php echo $selectedid ;?>">

      <label>Add item</label>
      <input type="text" name="item" class="form-control" value="<?php echo $fetch_item ;?>" placeholder="Enter your item" required="">

      <label>Date</label>
      <input type="date" name="dated" class="form-control" value="<?php echo $fetch_dated; ?>" placeholder="Enter date" required="">

      <label>Description</label>
      <input type="text" name="description" class="form-control" value="<?php echo $fetch_description; ?>" placeholder="Enter item description" required="">

      <label>Amount</label>
      <input type="number" name="amount" class="form-control" value="<?php echo $fetch_amount; ?>" placeholder="Enter amount" required="">

      <label>Budget type</label>
      <select name="budgettype_id" class="form-control" required=""> 
        <option value="<?php echo $fetch_budgettype_id; ?>"><?php echo $fetch_budgettype_name; ?></option>
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
          <button type="submit" class="btn btn-success" name="btn_edit" class="form-control" style="width: 100%; margin-bottom: 20PX;">EDIT ITEM</button>
        </div>
        <div class="col-md-6">
          <!-- <a href="index.php" class="btn btn-primary" name="btn_clear" class="form-control" style="width: 100%; margin-bottom: 20PX;">CLEAR</a> -->
        </div>
      </div>
</form>
      

    </div>

   <div class="col-md-8 items " style="background-color: #fff;margin-top: 50px; padding: 30px;">
     <h2>My budget Items</h2>
     <table class="table table-striped table-sm">
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
                     <a  href="itemedit.php?id='.$row['budgetitem_id'].'" class="btn btn-success btn-sm">
                     <i class="fa fa-edit"></i>
                     </a>  

                     <a href="index.php?del_id='.$row['budgetitem_id'].'" class="btn btn-danger btn-sm" onclick="return confirm (\'Delete this?\')"><i class="fa fa-trash"></i></a> 
                     </td>';
                echo '<tr>';

                $i++;
             }
          ?>
         
       </tbody>
     </table>
   </div>
     


			
		</div>
		

		
	</div>

</body>
</html>