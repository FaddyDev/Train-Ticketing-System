<?php require_once('includes/connection.php'); ?>
<?php require_once('includes/session.php'); ?> 
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
		 $result = mysql_query($query, $connection) or die("Database query failed: " . mysql_error());
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
		 $result = mysql_query($query, $connection) or die("Database query failed: " . mysql_error());	 
		 header("Location: tickets-add.php?id=$selected_id"); 
			 }
		 
		      //DELETE
	     	  elseif(isset($_GET['deleteid'])){
			  $id = $_GET['deleteid'];
			  $selected_id = $_GET['del_id'];
			  
			       $query = "DELETE FROM tbltickets WHERE id = $id";				   
				   $result = mysql_query($query, $connection);
				   header("Location: tickets-add.php?id=$selected_id");
			   }
			   
			   	 else{
				  header("Location: schedule.php");
				 }
			 
			 //fetch
			 $query ="SELECT * FROM tblschedules WHERE id = $selected_id";
			 $result = mysql_query($query, $connection);
			 while($row = mysql_fetch_array($result)){
				 
				 $fetch_train_id = $row['train_id'];
				 $fetch_train_to_id = $row['train_to_id'];
				 $fetch_train_from_id = $row['train_from_id'];
				 $fetch_schedule_date = $row['schedule_date'];
				 $fetch_schedule_time = $row['schedule_time'];
				 
			 }
				 
?>
<?php require_once('includes/top-template.php'); //include the template top ?>
<div class="container">
<h2>Train Schedule</h2>

 <div class="row">
        <div class='col-sm-6'>
        
          <form >
         
                <select class="form-control" name="train" data-toggle="tooltip" title="Select Train" disabled>
                <option value="0">Select Train</option>
                <?php
					$query = "SELECT * FROM tbltrains ORDER BY train_number";
			        $result = mysql_query($query, $connection) or die("Database query failed: " . mysql_error());
					while ($row = mysql_fetch_array($result)) {
						$train_id = $row['id'];
					echo '<option value='.$row['id'].' ';
					if($train_id == $fetch_train_id){ echo 'selected';} 
					echo ' >Train No - '.$row['train_number'].' Model - '.$row['train_model'].'</option>';	
					}
					
				 ?>
                </select><br>
                <select class="form-control" name="to" data-toggle="tooltip" title="Select Destination To" disabled>
                <option value="0">Select To</option>
                <?php
					$query = "SELECT * FROM tbldestinations ORDER BY destination_name";
			        $result = mysql_query($query, $connection) or die("Database query failed: " . mysql_error());
					while ($row = mysql_fetch_array($result)) {
						
					echo '<option value='.$row['id'].' ';
					$destination_to_id =  $row['id'];
					if($destination_to_id == $fetch_train_to_id){ echo 'selected';} 
					echo '>'.$row['destination_name'].'</option>';	
					}
					
				 ?>
                </select><br>
                <select class="form-control" name="from" data-toggle="tooltip" title="Select Destination From" disabled>
                <option value="0">Select From</option>
                 <?php
					$query = "SELECT * FROM tbldestinations ORDER BY destination_name";
			        $result = mysql_query($query, $connection) or die("Database query failed: " . mysql_error());
					while ($row = mysql_fetch_array($result)) {
					echo '<option value='.$row['id'].' ';
					$destination_from_id =  $row['id'];
					if($destination_from_id == $fetch_train_from_id){ echo 'selected';} 
					echo '>'.$row['destination_name'].'</option>';	
					}
					
				 ?>
                </select><br>
                <input type="date" class="form-control add-todo" data-toggle="tooltip" value="<?php echo $fetch_schedule_date; ?>" title="Select Schedule Date"  name="date" data-provide="datepicker" disabled><br>
                
              
        
             <div class="input-group bootstrap-timepicker timepicker">
            <input id="timepicker1" type="text" name="time" data-toggle="tooltip" value="<?php echo $fetch_schedule_time; ?>" title="Select Schedule Time" class="form-control input-small" disabled>
            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
        <br/>
  
              </form>
       
           
        </div>
        
        <div class='col-sm-6'>
        
        <div class="contact" style="padding: 75px 60px;margin-top: 0px;">
			<p>
				Any inquiries kindly Call: <span>+254 720000000</span>
			</p>
	  </div>
        
        </div>
        
        </div>
      
       <div class="row">
       <hr style="border: 4px double #ccc; clear:both;    margin: 20px 0px;" /> 
       <h2>Train Tickets</h2>
       
       <div class="input-group"> <span class="input-group-addon">Search</span>
      <input id="filter"  style="width:25%;" type="text" class="form-control" placeholder="Search">
      </div>
<br>

       <table class="table table-striped">
                    <thead>
                      <tr> 
                        <th>Ticket No</th>
                        <th>Seat No</th>
                        <th>Cost</th>
                        <th>Ticket Type</th> 
                        <th style="text-align:center">Action</th>
                      </tr>
                    </thead>
                    <tbody class="searchable"> 
                    <?php 
					$query = "SELECT * FROM tbltickets WHERE schedule_id =  $selected_id and ticket_status = 'Not Sold'";
			        $result = mysql_query($query, $connection) or die("Database query failed: " . mysql_error());
					$count = 1; 
			        while ($row = mysql_fetch_array($result)) {
					
					 ?>
                     
                      <tr> 
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['seat_no']; ?></td>
                        <td><?php echo $row['ticket_cost']; ?></td>
                        <td><?php echo $row['ticket_type'];?></td> 
                        <td style="text-align:center;" >
                       <a href="tickets.php?id=<?php echo $row['id']; ?>" title="Add to Your Tickets" name="add_cart_btn" class="btn btn-primary btn-xs" ><span class="glyphicon glyphicon-plus"></span></a>
                       </td>
                      </tr>
                    
                      <?php  
					  $count++; 
					  } ?>
                    </tbody>
                  </table>               
       </div>
       
    


</div>
  
 
  
<?php require_once('includes/footer-template.php'); //include footer template ?>
