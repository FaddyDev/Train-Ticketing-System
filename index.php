<?php require_once('includes/connection.php'); ?>
<?php require_once('includes/session.php'); ?>
<?php require_once('includes/top-template.php'); //include the template top ?>


<div class="container">

  <div class="col-md-12">
  <h1>About Train Express</h1>
<p>Train Express will enable our esteem customers to easily book their ticket online and view their detail, it will also give the passengers all the information related to the journey for example the scenery the will see along the way, and also the meal and drinks available.</p>
  <a class="btn btn-primary" href="contact.php">CONTACT US</a>
   <hr/>
  </div>

 
<div class="col-md-4">
<?php require_once('includes/sidebar-search.php'); ?>

</div>

<div class="col-md-8">
<?php 
if(isset($_GET['search_schedule'])){
?>
 <h2>Search Results</h2>
<?php	
$to = $_GET['to'];
$from = $_GET['from'];
$traveldate = $_GET['traveldate'];
$datetime=date_create("$traveldate");
$date=date_format($datetime,"Y-m-d");
//$time=date_format($datetime, "H:i:s");
                 
				 $query = "SELECT * FROM view_tickets WHERE train_to_id = $to and train_from_id = $from and schedule_date > '$date' and ticket_status != 'Sold' ";
                 $result = mysqli_query($connection, $query) or die("Database query failed: " . mysqli_error($connection));
				 $count_row = mysqli_fetch_array($result);
				 if($count_row > 0){
					 $sql = "SELECT * FROM view_tickets WHERE train_to_id = $to and train_from_id = $from and schedule_date > '$date' and ticket_status != 'Sold' ";
                     $res = mysqli_query($connection, $sql) or die("Database query failed: " . mysqli_error($connection));
					?>
					<br />
                    <ul class="nav nav-tabs ticket-tabs">
                      <li class="active"><a data-toggle="tab" href="#second-class">Second Class</a></li>
                      <li><a data-toggle="tab" href="#first-class">First Class</a></li> 
                    </ul>

                    <div class="tab-content">
                      <div id="second-class" class="tab-pane fade in active">
                        <h3>Second Class</h3>
                        <?php
						$sql2 = "SELECT * FROM view_tickets WHERE train_to_id = $to and train_from_id = $from and ticket_type ='Second Class' and schedule_date > '$date'  and ticket_status != 'Sold'";
                        $tickets = mysqli_query($connection, $sql2) or die("Database query failed: " . mysqli_error($connection));
						$check_row = mysqli_fetch_array($tickets);
						if($check_row <= 0) {
							echo '<div class="alert alert-warning"><b>No second class tickets available from your search</b><br> Please try First class</div>';
							}else {
						$sql2 = "SELECT * FROM view_tickets WHERE train_to_id = $to and train_from_id = $from and ticket_type ='Second Class' and schedule_date > '$date'  and ticket_status != 'Sold'";
                        $tickets = mysqli_query($connection, $sql2) or die("Database query failed: " . mysqli_error($connection));		
					    while ($ticket = mysqli_fetch_array($tickets)){ ?>
                        <div class="alert alert-info"><!-- start ticket -->
                        <table id="ticket-table" width="100%">
                        <tbody>
                        <tr>
                        <td><strong>Train No: </strong><?php echo $ticket['train_number'].'('.$ticket['train_model'].')'; ?></td>
                        <td><strong>Nos: </strong><?php echo $ticket['id']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Seat No.: </strong><?php echo $ticket['seat_no']; ?></td>
                        </tr>
                        
                        <tr>
                        <td><strong>To: </strong><?php
						$to = $ticket['train_to_id'];
						$sql3 = "SELECT * FROM tblstations WHERE id = $to";
			            $stations = mysqli_query($connection, $sql3) or die("Database query failed: " . mysqli_error($connection));
					    while ($station = mysqli_fetch_array($stations)) {
					         echo $station['station_name'].' ('.$station['station_city'].')';	
					          }
					
						 ?></td>
                        <td><strong>Travel Date/Time: </strong><?php echo $ticket['schedule_date'].' '.$ticket['schedule_time']; ?></td>
                        </tr>
                        
                        <tr>
                        <td><strong>From: </strong><?php
						$from = $ticket['train_from_id'];
						$sql3 = "SELECT * FROM tblstations WHERE id = $from";
			            $stations = mysqli_query($connection, $sql3) or die("Database query failed: " . mysqli_error($connection));
					    while ($station = mysqli_fetch_array($stations)) {
					         echo $station['station_name'].' ('.$station['station_city'].')';	
					          }
					
						 ?></td>
                        <td><strong>Cost:</strong> KES <?php echo $ticket['ticket_cost']; ?>/-</td>
                        </tr>
                          <tr>
                        <td><strong><small>Second(2nd) Class</small></strong></td>
                        <td><a href="tickets.php?id=<?php echo $ticket['id']; ?>" class="btn btn-primary pull-right"> BOOK NOW</a></td>
                        </tr>
                        
                        </tbody>
                        </table>
                        </div><!--end Ticket -->
                        <?php  } 
							}?>
                      </div>
                      <div id="first-class" class="tab-pane fade">
                        <h3>First Class</h3>
                            <?php
						
						$sql2 = "SELECT * FROM view_tickets WHERE train_to_id = $to and train_from_id = $from and ticket_type ='First Class' and schedule_date > '$date' and ticket_status != 'Sold'";
                        $tickets = mysqli_query($connection, $sql2) or die("Database query failed: " . mysqli_error($connection));
						$check_row = mysqli_fetch_array($tickets);
						if($check_row <= 0) {
							echo '<div class="alert alert-warning"><b>No first class tickets available from your search</b><br> Please try Second class</div>';
							}else {
						$sql2 = "SELECT * FROM view_tickets WHERE train_to_id = $to and train_from_id = $from and ticket_type ='First Class' and schedule_date > '$date' and ticket_status != 'Sold'";
                        $tickets = mysqli_query($connection, $sql2) or die("Database query failed: " . mysqli_error($connection));
					    while ($ticket = mysqli_fetch_array($tickets)){ ?>
                        <div class="alert alert-success"><!-- start ticket -->
                        <table id="ticket-table" width="100%">
                        <tbody>
                        <tr>
                        <td><strong>Train No: </strong><?php echo $ticket['train_number'].'('.$ticket['train_model'].')'; ?></td>
                        <td><strong>Nos: </strong><?php echo $ticket['id']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Seat No.: </strong><?php echo $ticket['seat_no']; ?></td>
                        </tr>
                        
                        <tr>
                        <td><strong>To: </strong><?php
						$to = $ticket['train_to_id'];
						$sql3 = "SELECT * FROM tblstations WHERE id = $to";
			            $stations = mysqli_query($connection, $sql3) or die("Database query failed: " . mysqli_error($connection));
					    while ($station = mysqli_fetch_array($stations)) {
					         echo $station['station_name'].' ('.$station['station_city'].')';	
					          }
					
						 ?></td>
                        <td><strong>Travel Date/Time: </strong><?php echo $ticket['schedule_date'].' '.$ticket['schedule_time']; ?></td>
                        </tr>
                        
                        <tr>
                        <td><strong>From: </strong><?php
						$from = $ticket['train_from_id'];
						$sql3 = "SELECT * FROM tblstations WHERE id = $from";
			            $stations = mysqli_query($connection, $sql3) or die("Database query failed: " . mysqli_error($connection));
					    while ($station = mysqli_fetch_array($stations)) {
					         echo $station['station_name'].' ('.$station['station_city'].')';	
					          }
					
						 ?></td>
                        <td><strong>Cost:</strong> KES <?php echo $ticket['ticket_cost']; ?>/-</td>
                        </tr>
                          <tr>
                        <td><strong><small>First(1st) Class</small></strong></td>
                        <td><a href="tickets.php?id=<?php echo $ticket['id']; ?>" class="btn btn-primary pull-right"> BOOK NOW</a></td>
                        </tr>
                        
                        </tbody>
                        </table>
                        </div><!--end Ticket -->
                        <?php  }
						
							}?>
                      </div>
                      
                    </div>
                    
                     
					<?php
					
					 }else{
					 echo '<div class="alert alert-warning"><b>Search result found nothing</b><br> Please try again</div>';
					 }
                


	}else {
?>
<h2>&nbsp;</h2>
<p align="center"><img src="img/buy-tickets.jpg" /></p>
<?php } ?> 
 <hr>
                 
</div>

<hr style="clear:both;margin: 10px 0px;" /> 


</div>
  
 
  
<?php require_once('includes/footer-template.php'); //include footer template ?>
