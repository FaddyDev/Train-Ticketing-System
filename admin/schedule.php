<?php require_once('../includes/connection.php'); ?>
<?php require_once('../includes/session.php'); ?>
<?php confirm_admin_logged_in(); //confirm admin has logged in ?> 
<?php   

       //ADD New Trains Schedule
	   if(isset($_POST['add_schedule'])){//
		  $train_id = $_POST['train'];
		  $train_to_id = $_POST['to'];
		  $train_from_id = $_POST['from'];
		  $schedule_date = $_POST['date'];
		  $schedule_time = $_POST['time']; 
		  
		  
		 $query = "INSERT INTO tblschedules (train_id, train_to_id , train_from_id, schedule_date, schedule_time)
		  VALUES ( '{$train_id}', '{$train_to_id}', '{$train_from_id}' , '{$schedule_date}' , '{$schedule_time}')";
		 $result = mysql_query($query, $connection);
		 header("Location: schedule.php");
		 }//
		 
		  //DELETE
	     	  elseif(isset($_GET['deleteid'])){
			  $id = mysql_real_escape_string($_GET['deleteid']);
			  
			       $query = "DELETE FROM tblschedules WHERE id = $id";				   
				   $result = mysql_query($query, $connection);
				  
				   header("Location: schedule.php");
			   }
?>
<?php require_once('includes/top-template.php'); //include the template top ?>
<div class="container">
<h2>Train Schedule</h2>

 <div class="row">
        <div class='col-sm-6'>
        
          <form action="schedule.php" name="schedule_form" onSubmit="return validate_schedule_form();" method="post" >
                <select class="form-control" name="train" data-toggle="tooltip" title="Select Train">
                <option value="0">Select Train</option>
                <?php
					$query = "SELECT * FROM tbltrains ORDER BY train_number";
			        $result = mysql_query($query, $connection) or die("Database query failed: " . mysql_error());
					while ($row = mysql_fetch_array($result)) {
					echo '<option value='.$row['id'].'>Train No - '.$row['train_number'].' Model - '.$row['train_model'].'</option>';	
					}
					
				 ?>
                </select><br>
                <select class="form-control" name="to" data-toggle="tooltip" title="Select Destination To">
                <option value="0">Select To</option>
                <?php
					$query = "SELECT * FROM tbldestinations ORDER BY destination_name";
			        $result = mysql_query($query, $connection) or die("Database query failed: " . mysql_error());
					while ($row = mysql_fetch_array($result)) {
					echo '<option value='.$row['id'].'>'.$row['destination_name'].'</option>';	
					}
					
				 ?>
                </select><br>
                <select class="form-control" name="from" data-toggle="tooltip" title="Select Destination From">
                <option value="0">Select From</option>
                 <?php
					$query = "SELECT * FROM tbldestinations ORDER BY destination_name";
			        $result = mysql_query($query, $connection) or die("Database query failed: " . mysql_error());
					while ($row = mysql_fetch_array($result)) {
					echo '<option value='.$row['id'].'>'.$row['destination_name'].'</option>';	
					}
					
				 ?>
                </select><br>
                <input type="date" class="form-control add-todo" data-toggle="tooltip" title="Select Schedule Date"  name="date" data-provide="datepicker"><br>
                
              
        
             <div class="input-group bootstrap-timepicker timepicker">
            <input id="timepicker1" type="text" name="time" data-toggle="tooltip" title="Select Schedule Time" class="form-control input-small">
            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
        <br/>
 
            
              <button type="submit" class="btn btn-primary" name="add_schedule">Add Train Schedule</button>
              </form>
           <script>
           //validate form
		   function validate_schedule_form(){
		   var Train = document.schedule_form.train.value;
		   var To = document.schedule_form.to.value;
		   var From = document.schedule_form.from.value; 
		   
		       if(Train == 0){
			   alert('Please select a train');
			   return false;
			   }
			   
			   if(To == 0){
			   alert('Please select destination To');
			   return false;
			   }
			   
			    if(From == 0){
			   alert('Please select destination From');
			   return false;
			   }
			   
			    if(From == To){
			   alert('Please select different destinations');
			   return false;
			   }
			   
			   
		   
		   return true;
		   }
           
           </script>
           
        </div>
        
        </div>
      
       <div class="row">
       <hr style="border: 4px double #ccc; clear:both;    margin: 20px 0px;" /> 
       <h2>Train Schedule List</h2>
       
       <div class="input-group"> <span class="input-group-addon">Search</span>
      <input id="filter"  style="width:25%;" type="text" class="form-control" placeholder="Search">
      </div>
<br>

       <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Schedule Date/Time</th>
                        <th>To</th>
                        <th>From</th>
                        <th>Train Number</th>
                        <th>Train Model</th>  
                        <th style="text-align:center">Action</th>
                      </tr>
                    </thead>
                    <tbody class="searchable">
                    
                    <?php 
					$query = "SELECT * FROM view_schedule";
			        $result = mysql_query($query, $connection) or die("Database query failed: " . mysql_error());
					$count = 1; 
			        while ($row = mysql_fetch_array($result)) {
					
					 ?>
                      
                      <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row['schedule_date'].' '.$row['schedule_time']; ?> </td>
                        <td><?php 
						    $to = $row['train_to_id']; 
						    $sql = "SELECT * FROM tbldestinations WHERE id = $to";
							$res = mysql_query($sql, $connection) or die("Database query failed: " . mysql_error());
							while ($row2 = mysql_fetch_array($res)) {
								echo $row2['destination_name'];
								}
						
						?> </td>
                        <td><?php 
						    $from = $row['train_from_id']; 
						    $sql = "SELECT * FROM tbldestinations WHERE id = $from";
							$res = mysql_query($sql, $connection) or die("Database query failed: " . mysql_error());
							while ($row2 = mysql_fetch_array($res)) {
								echo $row2['destination_name'];
								}
						
						?> </td>
                        <td><?php echo $row['train_number']; ?></td>
                        <td><?php echo $row['train_model']; ?></td>
                        <td style="text-align:center;" >
                       
                       <a href="schedule-edit.php?id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-primary btn-xs" > <span class="glyphicon glyphicon-edit"></span> </a>
                       
                       <a href="schedule.php?deleteid=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Delete this?')"> <span class="glyphicon glyphicon-trash"></span> </a></td>
                      </tr>
                    
                      <?php  
					  $count++; 
					  } ?>
                    </tbody>
                  </table>               
       </div>
       
    


</div>
  
 
  
<?php require_once('includes/footer-template.php'); //include footer template ?>
