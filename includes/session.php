<?php  

	session_start();
     //customer logged in session
		function logged_in() {
		return isset($_SESSION['userid']);
	     }
	
	function confirm_logged_in() {
		if (!logged_in()) {
			header("Location: login.php");
		}
	}
		
		
		
		  //admin logged in session
		function admin_logged_in() {
		return isset($_SESSION['adminid']);
	     }
	
	    function confirm_admin_logged_in() {
		if (!admin_logged_in()) {
			header("Location: login.php");
		}
	}
		





    

	 

	 

	 

?>