<?php require_once('includes/connection.php');  //include connection?>
<?php require_once('includes/session.php');  //include session?>
<?php confirm_logged_in();  //confirm user has logged in 
      $session_id = $_SESSION['userid'];
?>
<?php 
           //submitted sign up form
		   if(isset($_POST['updateinfo'])){
			   
			   //form varible
			   $title =  mysqli_real_escape_string($connection,$_POST['title']);
			   $firstname = ucfirst(mysqli_real_escape_string($connection,$_POST['firstname']));
			   $lastname =  ucfirst(mysqli_real_escape_string($connection,$_POST['lastname']));
			   $gender =  mysqli_real_escape_string($connection,$_POST['gender']);
			   $phone =  mysqli_real_escape_string($connection,$_POST['tel']);
			   $email =  mysqli_real_escape_string($connection,$_POST['email']); 
			   
			   $query = "UPDATE tblcustomers SET title = '{$title}' , firstname = '{$firstname}' , 
			   lastname = '{$lastname}', gender = '{$gender}', phone = '{$phone}' , email ='{$email}'  WHERE id = $session_id";  
		       $result = mysqli_query($connection, $query) or die("Query failed " . mysqli_error($connection));
		       header("Location: account.php");
			   
			   }//
			   
			   elseif(isset($_POST['changepass'])){
				    $password =  md5(mysqli_real_escape_string($connection,$_POST['password'])); //encrypt password
				    $query = "UPDATE tblcustomers SET password = '{$password}'    WHERE id = $session_id";  
		            $result = mysqli_query($connection, $query) or die("Query failed " . mysqli_error($connection));
		            header("Location: account.php");
				   
				   }

 ?>


<?php require_once('includes/top-template.php'); //include the template top ?>


<div class="container">

<div class="col-md-4">
 <h2>Account</h2>

               
     <?php 
	          $query = "SELECT * FROM tblcustomers WHERE id = $session_id";
			  $result = mysqli_query($connection, $query) or die("Database query failed: " . mysqli_error($connection));  
			  while($row = mysqli_fetch_array($result)){
			  ?>       
                      
     <form action="account.php" method="post" onSubmit="return alert('Info Updated successfully');">
      <label>Select Title: </label>        		
      
	  <select class="form-control" style="width:30%;" placeholder="title" name="title">
        <option><?php echo $row['title']; ?></option>
        <option>Mr.</option>
        <option>Mrs.</option>
        <option>Miss</option>
        <option>Ms</option>
      </select><br>
      
  <label>Enter firstname: </label>    
   
    <input type="text" class="form-control" placeholder="Firstname :" name="firstname" value="<?php echo $row['firstname']; ?>" required=""><br>
     <label>Enter lastname: </label>   
    <input type="text" class="form-control" placeholder="Lastname :" name="lastname" value="<?php echo $row['lastname']; ?>" required=""><br>
    
   <?php 
      
	  $gender = $row['gender'];
	  
	  if($gender == "Male"){ $male = "checked";} else { $female = "checked";}
    ?>
  
    <label>Select Gender:<br>
    <input name="gender" type="radio" value="Male" <?php if(isset($male)) echo $male; ?> >
    Male </label>
    <label>
    <input name="gender" type="radio" value="Female"  <?php if(isset($female)) echo $female; ?> >
    Female</label><br>
    <label>Enter phone number: </label>   
    <input type="text"  class="form-control" placeholder="Telephone :" value="<?php echo $row['phone']; ?>" name="tel" id="phone" onKeyup="isNumeric()"  autofocus onblur="isNumeric(document.getElementById('phone'),'Invalid Phone number OR remove spaces!');"  required=""><br>
    <label>Enter email: </label>   
    <input type="email" class="form-control" placeholder="Email :"  value="<?php echo $row['email']; ?>" name="email" required="" readonly><br>
    
     <input name="updateinfo" class="btn btn-primary"  type="submit"  value="Update">
    
    </form>
    
    <h2>Change Password</h2>
    
    <form action="account.php" method="post" name="change_password_form" onSubmit="return validate_edit_password();"> 
   <label>Enter password: </label>   
    <input type="password" class="form-control" placeholder="Password :"  name="password" required=""><br>
   <label>Enter confirm password: </label>   
    <input type="password" class="form-control" placeholder="Confirm Password :" name="cpass" required=""><br>
  
  
     
    <input name="changepass" class="btn btn-primary"  type="submit"  value="Change Password">
    
    <input name="Reset" class="btn btn-warning" type="reset" id="Reset" value="Refresh">
   
</form>
<?php  } ?>
<br>
<br>
 
 </div>
 
 
 <div class="col-md-8">
 
  <h2>Tickets Transactions</h2>
<table class="table table-striped">
                    <thead>
                      <tr> 
                        <th>Ticket Info</th>
                        <th>DateTime</th>
                        <th>To</th>
                        <th>From</th>
                        <th style="text-align:center">Action</th>
                      </tr>
                    </thead>
                    <tbody class="searchable"> 
                    <?php 
					$sql ="SELECT * FROM tbltransactions WHERE user_id = $session_id";
			        $res = mysqli_query($connection, $sql) or die("Query failed " . mysqli_error($connection)); 
					while($row1 = mysqli_fetch_array($res)){
					$transaction_id = $row1['transaction_id'];
					$query = "SELECT * FROM view_tickets WHERE transaction_id =  $transaction_id";
			        $result = mysqli_query($connection, $query) or die("Database query failed: " . mysqli_error($connection));
					while ($row = mysqli_fetch_array($result)) {
					
					 ?>
                     
                      <tr> 
                        <td>
                          <strong>No.</strong><?php echo $row['id']; ?><br/>
                          <strong>Seat No.</strong><?php echo $row['seat_no']; ?><br/>
                          <strong>Cost. KES </strong><?php echo $row['ticket_cost']; ?>/-
                       </td>
                       
                         <td><?php echo $row['schedule_date'].'-'.$row['schedule_time']; ?><br />
                         <strong><small>(<?php echo $row['ticket_type'];?>)</small></strong></td>
                         <td><?php $to = $row['train_to_id'];
						$sql3 = "SELECT * FROM tblstations WHERE id = $to";
			            $stations = mysqli_query($connection, $sql3) or die("Database query failed: " . mysqli_error($connection));
					    while ($station = mysqli_fetch_array($stations)) {
					         echo $station['station_name'].'<br/> ('.$station['station_city'].')';	
					          }
					?></td>
                        <td><?php $from = $row['train_from_id'];
						$sql3 = "SELECT * FROM tblstations WHERE id = $from";
			            $stations = mysqli_query($connection, $sql3) or die("Database query failed: " . mysqli_error($connection));
					    while ($station = mysqli_fetch_array($stations)) {
					         echo $station['station_name'].'<br/> ('.$station['station_city'].')';	
					          } ?></td>
                        <td>
                        <small><b> Purchased on -<br /><?php 
						 	echo  $row1['transaction_date'].'<br>('.$row1['transaction_code'].')';?></b></small><br />
                            <button type="button" class="btn btn-info btn-sm" onclick="javascript:printDiv('print<?php echo $row['id']; ?>')"><span class="glyphicon glyphicon-print"></span> Print</button>
                      <!-- ***** PRINT TICKET ** -->
                       <div id="print<?php echo $row['id']; ?>" style="display:none;">
                       <table>
                          <thead>
                      <tr> 
                        <th>Ticket Info</th>
                        <th>DateTime</th>
                        <th>To</th>
                        <th>From</th>
                        <th></th>
                      </tr>
                    </thead>
                       <tbody>
                       <tr> 
                        <td>
                          <strong>No.</strong><?php echo $row['id']; ?><br/>
                          <strong>Seat No.</strong><?php echo $row['seat_no']; ?><br/>
                          <strong>Cost. KES </strong><?php echo $row['ticket_cost']; ?>/-
                       </td>
                       
                         <td><?php echo $row['schedule_date'].'-'.$row['schedule_time']; ?><br />
                         <strong><small>(<?php echo $row['ticket_type'];?>)</small></strong></td>
                         <td><?php $to = $row['train_to_id'];
						$sql3 = "SELECT * FROM tblstations WHERE id = $to";
			            $stations = mysqli_query($connection, $sql3) or die("Database query failed: " . mysqli_error($connection));
					    while ($station = mysqli_fetch_array($stations)) {
					         echo $station['station_name'].'<br/> ('.$station['station_city'].')';	
					          }
					?></td>
                        <td><?php $from = $row['train_from_id'];
						$sql3 = "SELECT * FROM tblstations WHERE id = $from";
			            $stations = mysqli_query($connection, $sql3) or die("Database query failed: " . mysqli_error($connection));
					    while ($station = mysqli_fetch_array($stations)) {
					         echo $station['station_name'].'<br/> ('.$station['station_city'].')';	
					          } ?></td>
                        
                        <td>
                        <small><b> Purchased on -<br /><?php 
						 	echo  $row1['transaction_date'].'<br>('.$row1['transaction_code'].')';?></b></small><br /></td>
                            </tr>
                            </tbody>
                      </table>
                       </div>
                      <!-- ***** end. PRINT TICKET ** --> 
                       </td>
                      </tr>
                     <?php }
					}?>
                    </tbody>
                  </table>           
 
 
 </div>
  <hr style="clear:both;margin: 10px 0px;" /> 
 
</div>
  
 
  
<?php require_once('includes/footer-template.php'); //include footer template ?>
