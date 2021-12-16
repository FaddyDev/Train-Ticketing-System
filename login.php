<?php require_once('includes/connection.php');  //include connection?>
<?php require_once('includes/session.php');  //include session?>
<?php
//form login submitted
		   if(isset($_POST['login'])){
			 
			  //form variables
			  $username = trim(mysqli_real_escape_string($connection,$_POST['email']));
			  $password = md5($_POST['password']);
			  
			  $query = "SELECT * FROM tblcustomers WHERE email = '$username' and password='$password'";
			  $result = mysqli_query($connection, $query) or die("Database query failed: " . mysqli_error($connection));
			  
			  $row = mysqli_fetch_array($result);
			  
			   if ($row > 0 ){ //User Found
			        $query1 = "SELECT * FROM tblcustomers WHERE email = '$username' and password='$password'";
					$result1 = mysqli_query($connection, $query1) or die("Database query failed: " . mysqli_error($connection));
			  
			       while($row1 = mysqli_fetch_array($result1)){ $_SESSION['userid'] =  $row1['id']; }
				   
				   header("Location: account.php");
				    }
					else{ //User Not Found
						
						$error_login = true; 
						}
		   }
?>
<?php require_once('includes/top-template.php'); //include the template top ?>
<div class="container">
<div class="col-md-4">
<?php require_once('includes/sidebar-search.php'); ?>

</div>

<div class="col-md-8">
<div class="col-md-6">
 <h2>Login Form</h2>
 <p>Please Enter your Email and Password inorder to login</p>
  <?php if(isset($error_login)) {  ?>
  <div class="alert alert-danger">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Access Denied!</strong> Invalid email OR password.
  </div>
  <?php } ?>
               <form action="login.php" method="post" >
                
               
                <input type="email" class="form-control half-width"  placeholder="Email." name="email" required><br> 
                <input type="password" class="form-control half-width" placeholder="Password." name="password" required><br>
                <button type="submit" class="btn btn-primary" name="login">Login</button>
                | <a href="register.php">Register</a>
                </form>
 
   </div>
   </div>
   <hr style="clear:both;margin: 10px 0px;" /> 
 </div>
<?php require_once('includes/footer-template.php'); //include footer template ?>
