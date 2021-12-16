<?php require_once('../includes/connection.php'); ?>
<?php require_once('../includes/session.php'); ?>
<?php confirm_admin_logged_in(); //confirm admin has logged in ?>
<?php   
            if(isset($_GET['id'])){
			 
			 $selected_id = $_GET['id'];
			 }
		 
			 
		     
         //Add Ticket
	      elseif(isset($_POST['add_ticket'])){//
		  $selected_id = $_POST['id'];
		  $seat_no = $_POST['seat_no'];
		  $cost = $_POST['cost'];
		  $ticket_type = $_POST['ticket_type']; 
		  
		  
		 $query = "INSERT INTO `tbltickets` (`id`, `schedule_id`, `seat_no`, `ticket_cost`, `ticket_type`, `ticket_status`) VALUES (NULL, '{$selected_id}', '{$seat_no}', '{$cost}', '{$ticket_type}', 'Not Sold')";
		 $result = mysqli_query($connection, $query) or die("Database query failed: " . mysqli_error($connection));
		 header("Location: tickets-add.php?id=$selected_id");
		 }//
		 
		 //update ticket
		 elseif(isset($_POST['update_btn'])){
		  $selected_id = $_POST['id'];
		  $ticket_id = $_POST['ticket_id'];
		  $seat_no = $_POST['seat_no'];
		  $cost = $_POST['cost'];
		  $ticket_type = $_POST['ticket_type']; 
			
		 $query = "UPDATE `tbltickets` SET  `seat_no` = {$seat_no}, `ticket_cost` = '{$cost}', `ticket_type` = '{$ticket_type}' WHERE id = $ticket_id";
		 $result = mysqli_query($connection, $query) or die("Database query failed: " . mysqli_error($connection));	 
		 header("Location: tickets-add.php?id=$selected_id"); 
			 }
		 
		      //DELETE
	     	  elseif(isset($_GET['deleteid'])){
			  $id = $_GET['deleteid'];
			  $selected_id = $_GET['del_id'];
			  
			       $query = "DELETE FROM tbltickets WHERE id = $id";				   
				   $result = mysqli_query($connection, $query);
				   header("Location: tickets-add.php?id=$selected_id");
			   }
			   
			   	 else{
				  header("Location: schedule.php");
				 }
			 
			 //fetch
			 $query ="SELECT * FROM tblschedules WHERE id = $selected_id";
			 $result = mysqli_query($connection, $query);
			 while($row = mysqli_fetch_array($result)){
				 
				 $fetch_train_id = $row['train_id'];
				 $fetch_train_to_id = $row['train_to_id'];
				 $fetch_train_from_id = $row['train_from_id'];
				 $fetch_schedule_date = $row['schedule_date'];
				 $fetch_schedule_time = $row['schedule_time'];
				 
			 }
				 
?>
<?php require_once('includes/top-template.php'); //include the template top ?>



 <div class="row">
   <div class="container" style="height:100vh;">
       <div class="col-md-3">
       <h2>NAVIGATION</h2>
       <?php require_once('includes/nav.php'); ?>

 
       </div>
        <div class='col-sm-9'>
            <div class="col-md-6">
           <h2>Train Schedule</h2>
          <form >
         
                <select class="form-control" name="train"  title="Select Train" disabled>
                <option value="0">Select Train</option>
                <?php
					$query = "SELECT * FROM tbltrains ORDER BY train_number";
			        $result = mysqli_query($connection, $query) or die("Database query failed: " . mysqli_error($connection));
					while ($row = mysqli_fetch_array($result)) {
						$train_id = $row['id'];
					echo '<option value='.$row['id'].' ';
					if($train_id == $fetch_train_id){ echo 'selected';} 
					echo ' >Train No - '.$row['train_number'].' Model - '.$row['train_model'].'</option>';	
					}
					
				 ?>
                </select><br>
                <select class="form-control" name="to"  title="Select Destination To" disabled>
                <option value="0">Select To</option>
                <?php
					$query = "SELECT * FROM tblstations ORDER BY station_city ASC";
			        $result = mysqli_query($connection, $query) or die("Database query failed: " . mysqli_error($connection));
					while ($row = mysqli_fetch_array($result)) {
						
					echo '<option value='.$row['id'].' ';
					$destination_to_id =  $row['id'];
					if($destination_to_id == $fetch_train_to_id){ echo 'selected';} 
					echo '>'.$row['station_name'].' ('.$row['station_city'].')</option>';	
					}
					
				 ?>
                </select><br>
                <select class="form-control" name="from"  title="Select Destination From" disabled>
                <option value="0">Select From</option>
                 <?php
					$query = "SELECT * FROM tblstations ORDER BY station_city ASC";
			        $result = mysqli_query($connection, $query) or die("Database query failed: " . mysqli_error($connection));
					while ($row = mysqli_fetch_array($result)) {
					echo '<option value='.$row['id'].' ';
					$destination_from_id =  $row['id'];
					if($destination_from_id == $fetch_train_from_id){ echo 'selected';} 
					echo '>'.$row['station_name'].' ('.$row['station_city'].')</option>';	
					}
					
				 ?>
                </select><br>
                <input type="date" class="form-control add-todo"  value="<?php echo $fetch_schedule_date; ?>" title="Select Schedule Date"  name="date" data-provide="datepicker" disabled><br>
                
              
        
             <div class="input-group bootstrap-timepicker timepicker">
            <input id="timepicker1" type="text" name="time"  value="<?php echo $fetch_schedule_time; ?>" title="Select Schedule Time" class="form-control input-small" disabled>
            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
        <br/>
  
              </form>
       
           
        </div>
        
        <div class='col-sm-6'>
         <h2>Add Ticket</h2>
        <form action="tickets-add.php" method="post">
        <input type="hidden" name="id" value="<?php echo $selected_id; ?>"  />
        <label>Enter Seat No.</label>
        <input type="text" class="form-control add-todo"   title="Seat No."  placeholder="Seat No." name="seat_no" required><br>
        <label>Enter Ticket Cost(KES).</label>
        <input type="text" class="form-control add-todo"  title="Ticket Cost." placeholder="Ticket Cost." name="cost" required><br>
        <label>Select Ticket Type.</label>
        <select name="ticket_type" class="form-control add-todo"  title="Select Ticked Type" placeholder="Select Ticked Type" required>
        <option></option>
        <option>First Class</option>
        <option>Second Class</option>
        
        
        </select><br>
        <button type="submit" class="btn btn-primary" name="add_ticket">Add Ticket</button>
        </form>
        
        </div>
        
 <hr />
      

        <div class='col-sm-12'>
       <h2>Train Tickets</h2>
       
       <div class="input-group"> <span class="input-group-addon">Search</span>
      <input id="filter"  style="width:25%;" type="text" class="form-control" placeholder="Search">
      </div>
      <br>

       <table class="table table-striped">
                    <thead>
                      <tr> 
                        <th style="text-align:center;min-width: 90px;">Ticket No.</th>
                        <th>Seat No</th>
                        <th>Cost(KES)</th>
                        <th style="min-width: 151px;">Ticket Type</th>
                        <th>Status</th>   
                        <th style="text-align:center">Action</th>
                      </tr>
                    </thead>
                    <tbody class="searchable"> 
                    <?php 
					$query = "SELECT * FROM tbltickets WHERE schedule_id =  $selected_id";
			        $result = mysqli_query($connection, $query) or die("Database query failed: " . mysqli_error($connection));
					$count = 1; 
			        while ($row = mysqli_fetch_array($result)) {
					
					 ?>
                     <form action="tickets-add.php" method="post"> 
                     <input type="hidden" name="id" value="<?php echo $selected_id; ?>"  />
                     <input type="hidden" name="ticket_id" value="<?php echo $row['id']; ?>"  />
                      <tr> 
                        <td style="text-align:center; vertical-align:middle;"><?php echo $row['id']; ?></td>
                        <td> <input type="text" class="form-control add-todo" style="width:50%;text-align:center;"   title="Seat No."  placeholder="Seat No." value="<?php echo $row['seat_no']; ?>" name="seat_no" required></td>
                        <td><input type="text" class="form-control add-todo" style="width:50%; text-align:center;"   title="Ticket Cost." placeholder="Ticket Cost." value="<?php echo $row['ticket_cost']; ?>" name="cost" required></td>
                        <td><select name="ticket_type" class="form-control add-todo"   title="Select Ticked Type" placeholder="Select Ticked Type" required>
        <option><?php echo $row['ticket_type']; ?></option>
        <option>First Class</option>
        <option>Second Class</option>
        
        
        </select></td>
                        <td style="min-width: 94px;vertical-align:middle;"><?php echo $row['ticket_status']; ?></td>
                        <td style="min-width: 94px;text-align:center; vertical-align:middle;" >
                       
                       <button type="submit" title="Update" name="update_btn" class="btn btn-primary btn-xs" ><span class="glyphicon glyphicon-edit"></span></button>
                       
                       <a href="tickets-add.php?deleteid=<?php echo $row['id']; ?>&amp;del_id=<?php echo $selected_id;?>"  data-placement="top" title="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Delete this?')"> <span class="glyphicon glyphicon-trash"></span> </a></td>
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
</div>
  
 
  
<?php require_once('includes/footer-template.php'); //include footer template ?>
