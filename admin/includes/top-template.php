<!DOCTYPE html>
<html lang="en">
<head>
  <title>Train Express | Admin</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/sticky-footer.css">
  <link rel="stylesheet" href="../css/custom.css">
  <link href="../css/prettify-1.0.css" rel="stylesheet">  
  <link rel="stylesheet/less" type="text/css" href="../css/timepicker.less" /> 
   <script src="../js/jquery.min.js"></script>
   <script src="../js/bootstrap.min.js"></script> 
   <script src="../js/datetime.js"></script>      


  <!--Admin Style sheet -->
  <style>
  <!--
 .sign-nav li a {
    margin-right: 0px;
    padding: 5px 10px;
    text-decoration: none;
    text-transform: none;
}

.nav-pills li a:after{display:none;}
.nav-pills li a{
	background:#E51837;
	 color:#fff;   
    font-weight: 500;
	font-size: 17px;
    padding: 10px 15px 8px 15px;
    border-radius: 0px;
}
.nav-pills li a:hover, .nav .open>a, .nav .open>a:focus, .nav .open>a:hover{color: #E51837;}
.dropdown-menu li a {background: #008FBB;}
.caret{
    border-top: 5px dashed;
    border-top: 5px solid\9;
    border-right: 5px solid transparent;
    border-left: 5px solid transparent;	
    float: right;
    margin-top: 10px;}
 
  -->
  </style>
  
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
<body style ="background-color: #287D25;" onload=display_ct();>


<!-- header -->
<header>
<div class="container" style="padding:0px">
 <div class="page-header">
  <h1 align="center" class="logo-img"><img src="../img/logo.png" /></h1> 
 
  <ul class="nav sign-nav">
  <li class="date-time"><span id='ct' ></span></li>
  </ul>
  <ul class="nav sign-nav" style="left:15px;">
    
     
    <li><a href="#"><em>Welcome Administrator</em></a></li>
    <li><a href="logout.php" style="color: #0490C7; text-decoration: underline;">Logout</a></li>
     
  </ul>
 </div>
 
 
 </div>
</header>
<!-- header --> 