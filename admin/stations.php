<?php require_once('../includes/connection.php'); ?>
<?php require_once('../includes/session.php'); ?>
<?php confirm_admin_logged_in(); //confirm admin has logged in ?>
<?php 
        //ADD New Destinations
	   if(isset($_POST['add_station'])){//
		  $station_name = ucfirst(mysqli_real_escape_string($connection, $_POST['station_name']));
		  $station_city = ucfirst(mysqli_real_escape_string($connection, $_POST['station_city']));
		  
		  
		 $query = "INSERT INTO tblstations (station_name, station_city) VALUES ( '{$station_name}', '{$station_city}')";
		 $result = mysqli_query($connection, $query);
		 header("Location: stations.php");
		 }//
		 
		 
		      //UPDATE / EDIT
			   elseif(isset($_POST['edit_btn'])){
				   $id = $_POST['id']; 
				   $station_name = ucfirst(mysqli_real_escape_string($connection, $_POST['station_name']));
		           $station_city = ucfirst(mysqli_real_escape_string($connection, $_POST['station_city']));
		 		   
				   $query = "UPDATE tblstations SET station_name = '$station_name', station_city = '$station_city' WHERE id = $id";				   
				   $result = mysqli_query($connection, $query);
				  
				   header("Location: stations.php");
				   
				   }
		 
		  
			 
			  //DELETE
	     	  elseif(isset($_GET['deleteid'])){
			  $id = mysqli_real_escape_string($connection,$_GET['deleteid']);
			  
			       $query = "DELETE FROM tblstations WHERE id = $id";				   
				   $result = mysqli_query($connection, $query);
				  
				   header("Location: stations.php");
			   }

?>
<?php require_once('includes/top-template.php'); //include the template top ?>


 <div class="row">
   <div class="container">
       <div class="col-md-3">
       <h2>NAVIGATION</h2>
       <?php require_once('includes/nav.php'); ?>

 
       </div>

            <div class="col-md-9">
  <h2>Add New Train Station</h2><br>
                <form action="stations.php" class="form-inline" method="post" >
                <div class="form-group">
                <label>Enter Station Name: </label>
                <input type="text" class="form-control add-todo" placeholder="Station Name." name="station_name" required>
                </div>
                <div class="form-group">
                <label>Select Station City: </label> 
                <select class="form-control" name="station_city" required>
                <option></option>
                <?php 
				    $query = "SELECT * FROM tblcities ORDER BY city";
			        $result = mysqli_query($connection, $query) or die("Database query failed: " . mysqli_error($connection));
					$count = 1; 
			        while ($row = mysqli_fetch_array($result)) {
						echo '<option>'.$row['city'].'</option>';
					}
						?>
                
                
                </select>
                </div>
                <button type="submit" class="btn btn-primary" name="add_station">Add Station</button>
                </form>
  <hr />
      <h2>Update Train Station</h2>
                    <table class="table table-striped">
                    <thead>
                      <tr>
                        <th style="text-align:center;">#</th>
                        <th>Station Name</th> 
                        <th>Station City</th> 
                        <th style="text-align:center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    
                    <?php 
					$query = "SELECT * FROM tblstations ORDER BY station_name";
			        $result = mysqli_query($connection, $query) or die("Database query failed: " . mysqli_error($connection));
					$count = 1; 
			        while ($row = mysqli_fetch_array($result)) {
					
					 ?>
                      <form action="stations.php" method="post">
                      <input type="hidden" name="id" value="<?php echo $row['id']; ?>"  />
                      <tr>
                        <td style="text-align:center;vertical-align: middle;"><?php echo $count; ?></td>
                        <td><input type="text" class="form-control" style="width:70%" value= "<?php echo $row['station_name']; ?>" name="station_name" /> </td>
                        <td><select class="form-control" name="station_city" required>
                                  <option></option>
                                  <?php 
                                    $query2 = "SELECT * FROM tblcities ORDER BY city";
                                    $result2 = mysqli_query($connection, $query2) or die("Database query failed: " . mysqli_error($connection));
       
                                    while ($row2 = mysqli_fetch_array($result2)) {
										$saved_city = $row['station_city'];
										if($saved_city == $row2['city']){
											echo '<option selected>'.$row2['city'].'</option>';
											}else{
										   echo '<option>'.$row2['city'].'</option>';
											}
                                    }
                                        ?>
                                
                                
                                </select> 
                                </td>
                        
                        <td style="text-align:center;vertical-align: middle;" >
                       
                       <button type="submit" data-toggle="tooltip" data-placement="top" title="Edit" name="edit_btn" class="btn btn-info btn-xs"> <span class="glyphicon glyphicon-edit"></span> </button>
                       
                       <a href="stations.php?deleteid=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Delete this?')"> <span class="glyphicon glyphicon-trash"></span> </a></td>
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