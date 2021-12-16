<?php require_once('../includes/connection.php'); ?>
<?php require_once('../includes/session.php'); ?>
<?php confirm_admin_logged_in(); //confirm admin has logged in ?>
<?php 
        //ADD New Destinations
	   if(isset($_POST['add_destinations'])){//
		  $destination_name = ucfirst(mysql_real_escape_string($_POST['destination_name']));
		 
		  
		  
		 $query = "INSERT INTO tbldestinations (destination_name) VALUES ( '{$destination_name}')";
		 $result = mysql_query($query, $connection);
		 header("Location: destinations.php");
		 }//
		 
		 
		      //UPDATE / EDIT
			   elseif(isset($_POST['edit_btn'])){
				   $id = $_POST['id']; 
				   $destination_name = ucfirst(mysql_real_escape_string($_POST['destination_name']));
				   
				   $query = "UPDATE tbldestinations SET destination_name = '$destination_name' WHERE id = $id";				   
				   $result = mysql_query($query, $connection);
				  
				   header("Location: destinations.php");
				   
				   }
		 
		  
			 
			  //DELETE
	     	  elseif(isset($_GET['deleteid'])){
			  $id = mysql_real_escape_string($_GET['deleteid']);
			  
			       $query = "DELETE FROM tbldestinations WHERE id = $id";				   
				   $result = mysql_query($query, $connection);
				  
				   header("Location: destinations.php");
			   }

?>
<?php require_once('includes/top-template.php'); //include the template top ?>


<div class="container">

  
  
<div class="col-md-6">
 
  <h2>Add New Destinations</h2>
                <form action="destinations.php" method="post" >
                <input type="text" class="form-control add-todo" placeholder="Destinations." name="destination_name" required><br>
               
                <button type="submit" class="btn btn-primary" name="add_destinations">Add New Destinations</button>
                </form>
  
      <h2>Update Destinations</h2>
                    <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Destinations</th> 
                        <th style="text-align:center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    
                    <?php 
					$query = "SELECT * FROM tbldestinations ORDER BY destination_name";
			        $result = mysql_query($query, $connection) or die("Database query failed: " . mysql_error());
					$count = 1; 
			        while ($row = mysql_fetch_array($result)) {
					
					 ?>
                      <form action="destinations.php" method="post">
                      <input type="hidden" name="id" value="<?php echo $row['id']; ?>"  />
                      <tr>
                        <td><?php echo $count; ?></td>
                        <td><input type="text" style="width: 110px;" value= "<?php echo $row['destination_name']; ?>" name="destination_name" /> </td>
                        
                        <td style="text-align:center;" >
                       
                       <button type="submit" data-toggle="tooltip" data-placement="top" title="Edit" name="edit_btn" class="btn btn-info btn-xs"> <span class="glyphicon glyphicon-edit"></span> </button>
                       
                       <a href="destinations.php?deleteid=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Delete this?')"> <span class="glyphicon glyphicon-trash"></span> </a></td>
                      </tr>
                      </form> 
                      <?php  
					  $count++; 
					  } ?>
                    </tbody>
                  </table>               
                  
            
             
</div>

 

<hr style="border: 4px double #ccc; clear:both;    margin: 40px 0px;" /> 
 

</div>
  
 
  
<?php require_once('../includes/footer-template.php'); //include footer template ?>
