<?php require_once('../includes/connection.php'); ?>
<?php require_once('../includes/session.php'); ?>
<?php confirm_admin_logged_in(); //confirm admin has logged in ?>
<?php 
       if(isset($_POST['update_username_btn'])){
		   $username =  mysqli_real_escape_string($connection,$_POST['username']);
		   
		   
		   $query = "UPDATE tblusers SET username = '$username' WHERE id = 1";				   
		   $result = mysqli_query($connection,$query);
		   header("Location: settings.php");
		   }
		   elseif(isset($_POST['update_password_btn'])){
			    
				   $password =  mysqli_real_escape_string($connection, $_POST['pwd1']);
				   $password = MD5($password);
		   
		   $query = "UPDATE tblusers SET password = '$password' WHERE id = 1";				   
		   $result = mysqli_query($connection,$query);
		   header("Location: settings.php");
			   }
?>
<?php require_once('includes/top-template.php'); //include the template top ?>
     <div class="container" style="height:100vh;">
       <div class="col-md-3">
       <h2>NAVIGATION</h2>
       <?php require_once('includes/nav.php'); ?>

 
       </div>

            <div class="col-md-9">
             <h2>Update Username</h2>
             
              
            
              <form role="form" action="settings.php" method="post"  onSubmit="return alert('Username Updated Successfully')">
              <div class="form-group">
                <label for="username">Enter Username:</label>
                <input type="text" class="form-control" style="width: 40%;" value="<?php 
				$query = "SELECT * FROM tblusers WHERE id = 1 ";				   
		        $result = mysqli_query($connection,$query);
			    while($row = mysqli_fetch_array($result)) { echo  $row['username']; }
				 ?>" name="username" autocomplete="off" required>
              </div>
            
             <button type="submit" name="update_username_btn" class="btn btn-primary">Submit</button>
            </form>
            
            </div>
            
            <div class="col-md-6">
             <h2>Change Password</h2>
             <hr>
             <script>
			  function chkpassword(){
				  var PWD = document.changepasswordForm.pwd1.value;
				  var PWD2 = document.changepasswordForm.pwd2.value;
				  
				  if(PWD != PWD2){
					  alert('Passwords Do not Match');
					  return false;
					  }
					  
					if( (PWD == "") || (PWD == "")){
						
						alert('Please Enter your new password and confirm password');
						return false;
						}
				   
				   alert('Password Has been updated successfully');
				   return true;
				  }
				  

			 </script>
              <form role="form" action="settings.php" name="changepasswordForm" onSubmit="return chkpassword();" method="post"  >
               <div class="form-group">
                <label for="pwd">Enter Password:</label> 
                <input type="password" class="form-control" name="pwd1" value=""  readonly   onfocus="this.removeAttribute('readonly');">
              </div>
              
              <div class="form-group">
                <label for="pwd">Enter Confirm Password:</label>
                <input type="password" class="form-control" name="pwd2" value=""  readonly   onfocus="this.removeAttribute('readonly');" >
              </div>
            
            
              <button type="submit" name="update_password_btn" class="btn btn-primary">Submit</button>
            </form>
            <br>
            </div>


</div>
  
  
<?php require_once('includes/footer-template.php'); //include footer template ?>