 <h2>Search Ticket</h2>
 <script>
 function validate_search_form(){
	 var To = document.searchform.to.value;
	 var From = document.searchform.from.value;
	 var Traveldate = document.searchform.traveldate.value;
	 
	 if(To==""){
		 alert('Please Select a destination To');
		 return false;
		 }
	if(From==""){
		 alert('Please Select a destination From');
		 return false;
		 }
		 
		 if(From==To){
		 alert('Please Select a different destination To/From');
		 return false;
		 }
		 
		 if(Traveldate == ""){
			 alert('Please select a travel date/time');
			 return false;
			 }
	 
	 return true;
	 }
  </script>
      <form action="index.php" method="GET" name="searchform" onsubmit="return validate_search_form();" >
        <label>Select To</label>
        <select class="form-control" name="to">
             <option></option>
             <?php
                 $query = "SELECT * FROM tblstations ORDER BY station_city ASC";
                 $result = mysqli_query($connection, $query) or die("Database query failed: " . mysqli_error($connection));
             
                 while ($row = mysqli_fetch_array($result)) {
                     echo '<option value="'.$row['id'].'">'.$row['station_name'].' ('.$row['station_city'].')</option>';
                   }
              ?>
        </select><br>
        <label>Select From</label>
        <select class="form-control" name="from">
         <option></option>
              <?php
                 $query = "SELECT * FROM tblstations ORDER BY station_city ASC";
                 $result = mysqli_query($connection, $query) or die("Database query failed: " . mysqli_error($connection));
             
                 while ($row = mysqli_fetch_array($result)) {
                     echo '<option value="'.$row['id'].'">'.$row['station_name'].' ('.$row['station_city'].')</option>';
                   }
              ?>
        </select><br>
           
        <label>Date and Time of Travel</label>
        <div class="form-group">
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' class="form-control" name="traveldate"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
            
        <input type="submit" class="btn btn-primary" style="float: right;" value="search" name="search_schedule" />
        </form>
        <div style="clear:both"></div>            
     <hr>   
     <h3><b>3 steps to book your tickets</b></h3> 
     <ul class="steps">
     <li><i class="glyphicon glyphicon-search"></i> Search for your train tickets </li>
      <li><i class="glyphicon glyphicon-thumbs-up"></i> Book with us no hidden fees </li> 
       <li><i class="glyphicon glyphicon-tag"></i> Get your ticket fast and easily </li>   
     </ul>    