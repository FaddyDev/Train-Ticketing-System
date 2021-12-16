<?php require_once('../includes/connection.php'); ?>
<?php require_once('../includes/session.php'); ?>
<?php confirm_admin_logged_in(); //confirm admin has logged in ?>
<?php require_once('includes/top-template.php'); //include the template top ?>
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
		 $result = mysqli_query($connection,$query);
		 header("Location: schedule.php");
		 }//
		 
		  //DELETE
	     	  elseif(isset($_GET['deleteid'])){
			  $id = $_GET['deleteid'];
			  
			       $query = "DELETE FROM tblschedules WHERE id = $id";				   
				   $result = mysqli_query($connection,$query);
				  
				   header("Location: schedule.php");
			   }
?>



 
      
       <div class="row">
       
       <div class="container" style="height: 100vh;">
       <hr style="margin: 20px 0px;" /> 
       <div class="col-md-3">
       <h2>NAVIGATION</h2>
       <?php require_once('includes/nav.php'); ?>

 
       </div>
       <div class="col-md-9">
       <h2>Trains TimeTable</h2> 
       <div class="input-group" style="width:50%;"> <span class="input-group-addon">Search</span>
      <input id="filter"   type="text" class="form-control" placeholder="Search">
      </div>
       <a href="timetable-new.php" style="float:right;margin-top: -30px;" class="btn btn-success">Add New TimeTable</a>
<br>

       <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Date/Time</th>
                        <th>To</th>
                        <th>From</th>
                        <th style="min-width: 100px;">Train No.</th>
                        <th style="min-width: 100px;">Train Model</th> 
                        <th style="text-align:center;"></th>  
                        <th style="text-align:center">Action</th>
                      </tr>
                    </thead>
                    <tbody class="searchable">
                    
                    <?php 
					$query = "SELECT * FROM view_schedule ORDER BY `schedule_date` ASC";
			        $result = mysqli_query($connection,$query) or die("Database query failed: " . mysqli_error($connection));
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
                        <td style="text-align:center;"><?php 
						    $timetableid = $row['id']; 
						    $sql = "SELECT count(*) FROM tbltickets WHERE schedule_id = $timetableid";
							$res = mysqli_query($connection, $sql) or die("Database query failed: " . mysqli_error($connection));
							while ($row2 = mysqli_fetch_array($res)) {
								echo '<span data-toggle="tooltip" title="Total ticket" style="color:blue;" >('.$row2[0].')</span>';
								}
						
						?></td>
                        <td style="text-align:center;" >
                       
                       <a href="tickets-add.php?id=<?php echo $row['id']; ?>" data-toggle="tooltip" style="padding: 4px 8px 2px 3px;" data-placement="top" title="Add/View Tickets" class="btn btn-warning btn-xs" > <span class="glyphicon glyphicon-plus"></span> TICKETS</a>
                       
                       </td>
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
