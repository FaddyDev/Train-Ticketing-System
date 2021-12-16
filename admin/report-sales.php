<?php require_once('../includes/connection.php'); ?>
<?php require_once('../includes/session.php'); ?>
<?php confirm_admin_logged_in(); //confirm admin has logged in ?>
<?php require_once('includes/top-template.php'); //include the template top ?>

   
       <div class="row">
       
       <div class="container" style="height: 100vh;">
       <hr style="margin: 20px 0px;" /> 
       <div class="col-md-3">
       <h2>NAVIGATION</h2>
       <?php require_once('includes/nav.php'); ?>

 
       </div>
       <div class="col-md-9">
       <h2>Ticket Sales Report</h2> 
       <div class="input-group" style="width:50%;"> <span class="input-group-addon">Search</span>
      <input id="filter"   type="text" class="form-control" placeholder="Search">
      </div>
              <button type="button" class="btn btn-info btn-sm" style="float:right;margin-top: -30px;" onclick="javascript:printDiv('print')"><span class="glyphicon glyphicon-print"></span> Print Report</button>
                     
<br>
       <div id="print">
       <table class="table table-striped">
                    <thead>
                      <tr>
                        <th style="min-width:100px;">Ticket Info</th>
                        <th>Date/Time</th>
                        <th>To</th>
                        <th>From</th>
                        <th style="min-width: 100px;">Train No.</th>
                        <th>KES/-</th> 
                        <th></th>  
                      </tr>
                    </thead>
                    <tbody class="searchable">
                    
                    <?php 
					$query = "SELECT * FROM view_tickets  WHERE ticket_status = 'Sold' ORDER BY `schedule_date` ASC";
			        $result = mysqli_query($connection,$query) or die("Database query failed: " . mysqli_error($connection));
					 
					$total = 0; 
			        while ($row = mysqli_fetch_array($result)) {
					
					 ?>
                      
                      <tr>
                        <td><small>
                          <strong>No.</strong><?php echo $row['id']; ?><br/>
                          <strong>Seat No.</strong><?php echo $row['seat_no']; ?><br/> 
                        </small>
                        </td>
                        <td><?php echo $row['schedule_date'].' '.$row['schedule_time']; ?><br />
                         <strong><small>(<?php echo $row['ticket_type'];?>)</small></strong> </td>
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
                        <td><?php echo $row['train_number'].'<br>('.$row['train_model'].')'; ?></td>
                        <td><?php echo $row['ticket_cost']; ?></td>
                        <td>
                            <?php $transaction_id = $row['transaction_id']; 
						    $sql = "SELECT * FROM tbltransactions WHERE transaction_id = $transaction_id";
							$res = mysqli_query($connection, $sql) or die("Database query failed: " . mysqli_error($connection));
							while ($row2 = mysqli_fetch_array($res)) {
								 $userid =  $row2['user_id'];
								 $sql2 = "SELECT * FROM tblcustomers WHERE id = $userid";
							     $res2 = mysqli_query($connection, $sql2) or die("Database query failed: " . mysqli_error($connection));
							     while ($row3 = mysqli_fetch_array($res2)) {
									echo '<small><b>By</b> '.$row3['email'].'</small><br>';
									 }
								 
								?>
                            <small><b> Purchased on -<br /><?php 
						 	echo  $row2['transaction_date'].'<br>('.$row2['transaction_code'].')';?></b></small><br />
                            <?php } ?>
                       </td>
                      </tr>
                    
                      <?php   
					  $total +=  $row['ticket_cost'];
					  } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                    <td colspan="5" style="background: #E51837;"></td>
                    <td colspan="2"><h2><strong>Total: <?php  echo $total; ?>/-</strong></h2></td>
                    </tr>
                    </tfoot>
                  </table>  
                  </div>             
       </div>
       </div>
    


</div>
  
 
  
<?php require_once('includes/footer-template.php'); //include footer template ?>
