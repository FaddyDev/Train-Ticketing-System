<?php require_once('../includes/connection.php'); ?>
<?php require_once('../includes/session.php'); ?>
<?php confirm_admin_logged_in(); //confirm admin has logged in ?>
<?php 
        //ADD New Train
	   if(isset($_POST['add_train'])){//
		  $train_number = mysqli_real_escape_string($connection,$_POST['train_number']);
		  $train_model = mysqli_real_escape_string($connection,$_POST['train_model']);
		  
		  
		 $query = "INSERT INTO tbltrains (train_number, train_model) VALUES ( '{$train_number}', '{$train_model}' )";
		 $result = mysqli_query($connection, $query);
		 header("Location: trains.php");
		 }//
		 
		 
		      //UPDATE / EDIT
			   elseif(isset($_POST['edit_btn'])){
				   $id = $_POST['id']; 
				    $train_number = mysqli_real_escape_string($connection, $_POST['train_number']);
		            $train_model = mysqli_real_escape_string($connection,$_POST['train_model']);
				   
				   $query = "UPDATE tbltrains SET train_number = '$train_number' , train_model = '$train_model' WHERE id = $id";				   
				   $result = mysqli_query($connection, $query);
				  
				   header("Location: trains.php");
				   
				   }
		 
		  
			 
			  //DELETE
	     	  elseif(isset($_GET['deleteid'])){
			  $id = mysqli_real_escape_string($connection,$_GET['deleteid']);
			  
			       $query = "DELETE FROM tbltrains WHERE id = $id";				   
				   $result = mysqli_query($connection, $query);
				  
				   header("Location: trains.php");
			   }

?>


<?php require_once('includes/top-template.php'); //include the template top ?>





 <div class="row">
   <div class="container" >
       <div class="col-md-3">
       <h2>NAVIGATION</h2>
       <?php require_once('includes/nav.php'); ?>

 
       </div>

            <div class="col-md-9">
        <h2>AVAILABLE TRAINS</h2>
     <form action="trains.php" method="post" >
     <label>Enter Train Number:</label>
      <input type="text" class="form-control add-todo" data-toggle="tooltip" placeholder="Enter Train Number" title="Enter Train Number"  name="train_number" style="width:50%;"  required><br>
     <label>Enter Train Model:</label>
      <input type="text" class="form-control add-todo" data-toggle="tooltip" placeholder="Enter Train Model"  title="Enter Train Model"  name="train_model" style="width:50%;"  required><br/>
      <button type="submit" class="btn btn-primary" name="add_train">Add Train</button>
      </form>
       <hr />    
    
   
        <h2>Edit Available Trains</h2>
                    <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Train Number</th>
                        <th>Train Model</th>  
                        <th style="text-align:center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    
                    <?php 
					$query = "SELECT * FROM tbltrains ORDER BY train_number";
			        $result = mysqli_query($connection, $query) or die("Database query failed: " . mysql_error($connection));
					$count = 1; 
			        while ($row = mysqli_fetch_array($result)) {
					
					 ?>
                      <form action="trains.php" method="post">
                      <input type="hidden" name="id" value="<?php echo $row['id']; ?>"  />
                <tr>
                <td><?php echo $count; ?></td>
                <td><input type="text" data-toggle="tooltip" placeholder="Enter Train Number" class="form-control" value= "<?php echo $row['train_number']; ?>" name="train_number" /> </td>
                <td><input type="text" data-toggle="tooltip" placeholder="Enter Train Model" class="form-control" value= "<?php echo $row['train_model']; ?>" name="train_model" /> </td>
                        
                        <td style="text-align:center;" >
                       
                       <button type="submit" data-toggle="tooltip" data-placement="top" title="Update" name="edit_btn" class="btn btn-info btn-xs"> <span class="glyphicon glyphicon-edit"></span> </button>
                       
                       <a href="trains.php?deleteid=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Delete this?')"> <span class="glyphicon glyphicon-trash"></span> </a></td>
                      </tr>
                      </form> 
                      <?php  
					  $count++; 
					  } ?>
                    </tbody>
                  </table>             
       
       </div>
</div>
  
 </div>
  
<?php require_once('includes/footer-template.php'); //include footer template ?>
