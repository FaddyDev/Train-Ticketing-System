<?php require_once('../includes/connection.php'); ?>
<?php require_once('../includes/session.php'); ?>
<?php 
           //form login submitted
		   if(isset($_POST['login_btn'])){
			 
			  //form variables
			  $username = trim(mysqli_real_escape_string($connection,$_POST['username']));
			  $password = md5($_POST['pwd']);
			  
			  $query = "SELECT * FROM tblusers WHERE username = '$username' and password='$password'";
			  $result = mysqli_query($connection,$query) or die("Database query failed: " . mysqli_error($connection));
			  
			  $row = mysqli_fetch_array($result);
			  
			   if ($row > 0 ){ //User Found
				   $_SESSION['adminid'] =  true;
				   
				   header("Location: index.php");
				    }
					else{ //User Not Found
						
						$error_login = true; 
						}
		   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Contact List</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/custom.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/datetime.js"></script>
</head>
<body    style ="background-color: #287D25;" onload=display_ct();>
<!-- header -->
<header>
<div class="container" style="padding:0px;">

 <div class="page-header">
  <h1 align="center" class="logo-img"><img src="../img/logo.png" /></h1> 
 
  <ul class="nav sign-nav">
  <li class="date-time"><span id='ct' ></span></li>
  </ul>


  </div>
 
 
 </div>
</header>
<!-- header --> 

<div class="container" >
  <hr/>
          
        

          <div class="col-md-4" style="padding: 10px;margin-top: 20px;" >
          <h2>Administrator Login Form</h2>
          
		  
		  <?php if(isset($error_login)) {  ?>
          <div class="alert alert-danger">
          <strong>Access Denied!</strong> Wrong Username OR Password
          </div>
          <?php } ?>
          
          
             <form role="form" action="login.php" method="post" >
              <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" required>
              </div>
              <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" name="pwd" required>
              </div>
            
            
              <button type="submit" name="login_btn" class="btn btn-primary">Login</button>
            </form>
            </div>


</div>
<footer class="footer">
      <div class="container">
       <hr/>
        <p class="text-muted">2016 &copy; Sidney Masaka</p>
      </div>
 </footer> 
</body>
</html>