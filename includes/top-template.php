<?php 
    //get logged in firstname and lastname
	          if(isset($_SESSION['userid'])){
				  $session_id = $_SESSION['userid'];
			  $query = "SELECT * FROM tblcustomers WHERE id = $session_id";
			  $result = mysqli_query($connection, $query) or die("Database query failed: " . mysqli_error($connection));  
			  while($row = mysqli_fetch_array($result)){
				  $session_fname = $row['firstname'];
				  $session_lname = $row['lastname'];
				  }
			  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Train Express</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/sticky-footer.css">
  <link rel="stylesheet" href="css/custom.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/datetime.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/moment-with-locales.js"></script>
  <script src="js/bootstrap-datetimepicker.js"></script>
  <link href="css/bootstrap-datetimepicker.css" rel="stylesheet">
       <!--print script -->
     <script language="javascript" type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the pages HTML with divs HTML only
            document.body.innerHTML = 
              "<html><head><title></title></head><body>" + 
              divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;

          
        }
    </script>

  
  
</head>
<body onload=display_ct();>


<!-- header -->
<header>
<div class="container" style="padding:0px;">
 <div class="page-header">
  <h1 align="center" class="logo-img"><img src="img/logo.png" /></h1> 
  <ul class="nav sign-nav">
    <li class="welcome-guest">
	<?php if(!isset($_SESSION['userid'])){?>
    Welcome Guest
    <?php } else {
     echo 'Welcome '.$session_fname.' '.$session_lname;
	}
   ?>
   </li>
    <li class="date-time"><span id='ct' ></span></li>
  </ul>

  <ul class="nav nav-tabs">
    <li><a href="index.php">Home</a></li>
    <?php if(!isset($_SESSION['userid'])){?> <li><a href="login.php">Login</a></li>
    <?php } else { ?>
    <li><a href="index.php">Tickets</a></li>
    <li><a href="account.php">My Account</a></li>
    <li><a href="logout.php">Logout</a></li>
    <?php } ?>    
     <li><a href="contact.php">Contact</a></li> 
  </ul> 
  </div>
 
 
 </div>
</header>
<!-- header --> 