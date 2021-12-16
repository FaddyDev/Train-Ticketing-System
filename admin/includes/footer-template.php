<footer class="footer">
      <div class="container">
        <hr/>
        <p class="text-muted">2016 &copy; Sidney Masaka</p>
      </div>
 </footer> 

   <script src="../js/less.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap-timepicker.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#timepicker1').timepicker();
			$('[data-toggle="tooltip"]').tooltip(); 
			
			(function ($) {

        $('#filter').keyup(function () {

            var rex = new RegExp($(this).val(), 'i');
            $('.searchable tr').hide();
            $('.searchable tr').filter(function () {
                return rex.test($(this).text());
            }).show();

        })

    }(jQuery));

	
			});
			
	 
  </script>     
  

</body>
</html>