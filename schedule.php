<?php require_once('includes/connection.php');  //include connection?>
<?php require_once('includes/session.php');  //include session?>

<?php require_once('includes/top-template.php'); //include the template top ?>


<div class="container">
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
                       
                       <a href="view-tickets.php?id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="View Tickets" class="btn btn-primary btn-xs" > View Tickets </a>
                       
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
