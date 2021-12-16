<?php require_once('includes/connection.php');  //include connection?>
<?php require_once('includes/session.php');  //include session?>
<?php 
           //submitted sign up form
		   if(isset($_POST['register'])){
			   
			   //form varible
			   $title =  mysqli_real_escape_string($connection,$_POST['title']);
			   $firstname = ucfirst(mysqli_real_escape_string($connection,$_POST['firstname']));
			   $lastname =  ucfirst(mysqli_real_escape_string($connection,$_POST['lastname']));
			   $gender =  mysqli_real_escape_string($connection,$_POST['gender']);
			   $phone =  mysqli_real_escape_string($connection,$_POST['tel']);
			   $email =  mysqli_real_escape_string($connection,$_POST['email']);
			   $password =  md5(mysqli_real_escape_string($connection,$_POST['password'])); //encrypt password
			   
			   $query = "INSERT INTO tblcustomers ( title, firstname, lastname, gender , phone, email , password) 
			                                        VALUES
			                                       ( '{$title}', '{$firstname}' , '{$lastname}' , '{$gender}', '{$phone}', '{$email}', '{$password}')";
		       $result = mysqli_query($connection, $query) or die("Query failed " . mysqli_error($connection));
		       header("Location: account.php");
			   
			   }//

 ?>

<?php require_once('includes/top-template.php'); //include the template top ?>


<div class="container">
<div class="col-md-4">
<?php require_once('includes/sidebar-search.php'); ?>

</div>
<div class="col-md-8">
 <h2>Registration Form</h2>
 <p>Please Complete the form to sign up</p>
        
                
     <form action="register.php" name="register_form" onsubmit="return validate_register_form();" method="post">
      <label> Select Title: </label>        		
      
	  <select class="form-control" style="width:30%;"  name="title">
        <option></option>
        <option>Mr.</option>
        <option>Mrs.</option>
        <option>Miss</option>
        <option>Ms</option>
      </select><br>
      
    <label> Enter First Name: </label>
    <input type="text" class="form-control" placeholder="Firstname :" name="firstname" ><br>
     
    <label>Enter Last Name: </label> 
    <input type="text" class="form-control" placeholder="Lastname :" name="lastname" ><br>
    
   
    <label>Select Gender:<br>
    <input name="gender" type="radio" value="Male">
    Male </label>
    <label>
    <input name="gender" type="radio" value="Female">
    Female</label><br>
 
    <label> Enter Telephone: </label>
    <input type="text"  class="form-control" placeholder="Telephone :" name="tel" id="phone" onKeyup="isNumeric()"  autofocus onblur="isNumeric(document.getElementById('phone'),'Invalid Phone number OR remove spaces!');"  ><br>
   
   <label> Enter Email: </label> 
    <input type="email" class="form-control" placeholder="Email :" name="email" ><br>
     
    <label> Enter Password: </label>
    <input type="password" class="form-control" placeholder="Password :" name="password" ><br>
   
    <label> Enter Confirm Password: </label>
    <input type="password" class="form-control" placeholder="Confirm Password :" name="cpass" ><br>
  
  
     
    <input name="register" class="btn btn-primary"  type="submit"  value="Submit">
    
    <input name="Reset" class="btn btn-warning" type="reset" id="Reset" value="Refresh">
   
</form>
 <br />
 </div>
 
 
 <hr style="clear:both;margin: 10px 0px;" /> 
 
</div>
  
 
  
<?php require_once('includes/footer-template.php'); //include footer template ?>
