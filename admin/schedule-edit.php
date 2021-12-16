<?php require_once('../includes/connection.php'); ?>
<?php require_once('../includes/session.php'); ?>
<?php confirm_admin_logged_in(); //confirm admin has logged in ?>
<?php   
            if(isset($_GET['id'])){
			 
			 $selected_id = $_GET['id'];
			 }
		 
			 
		     
         //Update  Trains Schedule
	      elseif(isset($_POST['update_schedule'])){//
		  $selected_id = $_POST['id'];
		  $train_id = $_POST['train'];
		  $train_to_id = $_POST['to'];
		  $train_from_id = $_POST['from'];
		  $schedule_date = $_POST['date'];
		  $schedule_time = $_POST['time']; 
		  
		  
		 $query = "UPDATE tblschedules SET train_id = '{$train_id}', train_to_id= '{$train_to_id}', train_from_id ='{$train_from_id}' , schedule_date= '{$schedule_date}' ,
		   schedule_time = '{$schedule_time}' WHERE id = $selected_id ";
		 $result = mysqli_query($connection, $query) or die("Database query failed: " . mysqli_error($connection));
		 header("Location: schedule-edit.php?id=$selected_id");
		 }//
		 
		      //DELETE
	     	  elseif(isset($_GET['deleteid'])){
			  $id = mysqli_real_escape_string($connection, $_GET['deleteid']);
			  
			       $query = "DELETE FROM tblschedules WHERE id = $id";				   
				   $result = mysqli_query($connection, $query);
				  
				   header("Location: timetable-new.php");
			   }
			   
			   	 else{
				  header("Location: timetable-new.php");
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
   <div class="container" >
       <div class="col-md-3">
       <h2>NAVIGATION</h2>
       <?php require_once('includes/nav.php'); ?>

 
       </div>

        <div class="col-md-9">
        <h2>Train Schedule</h2>
          <form action="schedule-edit.php" name="schedule_form" onSubmit="return validate_schedule_form();" method="post" >
          <input type="hidden" name="id" value="<?php echo $selected_id; ?>" />
                <label>Select Train</label>
                <select class="form-control" name="train"  title="Select Train">
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
                <label>Select Destination To</label>
                <select class="form-control" name="to"  title="Select Destination To">
                <option value="0">Select To</option>
                <?php
					$query = "SELECT * FROM tblstations ORDER BY station_city";
			        $result = mysqli_query($connection, $query) or die("Database query failed: " . mysqli_error($connection));
					while ($row = mysqli_fetch_array($result)) {
						
					echo '<option value='.$row['id'].' ';
					$destination_to_id =  $row['id'];
					if($destination_to_id == $fetch_train_to_id){ echo 'selected';} 
					echo '>'.$row['station_name'].' ('.$row['station_city'].')</option>';	
					}
					
				 ?>
                </select><br>
                <label>Select Destination From</label>
                <select class="form-control" name="from"  title="Select Destination From">
                <option value="0">Select From</option>
                 <?php
					$query = "SELECT * FROM tblstations ORDER BY station_city";
			        $result = mysqli_query($connection, $query) or die("Database query failed: " . mysqli_error($connection));
					while ($row = mysqli_fetch_array($result)) {
					echo '<option value='.$row['id'].' ';
					$destination_from_id =  $row['id'];
					if($destination_from_id == $fetch_train_from_id){ echo 'selected';} 
					echo '>'.$row['station_name'].' ('.$row['station_city'].')</option>';	
					}
					
				 ?>
                </select><br>
                <label>Select Schedule Date</label>
                <input type="date" class="form-control add-todo"  value="<?php echo $fetch_schedule_date; ?>" title="Select Schedule Date"  name="date" data-provide="datepicker"><br>
                
              
             <label>Select Schedule Time</label>
             <div class="input-group bootstrap-timepicker timepicker">
            <input id="timepicker1" type="text" name="time"  value="<?php echo $fetch_schedule_time; ?>" title="Select Schedule Time" class="form-control input-small">
            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
        <br/>
 
            
              <button type="submit" class="btn btn-primary" name="update_schedule">Update Train Schedule</button>
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
           
       
       <hr > 
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
                        <th>Train No.</th>
                        <th>Train Model</th>  
                        <th style="text-align:center">Action</th>
                      </tr>
                    </thead>
                    <tbody class="searchable">
                    
                    <?php 
					$query = "SELECT * FROM view_schedule ORDER BY `schedule_date` ASC ";
			        $result = mysqli_query($connection, $query) or die("Database query failed: " . mysqli_error($connection));
					$count = 1; 
			        while ($row = mysqli_fetch_array($result)) {
					
					 ?>
                      
                      <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row['schedule_date'].' '.$row['schedule_time']; ?> </td>
                        <td><?php 
						    $to = $row['train_to_id']; 
						    $sql = "SELECT * FROM tblstations WHERE id = $to";
							$res = mysqli_query($connection, $sql) or die("Database query failed: " . mysqli_error($connection));
							while ($row2 = mysqli_fetch_array($res)) {
								echo $row2['station_name'].'<br>('.$row2['station_city'].')';
								}
						
						?> </td>
                        <td><?php 
						    $from = $row['train_from_id']; 
						    $sql = "SELECT * FROM tblstations WHERE id = $from";
							$res = mysqli_query($connection, $sql) or die("Database query failed: " . mysqli_error($connection));
							while ($row2 = mysqli_fetch_array($res)) {
								echo $row2['station_name'].'<br>('.$row2['station_city'].')';
								}
						
						?> </td>
                        <td><?php echo $row['train_number']; ?></td>
                        <td><?php echo $row['train_model']; ?></td>
                        <td style="text-align:center;" >
                       
                       <a href="schedule-edit.php?id=<?php echo $row['id']; ?>"  data-placement="top" title="Edit" class="btn btn-primary btn-xs" > <span class="glyphicon glyphicon-edit"></span> </a>
                       
                       <a href="timetable-new.php?deleteid=<?php echo $row['id']; ?>"  data-placement="top" title="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Delete this?')"> <span class="glyphicon glyphicon-trash"></span> </a></td>
                      </tr>
                    
                      <?php  
					  $count++; 
					  } ?>
                    </tbody>
                  </table>                     
       </div>
       
    
</div>

</div>
  
 
  
<?php require_once('includes/footer-template.php'); //include footer template ?>
