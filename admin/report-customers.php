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
       <h2>Registered Customers Report</h2> 
       <div class="input-group" style="width:50%;"> <span class="input-group-addon">Search</span>
      <input id="filter"   type="text" class="form-control" placeholder="Search">
      </div>
      <button type="button" class="btn btn-info btn-sm" style="float:right;margin-top: -30px;" onclick="javascript:printDiv('print')"><span class="glyphicon glyphicon-print"></span> Print Report</button>
                     
<br>
       <div id="print">
       <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>Customer's Names</th>
                        <th>Gender</th>
                        <th>Phone</th>
                      </tr>
                    </thead>
                    <tbody class="searchable">
                    
                    <?php 
					$query = "SELECT * FROM tblcustomers ORDER BY `firstname` ASC";
			        $result = mysqli_query($connection,$query) or die("Database query failed: " . mysqli_error($connection));
					$count = 1; 
			        while ($row = mysqli_fetch_array($result)) {
					
					 ?>
                      
                      <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['title'].' '.$row['firstname'].' '.$row['lastname']; ?> </td>
                        <td><?php echo $row['gender']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                       
                      </tr>
                    
                      <?php  
					  $count++; 
					  } ?>
                    </tbody>
                      <tfoot>
                    <tr>
                    <td colspan="3" style="background: #E51837;"></td>
                    <td colspan="2"><h3><strong>Total Registered: <?php  echo $count-1; ?></strong></h3></td>
                    </tr>
                    </tfoot>
                  </table>  
                  </div>             
       </div>
       </div>
    


</div>
  
 
  
<?php require_once('includes/footer-template.php'); //include footer template ?>