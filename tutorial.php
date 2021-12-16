<?php require_once('includes/connection.php');  //include connection?>
<?php require_once('includes/session.php');  //include session?>

<?php require_once('includes/top-template.php'); //include the template top ?>


<div class="container">

<div class="col-md-6">
 <h2>Booking Tutorial</h2>
<dl class="faq">

	<dt>Log into your account or sign up if you have not created an account</dt>
	<dd><a href="signin.php">Sign In</a> OR <a href="signup.php">Sign Up</a></dd>
    
    <dt>Update your account information or change your password in your account page</dt>
	<dd><a href="account.php">My Account</a></dd>
	
	<dt>Search through the scheduled trains </dt>
	<dd><a href="schedule.php">Train Schedule</a></dd>
	
	<dt>Purchase the ticket and print your ticket</dt>
	<dd><a href="tickets.php">Tickets</a></dd>
	
</dl>
 
 </div>
 
 
 <div class="col-md-6">
<div class="contact">
			<p>
				Any inquiries kindly Call: <span>+254 720000000</span>
			</p>
	  </div>
 
 
 </div>


</div>
  
 
  
<?php require_once('includes/footer-template.php'); //include footer template ?>
