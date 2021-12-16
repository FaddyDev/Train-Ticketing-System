<?php require_once('includes/connection.php');  //include connection?>
<?php require_once('includes/session.php');  //include session?>
<?php confirm_logged_in();  //confirm user has logged in 
      $session_id = $_SESSION['userid'];
?>
<?php 
        if(isset($_GET['id'])){
			$select_id = $_GET['id'];
			
			//add to train cart
			
			$sql ="SELECT * FROM tblticket_cart WHERE ticket_id = $select_id and user_id = $session_id";
			$res = mysqli_query($connection, $sql) or die("Query failed " . mysqli_error($connection));
			$row = mysqli_fetch_array($res);
			if($row <= 0){
				//insert
				$query = "INSERT INTO `tblticket_cart` (`cart_id`, `ticket_id`, `user_id`) VALUES (NULL, '{$select_id}', '{$session_id}')";
				$result = mysqli_query($connection, $query) or die("Query failed " . mysqli_error($connection));
				
				header("Location: tickets.php");
				
				}
			
			}
			
			elseif(isset($_GET['deleteid'])){
				
				$deleteid= $_GET['deleteid'];
				$query ="DELETE FROM `tblticket_cart` WHERE cart_id = $deleteid";
				$result = mysqli_query($connection, $query) or die("Query failed " . mysqli_error($connection));
				
				header("Location: tickets.php");
				}
		
		elseif(isset($_POST['pay_btn'])){
					$code = $_POST['code'];
					
					//insert tranaaction
					$sql ="INSERT INTO `tbltransactions` (`transaction_id`, `transaction_date`, `transaction_code`, `user_id`) VALUES (NULL, CURRENT_TIMESTAMP, '{$code}', '{$session_id}');";
			        $res = mysqli_query($connection, $sql) or die("Query failed " . mysqli_error($connection));
					
					$transaction_id = mysqli_insert_id($connection);
					
					$sql ="SELECT * FROM tblticket_cart WHERE user_id = $session_id";
			        $res = mysqli_query($connection, $sql) or die("Query failed " . mysqli_error($connection));
			        while($row = mysqli_fetch_array($res)){
						$ticket_id  = $row['ticket_id'];
						//update tickets
						$query ="UPDATE tbltickets SET ticket_status = 'Sold' , transaction_id = $transaction_id   WHERE id = $ticket_id";
				        $result = mysqli_query($connection, $query) or die("Query failed " . mysqli_error($connection));
						
						}
						
						//delete from tblcart
						
					$query ="DELETE FROM `tblticket_cart` WHERE user_id = $session_id";
				    $result = mysqli_query($connection, $query) or die("Query failed " . mysqli_error($connection));
				
				    header("Location: account.php");
					
					}
?>
<?php require_once('includes/top-template.php'); //include the template top ?>

<div class="container" >
<div class="col-md-8">
 <h2>Your Tickets</h2>
             
             
             <table class="table table-striped">
                    <thead>
                      <tr> 
                        <th>Ticket Info</th>
                        <th>DateTime</th>
                        <th>To</th>
                        <th>From</th>
                        <th style="text-align:center">Action</th>
                      </tr>
                    </thead>
                    <tbody class="searchable"> 
                    <?php 
					$sql ="SELECT * FROM tblticket_cart WHERE user_id = $session_id";
			        $res = mysqli_query($connection, $sql) or die("Query failed " . mysqli_error($connection));
		           	$sum_total = 0;
					while($row1 = mysqli_fetch_array($res)){
					$ticket_id = $row1['ticket_id'];
					$query = "SELECT * FROM view_tickets WHERE id =  $ticket_id";
			        $result = mysqli_query($connection, $query) or die("Database query failed: " . mysqli_error($connection));
					while ($row = mysqli_fetch_array($result)) {
					
					 ?>
                     
                      <tr> 
                        <td>
                        <strong>No.</strong><?php echo $row['id']; ?><br/>
                        <strong>Seat No.</strong><?php echo $row['seat_no']; ?><br/>
                        <strong>Cost. KES </strong><?php echo $row['ticket_cost']; ?>/-
                       </td>
                        <td><?php echo $row['schedule_date'].'-'.$row['schedule_time']; ?><br />
                         <strong><small>(<?php echo $row['ticket_type'];?>)</small></strong></td>
                        <td><?php $to = $row['train_to_id'];
						$sql3 = "SELECT * FROM tblstations WHERE id = $to";
			            $stations = mysqli_query($connection, $sql3) or die("Database query failed: " . mysqli_error($connection));
					    while ($station = mysqli_fetch_array($stations)) {
					         echo $station['station_name'].'<br/> ('.$station['station_city'].')';	
					          }
					?></td>
                        <td><?php $from = $row['train_from_id'];
						$sql3 = "SELECT * FROM tblstations WHERE id = $from";
			            $stations = mysqli_query($connection, $sql3) or die("Database query failed: " . mysqli_error($connection));
					    while ($station = mysqli_fetch_array($stations)) {
					         echo $station['station_name'].'<br/> ('.$station['station_city'].')';	
					          } ?></td>
                     
                        <td style="text-align:center;" >
                       <a href="tickets.php?deleteid=<?php echo $row1['cart_id'] ?>"  onclick="return confirm('Remove this?')" title="Remove Ticket" name="add_cart_btn" class="btn btn-danger btn-xs" ><span class="glyphicon glyphicon-trash"></span></a>
                       </td>
                      </tr>
                    </form>
                      <?php   
					  $sum_total += $row['ticket_cost'];
					  }
					   
					}?>
                    </tbody>
                  </table>               
 
 </div>
 <div class="col-md-4">
 <h2>CHECKOUT</h2>
       <div class="alert alert-danger">
       To Lipa Na M-PESA, go to the M-PESA Menu, select Lipa Na M-PESA and select Buy Goods and services, then enter the Till Number that the merchants will display, and follow subsequent prompts to complete the transactions. Both you and the merchant will then get confirmation messages from M-PESA.
       
       </div> 
        
        <img src="img/safaricom-logo.jpg"  />
        <h4><b>Till Number : 12345</b></h4>
      
      
       
       
        <form action="tickets.php" method="post">
        
          
         <label>Amount to Pay</label>
        <input class="form-control" type="text" name="amt" value="<?php echo $sum_total; ?>" style="background-color: #CFF;font-weight:600;"  readonly>
         <br>
         <label>Enter the transaction code</label>
         <input class="form-control" type="text" name="code"  required>
         <br>
       <input class="btn btn-primary" type="submit" name="pay_btn"  value="PAY">
       <br />
        </form>
    <br />
       <br />
 
  
 </div> 
 
  <hr style="clear:both;margin: 10px 0px;" /> 
 </div>
  
<?php require_once('includes/footer-template.php'); //include footer template ?>
